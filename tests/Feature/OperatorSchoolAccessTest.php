<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OperatorSchoolAccessTest extends TestCase
{
    /**
     * Test 1: Verify all operator accounts in DB are linked to a valid Sekolah ID.
     */
    public function test_all_operator_accounts_have_valid_sekolah_id(): void
    {
        $operators = User::where('role', 'OPERATOR_SEKOLAH')->get();
        $this->assertNotEmpty($operators, 'Harus ada akun Operator Sekolah di database.');

        $invalidOperators = [];

        foreach ($operators as $operator) {
            if (empty($operator->sekolah_id)) {
                $invalidOperators[] = "User ID {$operator->id} ({$operator->username}) tidak punya sekolah_id.";
                continue;
            }

            $sekolahExists = Sekolah::where('id', $operator->sekolah_id)->exists();
            if (!$sekolahExists) {
                $invalidOperators[] = "User ID {$operator->id} ({$operator->username}) terhubung ke sekolah_id {$operator->sekolah_id} yang tidak ada di tabel sekolahs.";
            }
        }

        $this->assertEmpty($invalidOperators, "Ditemukan operator yang bermasalah:\n" . implode("\n", $invalidOperators));
    }

    /**
     * Test 2: Verify Operator login lands on Dashboard safely without 403 or school link leaks.
     */
    public function test_operator_dashboard_access_and_scoping(): void
    {
        $operator = User::where('role', 'OPERATOR_SEKOLAH')->whereNotNull('sekolah_id')->first();
        $this->assertNotNull($operator, 'Operator dengan sekolah_id valid harus ditemukan.');

        $response = $this->actingAs($operator)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Kelola Data Pegawai');
        // Ensure no prohibited link to /sekolah in dashboard for operator
        $response->assertDontSee('href="' . route('sekolah.index') . '"', false);
    }

    /**
     * Test 3: Verify Operator Pegawai list is strictly scoped to their own school.
     */
    public function test_operator_pegawai_list_is_scoped_to_their_school(): void
    {
        $operator = User::where('role', 'OPERATOR_SEKOLAH')->whereNotNull('sekolah_id')->first();
        $this->assertNotNull($operator);

        $response = $this->actingAs($operator)->get('/pegawai');

        $response->assertStatus(200);

        // Fetch pegawai records returned to view
        $pegawais = $response->viewData('pegawais');
        
        foreach ($pegawais as $pegawai) {
            $belongsToSchool = $pegawai->sekolahs->contains('id', $operator->sekolah_id);
            $this->assertTrue(
                $belongsToSchool,
                "Pegawai ID {$pegawai->id} ({$pegawai->nama_lengkap}) bukan milik sekolah ID {$operator->sekolah_id} milik operator."
            );
        }
    }

    /**
     * Test 4: Verify Operator gets 403 Forbidden when trying to access /sekolah route directly.
     */
    public function test_operator_cannot_access_sekolah_management_route(): void
    {
        $operator = User::where('role', 'OPERATOR_SEKOLAH')->whereNotNull('sekolah_id')->first();
        $this->assertNotNull($operator);

        $response = $this->actingAs($operator)->get('/sekolah');

        $response->assertStatus(403);
    }

    /**
     * Test 5: Verify Operator Pegawai list matches EXACTLY what Admin sees when filtering by that school.
     */
    public function test_operator_pegawai_list_matches_admin_filtered_school_list(): void
    {
        $admin = User::where('role', 'ADMIN_DINAS')->first();
        $this->assertNotNull($admin, 'Harus ada user Admin Dinas.');

        // Pick 5 sample schools that have pegawais
        $sekolahs = Sekolah::has('pegawais')->take(5)->get();
        $this->assertNotEmpty($sekolahs, 'Harus ada sekolah yang memiliki pegawai.');

        foreach ($sekolahs as $sekolah) {
            $operator = User::where('role', 'OPERATOR_SEKOLAH')->where('sekolah_id', $sekolah->id)->first();
            if (!$operator) {
                continue; // Skip if no operator seeded for this school
            }

            // 1. Admin filter by sekolah_id
            $adminResponse = $this->actingAs($admin)->get("/pegawai?sekolah_id={$sekolah->id}");
            $adminResponse->assertStatus(200);
            $adminPegawais = $adminResponse->viewData('pegawais')->pluck('id')->sort()->values()->toArray();
            $adminTotalCount = $adminResponse->viewData('totalPegawaiCount');

            // 2. Operator login and view /pegawai
            $operatorResponse = $this->actingAs($operator)->get('/pegawai');
            $operatorResponse->assertStatus(200);
            $operatorPegawais = $operatorResponse->viewData('pegawais')->pluck('id')->sort()->values()->toArray();
            $operatorTotalCount = $operatorResponse->viewData('totalPegawaiCount');

            // Assert exact match in IDs and Total Count
            $this->assertEquals(
                $adminPegawais,
                $operatorPegawais,
                "Daftar ID Pegawai untuk sekolah {$sekolah->nama_sekolah} (ID: {$sekolah->id}) tidak cocok antara Admin dan Operator!"
            );

            $this->assertEquals(
                $adminTotalCount,
                $operatorTotalCount,
                "Total Count Pegawai untuk sekolah {$sekolah->nama_sekolah} (ID: {$sekolah->id}) tidak cocok antara Admin ({$adminTotalCount}) dan Operator ({$operatorTotalCount})!"
            );
        }
    }

    /**
     * Test 6: Verify Operator cannot view or edit detail of another school's pegawai via direct URL.
     */
    public function test_operator_cannot_view_or_edit_other_school_pegawai_detail(): void
    {
        $operatorA = User::where('role', 'OPERATOR_SEKOLAH')->whereNotNull('sekolah_id')->first();
        $this->assertNotNull($operatorA);

        // Find a pegawai that belongs to a different school
        $otherPegawai = Pegawai::whereDoesntHave('sekolahs', fn($q) => $q->where('sekolahs.id', $operatorA->sekolah_id))->first();
        $this->assertNotNull($otherPegawai, 'Pegawai milik sekolah lain harus ada.');

        // Attempting to show detail of other school's pegawai
        $showResponse = $this->actingAs($operatorA)->get("/pegawai/{$otherPegawai->id}");
        $showResponse->assertStatus(403);

        // Attempting to edit other school's pegawai
        $editResponse = $this->actingAs($operatorA)->get("/pegawai/{$otherPegawai->id}/edit");
        $editResponse->assertStatus(403);
    }
}

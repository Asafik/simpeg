/**
 * SIMPEG-SP Tables & Pagination Helper Module
 * Manages table bulk actions, checkbox selection, and auto-filters.
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Bulk Select & Checkbox Handler
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.pegawai-checkbox, .table-checkbox');
    const bulkActionBar = document.getElementById('bulkActionBar');
    const selectedCountBadge = document.getElementById('selectedCountBadge');

    function updateBulkBar() {
        const checked = document.querySelectorAll('.pegawai-checkbox:checked, .table-checkbox:checked');
        const count = checked.length;

        if (selectedCountBadge) {
            selectedCountBadge.textContent = count;
        }

        if (bulkActionBar) {
            if (count > 0) {
                bulkActionBar.classList.remove('hidden');
            } else {
                bulkActionBar.classList.add('hidden');
            }
        }

        if (selectAll && checkboxes.length > 0) {
            selectAll.checked = (checked.length === checkboxes.length);
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkBar();
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkBar);
    });

    window.unselectAllCheckboxes = function () {
        if (selectAll) selectAll.checked = false;
        checkboxes.forEach(cb => cb.checked = false);
        updateBulkBar();
    };

    // 2. Auto-Filter Trigger with Loading Overlay
    const autoFilterSelects = document.querySelectorAll('.js-auto-filter');
    autoFilterSelects.forEach(function (selectEl) {
        selectEl.addEventListener('change', function () {
            if (typeof showLoadingOverlay === 'function') {
                showLoadingOverlay('Memuat Data...', 'Sistem sedang memproses filter tabel...');
            }
            if (this.form) {
                this.form.submit();
            }
        });
    });
});

/**
 * Trigger loading overlay on single filter form submit
 */
window.triggerTableFilter = function (el) {
    if (typeof showLoadingOverlay === 'function') {
        showLoadingOverlay('Memproses Filter...', 'Menyaring master data berdasarkan kriteria...');
    }
    if (el && el.form) {
        el.form.submit();
    }
};

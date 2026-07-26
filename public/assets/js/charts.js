/* ===== SIMPEG-SP CHARTS JS INITIALIZATION (DYNAMIC THEMES & DARK MODE) ===== */
document.addEventListener('DOMContentLoaded', function() {

    const theme = localStorage.getItem('simpegTheme') || 'deep_blue';

    // Theme Color Mapping
    let primaryColor = '#1e40af';
    let doughnutColors = ['#1e40af', '#10b981', '#f59e0b', '#ec4899'];
    let barColors = ['#a78bfa', '#7c3aed', '#5b21b6', '#4c1d95'];
    let lineRgbaStart = 'rgba(30, 64, 175, 0.25)';
    let lineRgbaEnd = 'rgba(30, 64, 175, 0.01)';
    let tickColor = '#94a3b8';

    if (theme === 'emerald') {
        primaryColor = '#047857';
        doughnutColors = ['#047857', '#10b981', '#f59e0b', '#ec4899'];
        barColors = ['#6ee7b7', '#10b981', '#047857', '#064e3b'];
        lineRgbaStart = 'rgba(4, 120, 87, 0.25)';
        lineRgbaEnd = 'rgba(4, 120, 87, 0.01)';
    } else if (theme === 'purple') {
        primaryColor = '#6b21a8';
        doughnutColors = ['#6b21a8', '#9333ea', '#f59e0b', '#ec4899'];
        barColors = ['#c084fc', '#9333ea', '#6b21a8', '#4c1d95'];
        lineRgbaStart = 'rgba(107, 33, 168, 0.25)';
        lineRgbaEnd = 'rgba(107, 33, 168, 0.01)';
    } else if (theme === 'dark') {
        primaryColor = '#3b82f6';
        doughnutColors = ['#3b82f6', '#10b981', '#f59e0b', '#ec4899'];
        barColors = ['#60a5fa', '#3b82f6', '#2563eb', '#1d4ed8'];
        lineRgbaStart = 'rgba(59, 130, 246, 0.35)';
        lineRgbaEnd = 'rgba(59, 130, 246, 0.01)';
        tickColor = '#cbd5e1';
    }

    // === CHART 1: Status Kepegawaian (Doughnut) ===
    const ctx1 = document.getElementById('statusChart');
    if (ctx1) {
        new Chart(ctx1.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['PNS', 'PPPK', 'PPPK PW', 'Non-ASN'],
                datasets: [{
                    data: [547, 386, 94, 257],
                    backgroundColor: doughnutColors,
                    borderWidth: 0,
                    borderRadius: 6,
                    spacing: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            padding: 14,
                            font: { size: 11, weight: '500' },
                            color: tickColor
                        }
                    }
                }
            }
        });
    }

    // === CHART 2: Sebaran Usia (Bar) ===
    const ctx2 = document.getElementById('usiaChart');
    if (ctx2) {
        new Chart(ctx2.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['< 30 thn', '31-40 thn', '41-50 thn', '> 55 thn'],
                datasets: [{
                    label: 'Jumlah Pegawai',
                    data: [186, 428, 512, 158],
                    backgroundColor: barColors,
                    borderRadius: 6,
                    barPercentage: 0.55,
                    categoryPercentage: 0.7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: { top: 10, bottom: 0, left: 0, right: 0 }
                },
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 600,
                        grid: { color: 'rgba(255,255,255,0.06)' },
                        ticks: { font: { size: 10, family: 'Inter' }, color: tickColor, stepSize: 150 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, family: 'Inter' }, color: tickColor }
                    }
                }
            }
        });
    }

    // === CHART 3: Recent Movement (Spline Area) ===
    const ctxMovement = document.getElementById('recentMovementChart');
    if (ctxMovement) {
        const ctx = ctxMovement.getContext('2d');
        const gradientFill = ctx.createLinearGradient(0, 0, 0, 220);
        gradientFill.addColorStop(0, lineRgbaStart);
        gradientFill.addColorStop(1, lineRgbaEnd);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Movement',
                    data: [2100, 1550, 1600, 1900, 1580, 1920, 2580, 2450, 2800, 3450, 2900, 3350],
                    borderColor: primaryColor,
                    borderWidth: 2.5,
                    backgroundColor: gradientFill,
                    fill: true,
                    tension: 0.45,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: primaryColor,
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Movement: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        min: 1000,
                        max: 4000,
                        ticks: {
                            stepSize: 1000,
                            font: { size: 11, family: 'Inter' },
                            color: tickColor
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.08)',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 11, family: 'Inter' },
                            color: tickColor
                        }
                    }
                }
            }
        });
    }

});

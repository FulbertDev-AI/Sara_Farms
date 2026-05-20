document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('dashboardChart');
    if (!canvas) {
        return;
    }

    const salesLabels = window.dashboardSalesLabels || [];
    const salesValues = window.dashboardSalesValues || [];

    new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: salesLabels,
            datasets: [{
                label: 'Ventes mensuelles',
                data: salesValues,
                borderColor: 'rgba(44, 94, 67, 0.88)',
                backgroundColor: 'rgba(136, 176, 75, 0.18)',
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 3,
                fill: true,
                tension: 0.3,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#5C6460' }
                },
                y: {
                    grid: { color: 'rgba(43, 45, 47, 0.08)' },
                    ticks: { color: '#5C6460' }
                }
            },
            plugins: {
                legend: {
                    labels: { color: '#2B2D2F' }
                },
                tooltip: {
                    backgroundColor: '#ffffff',
                    titleColor: '#2B2D2F',
                    bodyColor: '#2B2D2F',
                    borderColor: 'rgba(43, 45, 47, 0.12)',
                    borderWidth: 1,
                }
            }
        }
    });
});

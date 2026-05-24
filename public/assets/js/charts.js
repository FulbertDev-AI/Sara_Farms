// Configuration Chart.js pour le dashboard
const chartColors = {
    primary: '#2C5E43',
    secondary: '#88B04B',
    alert: '#D97736',
    bg: 'rgba(255,255,255,0.6)',
    grid: 'rgba(0,0,0,0.05)'
};

function initLineChart(canvasId, labels, data, label = 'Ventes') {
    const ctx = document.getElementById(canvasId).getContext('2d');
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label, data, borderColor: chartColors.primary,
                backgroundColor: 'rgba(44,94,67,0.1)',
                tension: 0.4, fill: true
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, grid: { color: chartColors.grid } } }
        }
    });
}

function initDoughnutChart(canvasId, labels, data) {
    const ctx = document.getElementById(canvasId).getContext('2d');
    return new Chart(ctx, {
        type: 'doughnut',
        data: { labels, datasets: [{ data, backgroundColor: [chartColors.primary, chartColors.secondary, chartColors.alert, '#5A7F67'] }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
    });
}
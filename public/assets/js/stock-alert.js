// Vérification des alertes stock en temps réel (simulation AJAX)
function checkStockAlerts() {
    fetch(`${BASE_URL}api/stock/alerts`)
        .then(res => res.json())
        .then(data => {
            if(data.length > 0) {
                const alertContainer = document.getElementById('stock-alerts-panel');
                if(alertContainer) {
                    alertContainer.innerHTML = `<h4>⚠️ Alertes Stock</h4><ul>${data.map(i => `<li><strong>${i.nom}</strong> : ${i.stock_actuel} / ${i.seuil_alerte}</li>`).join('')}</ul>`;
                    alertContainer.style.display = 'block';
                }
            }
        })
        .catch(err => console.warn('Stock alert check failed:', err));
}

// Vérifier au chargement du dashboard admin
if(window.location.pathname.includes('admin/dashboard')) {
    checkStockAlerts();
    setInterval(checkStockAlerts, 60000); // Rafraîchir chaque minute
}
document.addEventListener('DOMContentLoaded', () => {
    // Ajout au panier avec animation
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.id;
            const qty = this.dataset.qty || 1;
            
            fetch(`${BASE_URL}cart/add/${productId}`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({qty})
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    showToast('Produit ajouté au panier', 'success');
                    updateCartCount(data.count);
                }
            });
        });
    });

    // Mise à jour quantité dans le panier
    document.querySelectorAll('.cart-qty-input').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.dataset.itemid;
            const newQty = parseInt(this.value);
            if(newQty < 1) this.value = 1;
            
            fetch(`${BASE_URL}cart/update/${itemId}`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({qty: this.value})
            })
            .then(() => location.reload());
        });
    });

    function updateCartCount(count) {
        const badge = document.querySelector('.cart-count');
        if(badge) badge.textContent = count;
    }

    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `<p>${message}</p>`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
});
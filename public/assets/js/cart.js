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

    const qtyInputs = document.querySelectorAll('.cart-qty-input');
    if(qtyInputs.length > 0) {
        qtyInputs.forEach(input => {
            input.addEventListener('change', function() {
                handleQtyUpdate(this);
            });

            input.addEventListener('keydown', function(e) {
                if(e.key === 'Enter') {
                    e.preventDefault();
                    handleQtyUpdate(this);
                }
            });

            input.addEventListener('input', debounce(function() {
                handleQtyUpdate(this, false);
            }, 600));
        });
    }

    function handleQtyUpdate(input, reload = true) {
        let qty = parseInt(input.value, 10);
        if(isNaN(qty) || qty < 1) qty = 1;
        input.value = qty;

        const row = input.closest('tr');
        const price = parseFloat(input.dataset.price) || 0;
        const subtotalCell = row.querySelector('.item-subtotal');
        const newSubtotal = price * qty;
        if(subtotalCell) {
            subtotalCell.textContent = formatPrice(newSubtotal);
            subtotalCell.dataset.qty = qty;
            subtotalCell.dataset.price = price;
        }

        updateCartTotal();

        const itemId = input.dataset.itemid;
        fetch(`${BASE_URL}cart/update/${itemId}`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({qty})
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                showToast('Quantité mise à jour', 'success');
                if(reload) {
                    location.reload();
                }
            }
        })
        .catch(() => showToast('Erreur de mise à jour', 'error'));
    }

    function updateCartTotal() {
        const subtotalCells = document.querySelectorAll('.item-subtotal');
        let total = 0;
        subtotalCells.forEach(cell => {
            const price = parseFloat(cell.dataset.price) || 0;
            const qty = parseInt(cell.dataset.qty, 10) || 0;
            total += price * qty;
        });

        const totalValue = document.querySelector('.cart-total-value');
        if(totalValue) {
            totalValue.textContent = formatPrice(total);
        }
    }

    function formatPrice(amount) {
        return new Intl.NumberFormat('fr-FR', {minimumFractionDigits: 0, maximumFractionDigits: 0}).format(amount) + ' FCFA';
    }

    function debounce(fn, delay) {
        let timer;
        return function(...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

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
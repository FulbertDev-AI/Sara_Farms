<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div style="font-size:1.5rem;"></div>
        <span class="logo"><?= SITE_NAME ?></span>
    </div>
    <ul class="sidebar-menu">
        <li><a href="<?= BASE_URL ?>admin/dashboard" class="<?= ($active ?? '') == 'dashboard' ? 'active' : '' ?>">
                <span class="sidebar-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="13" width="5" height="8" rx="1"/><rect x="10" y="8" width="5" height="13" rx="1"/><rect x="17" y="3" width="4" height="18" rx="1"/></svg>
                </span>
                <span>Tableau de bord</span>
            </a></li>
        <li><a href="<?= BASE_URL ?>admin/products/index" class="<?= ($active ?? '') == 'products' ? 'active' : '' ?>">
                <span class="sidebar-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M4 8l8-4 8 4v8l-8 4-8-4V8z"/><path d="M12 2v18" stroke-width="2" stroke="currentColor" fill="none"/></svg>
                </span>
                <span>Produits</span>
            </a></li>
        <li><a href="<?= BASE_URL ?>admin/orders/index" class="<?= ($active ?? '') == 'orders' ? 'active' : '' ?>">
                <span class="sidebar-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M6 6h15l-1.5 9h-12L6 6z"/><circle cx="9" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/></svg>
                </span>
                <span>Commandes</span>
            </a></li>
        <li><a href="<?= BASE_URL ?>admin/stock/index" class="<?= ($active ?? '') == 'stock' ? 'active' : '' ?>">
                <span class="sidebar-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C8.5 5.5 5 7 5 11c0 4 3 6 7 11 4-5 7-7 7-11 0-4-3.5-5.5-7-9z"/></svg>
                </span>
                <span>Stocks & Intrants</span>
            </a></li>
        <li><a href="<?= BASE_URL ?>admin/finance/index" class="<?= ($active ?? '') == 'finance' ? 'active' : '' ?>">
                <span class="sidebar-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M6 6h12v3H6z"/><path d="M6 12h12v3H6z"/><path d="M6 18h12v1H6z"/></svg>
                </span>
                <span>Finance</span>
            </a></li>
        <li style="margin-top:2rem; padding-top:1rem; border-top:1px solid rgba(255,255,255,0.2);">
            <a href="<?= BASE_URL ?>home" target="_blank">
                <span class="sidebar-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                </span>
                <span>Voir le site</span>
            </a>
        </li>
    </ul>
</aside>
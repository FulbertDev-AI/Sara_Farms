<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div style="font-size:1.5rem;"></div>
        <span class="logo"><?= SITE_NAME ?></span>
    </div>
    <ul class="sidebar-menu">
        <li><a href="<?= BASE_URL ?>admin/dashboard" class="<?= ($active ?? '') == 'dashboard' ? 'active' : '' ?>"><span>📊</span><span>Tableau de bord</span></a></li>
        <li><a href="<?= BASE_URL ?>admin/products/index" class="<?= ($active ?? '') == 'products' ? 'active' : '' ?>"><span>📦</span><span>Produits</span></a></li>
        <li><a href="<?= BASE_URL ?>admin/orders/index" class="<?= ($active ?? '') == 'orders' ? 'active' : '' ?>"><span>🛒</span><span>Commandes</span></a></li>
        <li><a href="<?= BASE_URL ?>admin/stock/index" class="<?= ($active ?? '') == 'stock' ? 'active' : '' ?>"><span>🌱</span><span>Stocks & Intrants</span></a></li>
        <li><a href="<?= BASE_URL ?>admin/finance/index" class="<?= ($active ?? '') == 'finance' ? 'active' : '' ?>"><span>💰</span><span>Finance</span></a></li>
        <li style="margin-top:2rem; padding-top:1rem; border-top:1px solid rgba(255,255,255,0.2);">
            <a href="<?= BASE_URL ?>home" target="_blank"><span>👁️</span><span>Voir le site</span></a>
        </li>
    </ul>
</aside>
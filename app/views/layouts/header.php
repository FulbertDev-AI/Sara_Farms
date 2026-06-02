<?php require_once __DIR__ . '/../../../config/constants.php'; ?>
<?php require_once __DIR__ . '/../../../includes/helpers.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> | <?= $pageTitle ?? 'Accueil' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
</head>
<body>
    <?php if(isset($_SESSION['flash'])): ?>
<div style="background:var(--secondary);color:#fff;padding:1rem;text-align:center;position:fixed;top:0;left:0;width:100%;z-index:1000;">
    <?= htmlspecialchars($_SESSION['flash']['message']) ?>
    <?php unset($_SESSION['flash']); ?>
</div>
<?php endif; ?>
    <header class="glass">
        <div class="container">
            <nav>
                <a href="<?= BASE_URL ?>" class="logo"><?= SITE_NAME ?></a>
                <div class="mobile-toggle">&#9776;</div>
                <ul class="nav-links">
                    <li><a href="<?= BASE_URL ?>home" class="<?= ($active ?? '') == 'home' ? 'active' : '' ?>">Accueil</a></li>
                    <li><a href="<?= BASE_URL ?>services" class="<?= ($active ?? '') == 'services' ? 'active' : '' ?>">Services</a></li>
                    <li><a href="<?= BASE_URL ?>shop" class="<?= ($active ?? '') == 'shop' ? 'active' : '' ?>">Boutique</a></li>
                    <li><a href="<?= BASE_URL ?>contact" class="<?= ($active ?? '') == 'contact' ? 'active' : '' ?>">Contact</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="<?= BASE_URL ?>cart">Panier</a></li>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <li><a href="<?= BASE_URL ?>admin/dashboard">Administration</a></li>
                        <?php endif; ?>
                        <li><a href="<?= BASE_URL ?>auth/logout" class="btn" style="padding:6px 12px;">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="<?= BASE_URL ?>auth/login" class="btn" style="padding:6px 12px;">Connexion</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
<?php
$connectedUser = $_SESSION['user'] ?? null;
$menuItems = [
    ['label' => 'Accueil', 'route' => 'home'],
    ['label' => 'Catalogue', 'route' => 'catalogue'],
];
if ($connectedUser && $connectedUser['role'] === 'admin') {
    $menuItems[] = ['label' => 'Tableau de bord', 'route' => 'dashboard'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sara Farms</title>
    <link rel="stylesheet" href="assets/css/variables.css">
    <link rel="stylesheet" href="assets/css/layout.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
<header class="site-header page-shell">
    <a class="site-brand" href="?route=home">
        <svg viewBox="0 0 48 48" aria-hidden="true" role="img">
            <path d="M12 24C12 16.268 18.268 10 26 10s14 6.268 14 14-6.268 14-14 14S12 31.732 12 24z"/>
            <path d="M26 4v8M26 36v8M4 26h8M36 26h8M10 10l5 5M33 33l5 5M10 38l5-5M33 15l5-5"/>
        </svg>
        <div>
            <div class="site-title">Sara Farms</div>
            <div class="site-description">Gestion agricole moderne et réactive</div>
        </div>
    </a>

    <button class="nav-toggle" type="button" aria-label="ouvrir le menu"><span></span></button>

    <nav class="navbar">
        <?php foreach ($menuItems as $link): ?>
            <a href="?route=<?= htmlspecialchars($link['route']) ?>"><?= htmlspecialchars($link['label']) ?></a>
        <?php endforeach; ?>
        <?php if ($connectedUser): ?>
            <span><?= htmlspecialchars($connectedUser['prenom'] . ' ' . $connectedUser['nom']) ?></span>
            <a href="?route=logout">Déconnexion</a>
        <?php else: ?>
            <a class="button-primary" href="?route=login">Connexion</a>
        <?php endif; ?>
    </nav>
</header>
<main class="page-shell page-content">

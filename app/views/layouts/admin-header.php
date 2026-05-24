<?php require_once __DIR__ . '/../../../../config/constants.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> | Admin - <?= $pageTitle ?? 'Dashboard' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="admin-wrapper">
    <!-- Sidebar chargée ici -->
    <?php require_once __DIR__ . '/admin-sidebar.php'; ?>
    
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar glass">
            <button class="toggle-sidebar" id="toggleSidebar">&#9776;</button>
            <div class="user-info">
                <div class="user-avatar"><?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?></div>
                <span><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></span>
                <a href="<?= BASE_URL ?>auth/logout" class="btn btn-sm btn-outline" style="margin-left:1rem;">Déconnexion</a>
            </div>
        </div>
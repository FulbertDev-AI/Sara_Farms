<?php
$connectedUser = $_SESSION['user'] ?? null;
?>
<aside class="card" style="margin-bottom: 24px;">
    <nav>
        <a href="?route=dashboard">Tableau de bord</a>
        <a href="?route=catalogue">Catalogue</a>
        <a href="?route=home">Accueil</a>
        <?php if ($connectedUser): ?>
            <a href="?route=logout">Déconnexion</a>
        <?php endif; ?>
    </nav>
</aside>

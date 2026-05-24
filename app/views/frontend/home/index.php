<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<section class="hero fade-in" style="text-align:center; padding: 4rem 0;">
    <div class="container">
        <h1 style="font-size: 2.8rem; color: var(--primary); margin-bottom: 1rem;">Bienvenue chez Sara Farms</h1>
        <p style="max-width: 700px; margin: 0 auto 2rem; font-size: 1.1rem;">
            Une exploitation agricole moderne dédiée à la production de qualité, 
            à l'élevage responsable et à la formation des acteurs du secteur.
        </p>
        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
            <a href="<?= BASE_URL ?>shop" class="btn">Découvrir nos produits</a>
            <a href="<?= BASE_URL ?>services" class="btn btn-outline">Nos services</a>
        </div>
    </div>
</section>

<section class="container fade-in">
    <h2 style="text-align:center; margin-bottom: 2rem; color: var(--primary);">Nos atouts</h2>
    <div class="grid">
        <div class="card glass">
            <h3>Produits Frais</h3>
            <p>Récoltés et livrés dans les meilleures conditions pour garantir fraîcheur et saveur.</p>
        </div>
        <div class="card glass">
            <h3>Élevage Raisonné</h3>
            <p>Respect du bien-être animal et utilisation d'aliments sains et contrôlés.</p>
        </div>
        <div class="card glass">
            <h3>Expertise & Formation</h3>
            <p>Accompagnement technique pour les agriculteurs débutants et confirmés.</p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
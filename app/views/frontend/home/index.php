<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<section class="hero fade-in hero-section" style="background-image:url('<?= BASE_URL ?>assets/images/hero-section.png');">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <p class="eyebrow">Agriculture moderne & éthique</p>
        <h1>Bienvenue chez Sara Farms</h1>
        <p class="hero-text">Une exploitation agricole moderne dédiée à la production de qualité, à l'élevage responsable et à la formation des acteurs du secteur.</p>
        <div class="hero-actions">
            <a href="<?= BASE_URL ?>shop" class="btn">Découvrir nos produits</a>
            <a href="<?= BASE_URL ?>services" class="btn btn-outline">Nos services</a>
        </div>
    </div>
</section>

<section class="container fade-in">
    <div class="section-header">
        <span class="section-label">Nos Atouts</span>
        <h2>Pourquoi choisir Sara Farms ?</h2>
        <p>Nous combinons savoir-faire traditionnel et innovations durables pour offrir des produits sains et un service de confiance.</p>
    </div>
    <div class="grid">
        <div class="card glass">
            <h3>Qualité et fraîcheur</h3>
            <p>Tous nos produits sont cueillis au bon moment et préparés avec soin pour conserver leur goût naturel.</p>
        </div>
        <div class="card glass">
            <h3>Élevage responsable</h3>
            <p>Nos animaux sont élevés dans le respect de leur bien-être et nourris avec des aliments sains.</p>
        </div>
        <div class="card glass">
            <h3>Accompagnement personnalisé</h3>
            <p>Nous conseillons les agriculteurs et partageons notre expertise pour renforcer les pratiques durables.</p>
        </div>
    </div>
</section>

<section class="container fade-in highlight-section">
    <div class="highlight-card glass">
        <div>
            <span class="section-label">Nos services</span>
            <h2>Des solutions pour chaque besoin agricole</h2>
            <p>De la boutique en ligne aux formations, nous offrons un accompagnement complet pour les producteurs et les consommateurs.</p>
        </div>
        <div class="highlight-list">
            <div class="feature-item">
                <h4>Produits locaux</h4>
                <p>Fruits, légumes, viande et produits laitiers sélectionnés avec soin.</p>
            </div>
            <div class="feature-item">
                <h4>Formations</h4>
                <p>Ateliers et coaching pour améliorer les rendements et les méthodes durables.</p>
            </div>
            <div class="feature-item">
                <h4>Livraison rapide</h4>
                <p>Commandez en ligne et recevez vos produits frais directement à domicile.</p>
            </div>
        </div>
    </div>
</section>

<section class="container fade-in testimonials-section">
    <div class="section-header">
        <span class="section-label">Témoignages</span>
        <h2>Ils nous font confiance</h2>
        <p>Découvrez ce que disent nos clients et partenaires de l'expérience Sara Farms.</p>
    </div>
    <div class="grid">
        <div class="card glass testimonial-card">
            <p class="quote">"Sara Farms propose des produits vraiment frais et un service client très humain. Je recommande sans hésiter."</p>
            <p class="author">Fatoumata, cliente fidèle</p>
        </div>
        <div class="card glass testimonial-card">
            <p class="quote">"Les formations ont changé notre façon de travailler. Nous sommes plus efficaces et respectons mieux les normes."</p>
            <p class="author">Abdou, agriculteur</p>
        </div>
        <div class="card glass testimonial-card">
            <p class="quote">"Qualité, rapidité de livraison et des produits dont on peut être fier. Le site est simple et agréable."</p>
            <p class="author">Aïcha, consommatrice</p>
        </div>
    </div>
</section>

<section class="container fade-in cta-section">
    <div class="cta-card glass">
        <div>
            <h2>Prêt à découvrir nos produits ?</h2>
            <p>Visitez notre boutique et profitez de la meilleure sélection du marché, livrée rapidement chez vous.</p>
        </div>
        <a href="<?= BASE_URL ?>shop" class="btn">Voir la boutique</a>
    </div>
</section>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
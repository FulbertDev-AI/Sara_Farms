<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<section class="container fade-in" style="max-width:500px; margin: 2rem auto;">
    <div class="card glass">
        <h2 style="text-align:center; margin-bottom:1.5rem; color:var(--primary);">Inscription</h2>
        <form method="POST" action="<?= BASE_URL ?>auth/processRegister">
            <div class="form-group"><label>Nom</label><input type="text" name="nom" required></div>
            <div class="form-group"><label>Prénom</label><input type="text" name="prenom" required></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Téléphone</label><input type="tel" name="tel"></div>
            <div class="form-group"><label>Mot de passe</label><input type="password" name="password" required></div>
            <button type="submit" class="btn" style="width:100%;">Créer mon compte</button>
        </form>
        <p style="text-align:center; margin-top:1rem;">Déjà inscrit ? <a href="<?= BASE_URL ?>auth/login" style="color:var(--secondary);">Connectez-vous</a></p>
    </div>
</section>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
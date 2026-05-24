<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<section class="container fade-in" style="max-width:500px; margin: 2rem auto;">
    <div class="card glass">
        <h2 style="text-align:center; margin-bottom:1.5rem; color:var(--primary);">Connexion</h2>
        <form method="POST" action="<?= BASE_URL ?>auth/processLogin">
            <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Mot de passe</label><input type="password" name="password" required></div>
            <button type="submit" class="btn" style="width:100%;">Se connecter</button>
        </form>
        <p style="text-align:center; margin-top:1rem;">Pas de compte ? <a href="<?= BASE_URL ?>auth/register" style="color:var(--secondary);">Inscrivez-vous</a></p>
    </div>
</section>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
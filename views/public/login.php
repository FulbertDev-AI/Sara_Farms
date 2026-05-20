<section class="card" style="max-width: 520px; margin: 0 auto;">
    <div class="breadcrumb">Connexion sécurisée</div>
    <h2>Accéder à Sara Farms</h2>
    <?php if (!empty($message)): ?>
        <div class="banner" style="margin-bottom: 18px; padding: 16px 18px; border-radius: 16px; background: rgba(217, 119, 54, 0.12); color: var(--alert);"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="post" action="?route=login" data-validate>
        <div class="form-grid">
            <label>Email
                <input type="email" name="email" required>
            </label>
            <label>Mot de passe
                <input type="password" name="password" required>
            </label>
        </div>
        <button class="button-primary" type="submit">Se connecter</button>
    </form>
</section>

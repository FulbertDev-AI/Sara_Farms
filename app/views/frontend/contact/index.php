<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<section class="container fade-in">
    <h2 style="text-align:center; margin-bottom: 2rem; color: var(--primary);">Contactez-nous</h2>
    <div class="grid" style="grid-template-columns: 1fr 1fr;">
        <div class="card glass">
            <h3>Informations</h3>
            <p style="margin:1rem 0;"><strong>Adresse :</strong> Zone Agricole Nord, Km 12, Route Nationale</p>
            <p style="margin:1rem 0;"><strong>Téléphone :</strong> +225 07 00 00 00 00</p>
            <p style="margin:1rem 0;"><strong>Email :</strong> contact@sarafarms.com</p>
            <p style="margin:1rem 0;"><strong>Horaires :</strong> Lun - Sam : 08h00 - 17h00</p>
        </div>
        <div class="card glass">
            <form id="contactForm">
                <div class="form-group">
                    <label>Nom complet</label>
                    <input type="text" required placeholder="Votre nom">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" required placeholder="votre@email.com">
                </div>
                <div class="form-group">
                    <label>Sujet</label>
                    <input type="text" required placeholder="Objet de votre message">
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea rows="4" required placeholder="Votre message..."></textarea>
                </div>
                <button type="submit" class="btn" style="width:100%;">Envoyer</button>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../../layouts/admin-header.php'; ?>

<h2 style="color:var(--primary);margin-bottom:1.5rem;">💰 Bilan Financier</h2>

<!-- Sélecteur de période -->
<form method="GET" style="margin-bottom:2rem;display:flex;gap:1rem;align-items:center;flex-wrap:wrap;">
    <select name="month" style="padding:8px 12px;border-radius:8px;border:1px solid #ccc;">
        <?php for($m=1;$m<=12;$m++): ?>
        <option value="<?= str_pad($m,2,'0',STR_PAD_LEFT) ?>" <?= $currentMonth == str_pad($m,2,'0',STR_PAD_LEFT) ? 'selected' : '' ?>>
            <?= ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Aoû','Sep','Oct','Nov','Déc'][$m-1] ?>
        </option>
        <?php endfor; ?>
    </select>
    <select name="year" style="padding:8px 12px;border-radius:8px;border:1px solid #ccc;">
        <?php for($y=date('Y');$y>=date('Y')-2;$y--): ?>
        <option value="<?= $y ?>" <?= $currentYear == $y ? 'selected' : '' ?>><?= $y ?></option>
        <?php endfor; ?>
    </select>
    <button type="submit" class="btn">Filtrer</button>
</form>

<!-- Cartes de bilan -->
<div class="stats-grid">
    <div class="stat-card" style="border-left:4px solid var(--secondary);">
        <h4>Revenus</h4>
        <div class="value" style="color:var(--secondary);"><?= number_format($balance['revenus'], 0, ',', ' ') ?> FCFA</div>
    </div>
    <div class="stat-card" style="border-left:4px solid var(--alert);">
        <h4>Dépenses</h4>
        <div class="value" style="color:var(--alert);"><?= number_format($balance['depenses'], 0, ',', ' ') ?> FCFA</div>
    </div>
    <div class="stat-card" style="border-left:4px solid <?= $balance['benefice'] >= 0 ? 'var(--secondary)' : '#dc3545' ?>;">
        <h4><?= $balance['benefice'] >= 0 ? 'Bénéfice' : 'Perte' ?></h4>
        <div class="value" style="color:<?= $balance['benefice'] >= 0 ? 'var(--secondary)' : '#dc3545' ?>;">
            <?= number_format(abs($balance['benefice']), 0, ',', ' ') ?> FCFA
        </div>
        <div class="trend <?= $balance['taux'] >= 0 ? 'up' : 'down' ?>">
            Taux : <?= number_format($balance['taux'], 1) ?>%
        </div>
    </div>
</div>

<!-- Graphique bilan -->
<div class="chart-card" style="margin-top:2rem;">
    <h3>Répartition Revenus / Dépenses</h3>
    <div class="chart-container">
        <canvas id="financeChart"></canvas>
    </div>
</div>

<script>
const finCtx = document.getElementById('financeChart').getContext('2d');
new Chart(finCtx, {
    type: 'bar',
    data: {
        labels: ['<?= ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Aoû','Sep','Oct','Nov','Déc'][$currentMonth-1] ?> <?= $currentYear ?>'],
        datasets: [
            {
                label: 'Revenus',
                data: [<?= $balance['revenus'] ?>],
                backgroundColor: 'rgba(136, 176, 75, 0.7)'
            },
            {
                label: 'Dépenses',
                data: [<?= $balance['depenses'] ?>],
                backgroundColor: 'rgba(217, 119, 54, 0.7)'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
            x: { grid: { display: false } }
        }
    }
});
</script>

<?php require_once __DIR__ . '/../../layouts/admin-footer.php'; ?>
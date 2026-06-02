<?php
function activeMenu($current, $page) {
    return $current === $page ? 'active' : '';
}

function statusBadge($status) {
    $classes = [
        'en_attente' => 'badge-warning',
        'validee' => 'badge-success',
        'rejetee' => 'badge-danger'
    ];
    $labels = [
        'en_attente' => 'En attente',
        'validee' => 'Validée',
        'rejetee' => 'Rejetée'
    ];
    return sprintf('<span class="badge %s">%s</span>', $classes[$status] ?? 'badge-info', $labels[$status] ?? $status);
}

function formatDate($datetime) {
    return date('d/m/Y H:i', strtotime($datetime));
}

function formatPrice($price) {
    return number_format($price, 0, ',', ' ') . ' FCFA';
}
?>
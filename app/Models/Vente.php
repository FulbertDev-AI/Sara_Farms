<?php
declare(strict_types=1);

class Vente
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getRecentCommandes(int $limit = 5): array
    {
        $statement = $this->pdo->prepare('SELECT c.id, c.nom_client_externe, c.date_commande, c.statut_paiement, c.montant_total FROM commandes c ORDER BY c.date_commande DESC LIMIT :limit');
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}

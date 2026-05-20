<?php
declare(strict_types=1);

class Stock
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllIntrants(): array
    {
        $query = 'SELECT id, nom, categorie, quantite_disponible, unite_mesure, seuil_alerte FROM intrants ORDER BY categorie, nom';
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getAlertIntrants(): array
    {
        $query = 'SELECT id, nom, categorie, quantite_disponible, unite_mesure, seuil_alerte FROM intrants WHERE quantite_disponible <= seuil_alerte ORDER BY quantite_disponible ASC';
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function updateStock(int $id, float $quantite): bool
    {
        $statement = $this->pdo->prepare('UPDATE intrants SET quantite_disponible = :quantite WHERE id = :id');
        return $statement->execute(['quantite' => $quantite, 'id' => $id]);
    }

    public function createIntrant(string $nom, string $categorie, float $quantite, string $unite, float $seuil): bool
    {
        $nom = sanitizeText($nom);
        $categorie = sanitizeText($categorie);
        $unite = sanitizeText($unite);

        $statement = $this->pdo->prepare(
            'INSERT INTO intrants (nom, categorie, quantite_disponible, unite_mesure, seuil_alerte) VALUES (:nom, :categorie, :quantite, :unite, :seuil)'
        );

        return $statement->execute([
            'nom' => $nom,
            'categorie' => $categorie,
            'quantite' => $quantite,
            'unite' => $unite,
            'seuil' => $seuil,
        ]);
    }
}

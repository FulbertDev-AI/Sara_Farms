<?php
declare(strict_types=1);

class Culture
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getActiveCultures(): array
    {
        $statement = $this->pdo->prepare('SELECT id, nom_culture, code_parcelle, statut, date_semis, date_recolte_prevue FROM cultures WHERE statut IN ("en cours", "planifie") ORDER BY date_semis DESC');
        $statement->execute();
        return $statement->fetchAll();
    }
}

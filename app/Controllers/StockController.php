<?php
declare(strict_types=1);

class StockController
{
    private Stock $stockModel;

    public function __construct(PDO $pdo)
    {
        $this->stockModel = new Stock($pdo);
    }

    public function createIntrant(array $data): bool
    {
        return $this->stockModel->createIntrant(
            $data['nom'] ?? '',
            $data['categorie'] ?? '',
            (float)($data['quantite_disponible'] ?? 0),
            $data['unite_mesure'] ?? '',
            (float)($data['seuil_alerte'] ?? 0)
        );
    }

    public function updateStock(int $id, float $quantite): bool
    {
        return $this->stockModel->updateStock($id, $quantite);
    }

    public function getAlertIntrants(): array
    {
        return $this->stockModel->getAlertIntrants();
    }

    public function getAllIntrants(): array
    {
        return $this->stockModel->getAllIntrants();
    }
}

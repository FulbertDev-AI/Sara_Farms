<?php
declare(strict_types=1);

class ProductionController
{
    private Culture $cultureModel;

    public function __construct(PDO $pdo)
    {
        $this->cultureModel = new Culture($pdo);
    }

    public function getActiveCultures(): array
    {
        return $this->cultureModel->getActiveCultures();
    }
}

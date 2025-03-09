<?php

namespace App\Service;

use App\Repository\CalculationRepository;

class CalculationService
{
    private $calculationRepository;

    public function __construct(CalculationRepository $calculationRepository)
    {
        $this->calculationRepository = $calculationRepository;
    }

    /**
     * Get paginated calculations.
     */
    public function getCalculations(int $page): array
    {
        $limit = 5;
        $offset = ($page - 1) * $limit;

        return $this->calculationRepository->findPaginatedCalculations('id', 'DESC', $limit, $offset);
    }

    /**
     * Get the total number of calculations.
     */
    public function getTotalCalculations(): int
    {
        return $this->calculationRepository->count([]);
    }
}
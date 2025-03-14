<?php

namespace App\Service;

use App\Entity\Calculation;
use App\Repository\CalculationRepository;
use Psr\Log\LoggerInterface;

class CalculationService
{
    private $calculationRepository;

    public function __construct(CalculationRepository $calculationRepository, LoggerInterface $logger)
    {
        $this->calculationRepository = $calculationRepository;
        $this->logger = $logger;
    }

    /**
     * Get paginated calculations with formatted data.
     */
    public function getCalculations(int $page): array
    {
        $limit = 5;
        $offset = ($page - 1) * $limit;

        // Fetch calculations from the repository
        $calculations = $this->calculationRepository->findPaginatedCalculations('id', 'DESC', $limit, $offset);

        // Format the data for each calculation
        foreach ($calculations as &$calculation) {
         // Assuming 'calculations' contains a string with the data
         $calculationsData = $calculation->getCalculations(); // Get the raw string
    
            if ($calculationsData) {
                // Replace '|' with a line break
                $formattedData = str_replace('|', "\n", $calculationsData);
    
                // Replace newline characters with <br> tags for HTML rendering
                $formattedData = nl2br($formattedData);
    
                // Update the calculation with the formatted string
                $calculation->setCalculations($formattedData);
            }

            // If there are other fields like aiResponse, you can do the same
            $aiResponseData = $calculation->getAiResponse();
            if ($aiResponseData) {
                // Remove extra line breaks between numbers
                $formattedAiResponse = preg_replace('/\n+/', ' ', $aiResponseData); // Replace consecutive newlines with a single space

                // Add <br> before each header (Temperature Explanation, Humidity Explanation, etc.)
                $formattedAiResponse = preg_replace('/(Temperature|Humidity|Pressure) Explanation:/', '<br>$0', $formattedAiResponse);

                // Set the formatted AI response with line breaks
                $calculation->setAiResponse(trim($formattedAiResponse));
            }


        }

        return $calculations;
    }

    /**
     * Get the total number of calculations.
     */
    public function getTotalCalculations(): int
    {
        return $this->calculationRepository->count([]);
    }
}

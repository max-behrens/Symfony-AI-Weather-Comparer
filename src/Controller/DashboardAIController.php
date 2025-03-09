<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\DashboardAIService;

class DashboardAIController extends AbstractController
{
    private $dashboardAIService;

    public function __construct(DashboardAIService $dashboardAIService)
    {
        $this->dashboardAIService = $dashboardAIService;
    }

    #[Route('/api/ask-openai', name: 'api_ask_openai', methods: ['POST'])]
    public function askOpenAI(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $userInput = $data['user_input'] ?? '';
        $calculationResults = $data['calculationResults'] ?? [];
        $city = $data['city'] ?? 'Unknown City';
    
        if (empty($userInput)) {
            return new JsonResponse(['error' => 'User input is required'], 400);
        }
    
        $aiResponse = $this->dashboardAIService->getDashboardAIResponse($userInput, $calculationResults, $city);
    
        return new JsonResponse(['aiResponse' => $aiResponse]);
    }
    
}
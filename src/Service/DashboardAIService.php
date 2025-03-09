<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class DashboardAIService
{
    private $logger;
    private $openaiApiKey;
    private $openaiOrgId;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        // Get these from your .env file or parameters
        $this->openaiApiKey = $_ENV['OPENAI_SECRET'] ?? null;
        $this->openaiOrgId = $_ENV['OPENAI_ORGANISATION'] ?? null;
    }

    public function getDashboardAIResponse($userInput, $calculationResults, $city)
    {
        $this->logger->info('User input:', ['userInput' => $userInput]);
        $this->logger->info('Calculation Results:', ['calculationResults' => $calculationResults]);
        $this->logger->info('City:', ['city' => $city]);

        $city = $city ?? 'Unknown City';

        $explanationData = '';
        if (!empty($calculationResults)) {
            $explanationData = 'Weather explanations: ' . implode(' ', [
                $calculationResults['temperatureExplanation'] ?? '',
                $calculationResults['humidityExplanation'] ?? '',
                $calculationResults['pressureExplanation'] ?? ''
            ]);
        }

        try {
            $client = HttpClient::create();
            $response = $client->request('POST', 'https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->openaiApiKey,
                    'OpenAI-Organization' => $this->openaiOrgId,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    "model" => "gpt-3.5-turbo-0125",
                    "messages" => [
                        ["role" => "system", "content" => "You are a helpful assistant."],
                        ["role" => "user", "content" => $userInput],
                        ["role" => "system", "content" => $explanationData],
                        ["role" => "system", "content" => "City: $city"]
                    ]
                ]
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                $content = $response->toArray();
                $aiResponse = $content['choices'][0]['message']['content'] ?? 'No response content';
                
                $this->logger->info('AI Response:', ['response' => $aiResponse]);
                return $aiResponse;
            } else {
                $this->logger->error('OpenAI API error:', ['status' => $statusCode]);
                return 'Error: Unable to get AI response (Status: ' . $statusCode . ')';
            }
        } catch (TransportExceptionInterface $e) {
            $this->logger->error('OpenAI API exception:', ['exception' => $e->getMessage()]);
            return 'Error: Unable to connect to AI service';
        }
    }
}
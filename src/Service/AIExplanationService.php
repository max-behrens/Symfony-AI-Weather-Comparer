<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;

class AIExplanationService
{
    private $httpClient;
    private $apiKey;
    private $organisation;
    private $logger;

    public function __construct(HttpClientInterface $httpClient, string $apiKey, string $organisation, LoggerInterface $logger)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
        $this->organisation = $organisation;
        $this->logger = $logger;
    }

    public function getAIWeatherExplanations($calculationResults, $city)
    {
        $this->logger->info('Sending request to OpenAI', ['city' => $city, 'data' => $calculationResults]);

        $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'OpenAI-organization' => $this->organisation,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                "model" => "gpt-3.5-turbo-0125",
                "messages" => [
                    ["role" => "system", "content" => "You are an AI that explains weather data for a given city."],
                    ["role" => "user", "content" => "The city is $city. Here are the weather fluctuations over the past few days: " . json_encode($calculationResults)],
                    ["role" => "assistant", "content" => "Explain the temperature, humidity, and pressure trends for $city based on the given data.
                        The data is not in units of Celsius, instead each number represents the relative rate of change between each forecasted day;
                        so when mentioning these units, also explain what their units mean in this context.
                        
                        Also, don't attempt to add the city to your description, as you do not have it in your training data.
                        Please split your answers into 3 sections with the following titles (where your response to each of these goes within the corresponding title), 
                        'Temperature', 'Humidity' and 'Pressure'."],
                ]
            ],
            'verify_peer' => false, // Similar to withoutVerifying() in Laravel
            'verify_host' => false, // Disable SSL verification (if needed, but not recommended for production)
        ]);

        $content = $response->getContent();
        $this->logger->info('AI Weather Explanation:', ['response' => $content]);

        // Parse response to extract explanations
        return [
            'temperatureExplanation' => $this->extractExplanation($content, 'Temperature'),
            'humidityExplanation' => $this->extractExplanation($content, 'Humidity'),
            'pressureExplanation' => $this->extractExplanation($content, 'Pressure'),
        ];
    }

    private function extractExplanation($aiResponse, $type)
    {
        preg_match("/$type:\s*(.+?)(?:\n|$)/i", $aiResponse, $matches);
        return $matches[1] ?? "No explanation available.";
    }
}

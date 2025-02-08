<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface; // Correct import
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request; // Correct import for Request class

class ClimateExplanationService
{
    private $httpClient;
    private $logger;
    private $parameterBag;

    public function __construct(LoggerInterface $logger, ParameterBagInterface $parameterBag)
    {
        $this->httpClient = HttpClient::create();  // Use Symfony HttpClient
        $this->logger = $logger;
        $this->parameterBag = $parameterBag;
    }

    public function getClimateExplanation(string $prompt): string
    {

        $this->logger->warning('HERE 3');

        // $prompt = "Explain what these values mean in climate science:\n" .
        //   "Temperature rate of change: " . $temperature . "%, " .
        //   "Humidity rate of change: " . $humidity . "%, " .
        //   "Pressure rate of change: " . $pressure . "%.";

        // $this->logger->info('Generated prompt HERE NOW!', ['prompt' => $prompt]);


        try {


            $this->logger->warning('HERE 4 - PROMPT', [
                'prompt' => $prompt
            ]);


            // $result = $container->get('openai')->completions()->create([
            //     'model' => 'text-davinci-003',
            //     'prompt' => 'Please guess the number I am thinking of between 1 and 10.',
            // ]);

            // $this->logger->info('Generated result', ['result' => $result]);

            
            $chatGPTApiUrl = $this->parameterBag->get('chat_gpt_api_url');
            $chatGPTApiKey = $this->parameterBag->get('chat_gpt_api_key');

            $this->logger->warning('HERE 4 - chatGPTApiUrl', [
                'chatGPTApiUrl' => $chatGPTApiUrl
            ]);

            $this->logger->warning('HERE 4 - chatGPTApiKey', [
                'chatGPTApiKey' => $chatGPTApiKey
            ]);

            // Truncate the prompt if necessary
            $maxPromptLength = 2000; // Set an appropriate max length
            $shortenedPrompt = mb_substr($prompt, 0, $maxPromptLength);

            // Log the shortened prompt length
            $this->logger->warning('Shortened Prompt:', ['prompt' => $shortenedPrompt]);


            $array = [];

            $array['prompt'] = 'hello';

            // Log the request size before sending
            $requestBody = [
                'prompt' => $prompt,
                'max_tokens' => 100,
                'temperature' => 0.9,
                'model' => 'text-davinci-003',
            ];

            

            // Log the request body size
            $requestSize = strlen(json_encode($requestBody));
            $this->logger->warning('Request Body Size:', ['size' => $requestSize]);
    
            $response = $this->httpClient->request(
                Request::METHOD_POST,
                $chatGPTApiUrl,
                [
                'body' => 'hello',
                ]
            );

            $this->logger->warning('HERE 4 - RESPONSE', [
                'response' => $response
            ]);
    
            $responseData = $response->toArray();
    
            return $responseData['choices'][0]['text'];

        } catch (\Exception $e) {
            $this->logger->error('Error in OpenAI request:', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}

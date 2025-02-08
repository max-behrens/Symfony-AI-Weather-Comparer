<?php

namespace App\Controller;

use App\Entity\Calculation;
use App\Form\WeatherSearchType;
use App\Form\CalculationType;
use App\Form\ChatType;
use App\Service\WeatherService;
use App\Service\WeatherCalculationService;
use App\Service\ClimateExplanationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/weather', name: 'weather_')]
class WeatherController extends AbstractController
{
    private $weatherService;
    private $weatherCalculationService;
    private $logger;
    private $entityManager;
    private $climateExplanationService;

    public function __construct(WeatherService $weatherService, WeatherCalculationService $weatherCalculationService, climateExplanationService $climateExplanationService, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->weatherService = $weatherService;
        $this->weatherCalculationService = $weatherCalculationService;
        $this->climateExplanationService = $climateExplanationService;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }


    #[Route('/test', name: 'test', methods: ['GET'])]
    public function test(): Response
    {
        $this->logger->info('POST test:');

        // Return JSON for the test page
        return $this->render('weather/test.html.twig');
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $this->logger->info('INDEX Start');
    
        // Create the form
        $form = $this->createForm(WeatherSearchType::class);
    
        // Get the weather data from the request
        $weatherData = $request->query->get('weatherData');
        $submitted = $request->query->get('submitted', false);
        $error = $request->query->get('error');
    
        // Pass data to the template
        return $this->render('weather/index.html.twig', [
            'form' => $form->createView(),
            'submitted' => $submitted,
            'error' => $error,
            'weatherData' => $weatherData,  // Ensure this data is passed to the view
        ]);
    }

    #[Route('/weather-fetch', name: 'weather_fetch', methods: ['POST', 'GET'])]
    public function getWeather(Request $request, WeatherService $weatherService): Response
    {
        $this->logger->info('GET WEATHER - Start');

        // Create and handle the form
        $form = $this->createForm(WeatherSearchType::class);
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $city = $data['city'];  // Get 'city' from the form data

            // Check if city value is provided
            if (!$city) {
                return new JsonResponse(['error' => 'City parameter is missing'], 400);
            }

            try {
                $weatherData = $weatherService->fetchWeatherByCity($city);
            
                if (!is_array($weatherData) || count($weatherData) === 0) {
                    return new JsonResponse(['error' => 'Weather data is empty or invalid'], 500);
                }
            
                // Calculate step size to evenly select 5 forecasts
                $totalDataPoints = count($weatherData);
                $stepSize = max(1, intval(ceil($totalDataPoints / 5)));
            
                $selectedForecasts = [];
                for ($i = 0; $i < $totalDataPoints; $i += $stepSize) {
                    $selectedForecasts[] = $weatherData[$i];
                    if (count($selectedForecasts) >= 5) break;
                }
            
                // Perform calculations for temperature, humidity, and pressure
                $temperatureChanges = $this->weatherCalculationService->calculateRateOfChange($selectedForecasts, 'temperature');
                $humidityChanges = $this->weatherCalculationService->calculateRateOfChange($selectedForecasts, 'humidity');
                $pressureChanges = $this->weatherCalculationService->calculateRateOfChange($selectedForecasts, 'pressure');

                $averageTemperatureChanges = $this->weatherCalculationService->calculateAverageRateOfChange($temperatureChanges);
                $averageHumidityChanges = $this->weatherCalculationService->calculateAverageRateOfChange($humidityChanges);
                $averagePressureChanges = $this->weatherCalculationService->calculateAverageRateOfChange($pressureChanges);


                $this->logger->warning('AVERAGES', [
                    'averageTemperatureChanges' => $averageTemperatureChanges,
                    'averageHumidityChanges' => $averageHumidityChanges,
                    'averagePressureChanges' => $averagePressureChanges,
                ]);


            
                // Return the processed data as JSON
                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse([
                        'forecasts' => $selectedForecasts,
                        'temperatureChanges' => $temperatureChanges,
                        'humidityChanges' => $humidityChanges,
                        'pressureChanges' => $pressureChanges,
                        'averageTemperatureChanges' => $averageTemperatureChanges,
                        'averageHumidityChanges' => $averageHumidityChanges,
                        'averagePressureChanges' => $averagePressureChanges,
                    ]);
                }
            
            } catch (\Exception $e) {
                $this->logger->error('Error in getWeather:', ['error' => $e->getMessage()]);
                return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
            }
            
        }

        // Log if the form was not submitted or is not valid
        $this->logger->warning('Form not submitted or not valid', [
            'submitted' => $form->isSubmitted(),
            'valid' => $form->isValid(),
            'errors' => $form->getErrors(true, false)
        ]);

        // Render the form view if the form was not submitted or is invalid
        return $this->render('weather/index.html.twig', [
            'form' => $form->createView()
        ]);
    }


    // In WeatherController.php
    #[Route('/climate-explanation', name: 'climate_explanation', methods: ['GET', 'POST'])]
    public function climateExplanation(Request $request): JsonResponse
    {

        $form = $this->createForm(ChatType::class);
        $form->handleRequest($request);

        $this->logger->warning('HERE C 1');


        // if ($form->isSubmitted() && $form->isValid()) {

        //     $this->logger->warning('HERE C 2');


        //     $prompt = $form->get('prompt')->getData();
        //     $answer = $chatGPTClient->getAnswer($prompt);
        // }
        $prompt = 'Hello?';

        // $temperature = $request->request->get('temperature');
        // $humidity = $request->request->get('humidity');
        // $pressure = $request->request->get('pressure');

        // $averageRates = [
        //     'temperature' => $temperature,
        //     'humidity' => $humidity,
        //     'pressure' => $pressure,
        // ];

        try {
            // $this->logger->info('Starting climate explanation request', [
            //     'averageRates' => $averageRates
            // ]);

            $explanation = $this->climateExplanationService->getClimateExplanation($prompt);

            return new JsonResponse([
                'temperatureExplanation' => "The temperature rate of change suggests: " . $explanation,
                'humidityExplanation' => "The humidity change indicates: " . $explanation,
                'pressureExplanation' => "The pressure change implies: " . $explanation,
            ]);
        } catch (\Exception $e) {
            $this->logger->error('Climate explanation error:', [
                'error' => $e->getMessage(),
                'class' => get_class($e)
            ]);

            // Check if it's a rate limit error
            if (strpos($e->getMessage(), 'Rate limit exceeded') !== false) {
                return new JsonResponse([
                    'error' => 'The AI service is temporarily busy. Please try again in a few seconds.',
                    'retryable' => true
                ], 429);
            }

            return new JsonResponse([
                'error' => 'Failed to fetch AI explanation. Please try again later.',
                'retryable' => false
            ], 500);
        }
    }


}

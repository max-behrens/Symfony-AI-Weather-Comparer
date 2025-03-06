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

    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $formFind = $this->createForm(WeatherSearchType::class);
        $formFind->handleRequest($request);
    
        // Add this line to set the city variable when the form is submitted and valid
        $city = null;
    
        if ($formFind->isSubmitted() && $formFind->isValid()) {
            $city = $formFind->get('city')->getData();
            $this->logger->info('Form submitted', ['city' => $city]);
            
            // Redirect to the `getWeather` route to fetch and display weather
            return $this->redirectToRoute('weather_fetch', ['city' => $city]);
        }

        $this->logger->info('Rendering formFind', ['formFind' => $formFind->createView()]);
    
        return $this->render('weather/index.html.twig', [
            'formFind' => $formFind->createView(),
            // Pass city to the template even when not fetched
            'city' => $city
        ]);
    }
    
    
    #[Route('/forecast/{city}', name: 'fetch', methods: ['POST'], requirements: ['city' => '[^/]+'])]
    public function getWeather(string $city, Request $request, WeatherService $weatherService, WeatherCalculationService $weatherCalculationService): Response
    {
        $this->logger->info('GET WEATHER - Start', ['city' => $city]);
        
        // Create a form with the current city for resubmission
        $formFind = $this->createForm(WeatherSearchType::class, ['city' => $city]);
        $formFind->handleRequest($request);

        try {
            $weatherData = $weatherService->fetchWeatherByCity($city);
            
            if (!is_array($weatherData) || count($weatherData) === 0) {
                throw new \Exception('Weather data is empty or invalid');
            }

            $totalDataPoints = count($weatherData);
            $stepSize = max(1, intval(ceil($totalDataPoints / 5)));
            
            $selectedForecasts = [];
            for ($i = 0; $i < $totalDataPoints; $i += $stepSize) {
                if (isset($weatherData[$i])) {
                    $selectedForecasts[] = $weatherData[$i];
                    if (count($selectedForecasts) >= 5) break;
                }
            }
            
            // Perform calculations
            $temperatureChanges = $weatherCalculationService->calculateRateOfChange($selectedForecasts, 'temperature');
            $humidityChanges = $weatherCalculationService->calculateRateOfChange($selectedForecasts, 'humidity');
            $pressureChanges = $weatherCalculationService->calculateRateOfChange($selectedForecasts, 'pressure');

            $averageTemperatureChanges = $weatherCalculationService->calculateAverageRateOfChange($temperatureChanges);
            $averageHumidityChanges = $weatherCalculationService->calculateAverageRateOfChange($humidityChanges);
            $averagePressureChanges = $weatherCalculationService->calculateAverageRateOfChange($pressureChanges);

            $temperatureExplanation = $this->getClimateExplanation($averageTemperatureChanges, 'temperature');
            $humidityExplanation = $this->getClimateExplanation($averageHumidityChanges, 'humidity');
            $pressureExplanation = $this->getClimateExplanation($averagePressureChanges, 'pressure');

            // Create save form to save the data.
            $calculation = new Calculation();
            $formSave = $this->createForm(CalculationType::class, $calculation);
            
            return $this->render('weather/index.html.twig', [
                'formFind' => $formFind->createView(),
                'formSave' => $formSave->createView(),
                'forecasts' => $selectedForecasts,
                'temperatureChanges' => $temperatureChanges,
                'humidityChanges' => $humidityChanges,
                'pressureChanges' => $pressureChanges,
                'averageTemperatureChanges' => $averageTemperatureChanges,
                'averageHumidityChanges' => $averageHumidityChanges,
                'averagePressureChanges' => $averagePressureChanges,
                'city' => $city,
                'temperatureExplanation' => $temperatureExplanation,
                'humidityExplanation' => $humidityExplanation,
                'pressureExplanation' => $pressureExplanation,
                'showResults' => true
            ]);
            
        } catch (\Exception $e) {
            $this->logger->error('Error in getWeather:', ['error' => $e->getMessage()]);
            return $this->render('weather/index.html.twig', [
                'formFind' => $formFind->createView(),
                'error' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

    
    // Helper method to get climate explanations directly
    private function getClimateExplanation(float $value, string $type): string
    {
        $explanations = [
            'temperature' => [
                'low' => 'Temperature is relatively stable with minimal fluctuations, suggesting consistent weather patterns.',
                'medium' => 'Temperature shows moderate variability, which is typical for transitional seasons.',
                'high' => 'Temperature fluctuations are significant, indicating unstable weather conditions.'
            ],
            'humidity' => [
                'low' => 'Humidity levels are stable, suggesting consistent atmospheric moisture content.',
                'medium' => 'Humidity shows moderate changes, which may result in occasional rainfall or changing comfort levels.',
                'high' => 'Humidity fluctuations are significant, potentially indicating alternating periods of dry and wet conditions.'
            ],
            'pressure' => [
                'low' => 'Atmospheric pressure is stable, suggesting consistent weather conditions.',
                'medium' => 'Pressure shows moderate changes, which may indicate approaching weather fronts.',
                'high' => 'Pressure fluctuations are significant, potentially indicating rapidly changing weather systems.'
            ]
        ];
        
        $category = 'medium';
        if ($value < 3) {
            $category = 'low';
        } elseif ($value > 7) {
            $category = 'high';
        }
        
        return $explanations[$type][$category];
    }


}

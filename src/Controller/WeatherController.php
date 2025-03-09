<?php
namespace App\Controller;

use App\Form\WeatherSearchType;
use App\Form\CalculationType;
use App\Entity\Calculation;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class WeatherController extends AbstractController
{
    private $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    #[Route ('/weather_test', name: 'weather_test', methods: ['GET'])]
    public function test()
    {
        return $this->render('weather/test.html.twig');
    }

    #[Route('/weather', name: 'weather_index', methods: ['GET'])]
    public function index(Request $request, WeatherService $weatherService): Response
    {
        // Create search form with GET method
        $formFind = $this->createForm(WeatherSearchType::class, null, [
            'method' => 'GET',
            'action' => $this->generateUrl('weather_index')
        ]);
        
        // Handle the request
        $formFind->handleRequest($request);
        
        // Default parameters
        $params = [
            'formFind' => $formFind->createView(),
            'showResults' => false
        ];
        
        if ($formFind->isSubmitted() && $formFind->isValid()) {
            $data = $formFind->getData();
            $city = $data['city'];
            
            $this->logger->info('Form submitted with city', ['city' => $city]);
            
            try {
                // Fetch weather data
                $forecasts = $weatherService->fetchWeatherByCity($city);

                $this->logger->info('forecasts', ['forecasts'=> $forecasts]);
                
                // Process weather data and get formatted results
                $weatherData = $weatherService->processWeatherData($city, $forecasts);
                
                // Create save form for calculations
                $calculation = new Calculation();
                $formSave = $this->createForm(CalculationType::class, $calculation);
                
                // Add save form to the parameters
                $weatherData['formSave'] = $formSave->createView();
                
                // Merge weather data with base parameters
                $params = array_merge($params, $weatherData);
                
            } catch (\Exception $e) {
                $this->logger->error('Error fetching weather data', ['error' => $e->getMessage()]);
                $params['error'] = 'An error occurred: ' . $e->getMessage();
            }
        }
        
        return $this->render('weather/index.html.twig', $params);
    }
}
<?php

namespace App\Controller;

use App\Entity\Calculation;
use App\Form\WeatherSearchType;
use App\Form\CalculationType;
use App\Service\WeatherService;
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
    private $logger;
    private $entityManager;

    public function __construct(WeatherService $weatherService, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->weatherService = $weatherService;
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
            $country = $data['country'];  // Get 'country' from the form data

            // Check if country value is provided
            if (!$country) {
                return new JsonResponse(['error' => 'Country parameter is missing'], 400);
            }

            try {
                // Fetch weather data based on the country
                $weatherData = $weatherService->fetchWeatherByCountry($country);

                // Log and return the weather data as JSON
                $this->logger->error('weatherData', [
                    'weatherData' => $weatherData
                ]);
                return new JsonResponse($weatherData);
            } catch (\Exception $e) {
                // Log any errors
                $this->logger->error('Error in getWeather:', [
                    'error' => $e->getMessage()
                ]);
                
                // Render error message
                return $this->render('weather/index.html.twig', [
                    'form' => $form->createView(),
                    'error' => $e->getMessage()
                ]);
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
}

<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\Exception\TransportExceptionInterface;
use App\Service\WeatherCalculationService;
use App\Service\AIExplanationService;
use Psr\Log\LoggerInterface;

class WeatherService
{
    private $httpClient;
    private $apiKey;
    private $logger;
    private $weatherCalculationService;
    private $aiExplanationService;

    public function __construct(
        HttpClientInterface $httpClient, 
        string $apiKey, 
        LoggerInterface $logger,
        WeatherCalculationService $weatherCalculationService,
        AIExplanationService $aiExplanationService
    ) {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
        $this->logger = $logger;
        $this->weatherCalculationService = $weatherCalculationService;
        $this->aiExplanationService = $aiExplanationService;
    }

    public function fetchWeatherByCity(string $city): array
    {
        $url = "https://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$this->apiKey}";
    
        $this->logger->info('Fetching weather data for city', ['city' => $city]);
    
        try {
            // Make the HTTP request
            $response = $this->httpClient->request('GET', $url);
    
            if ($response->getStatusCode() !== 200) {
                throw new \Exception("Failed to fetch weather data: " . $response->getContent(false));
            }
    
            // Decode the response content into an array
            $data = json_decode($response->getContent(), true);
    
            // Get today's date
            $today = new \DateTime('today');
            $todayDate = $today->format('Y-m-d');
    
            // Group the forecasts by date (only keep the first forecast for each day)
            $formattedData = [];
            $seenDates = [];
    
            foreach ($data['list'] as $forecast) {
                // Extract the date (without time)
                $date = explode(' ', $forecast['dt_txt'])[0];
    
                // Skip the forecasts for today
                if ($date === $todayDate) {
                    continue;
                }
    
                // Only add the first forecast for each unique date after today
                if (!in_array($date, $seenDates)) {
                    $formattedData[] = [
                        'time' => $forecast['dt_txt'],
                        'temperature' => round($forecast['main']['temp'] - 273.15, 2),
                        'feels_like' => round($forecast['main']['feels_like'] - 273.15, 2),
                        'humidity' => $forecast['main']['humidity'],
                        'pressure' => $forecast['main']['pressure'],
                        'wind_speed' => $forecast['wind']['speed'],
                        'description' => ucfirst($forecast['weather'][0]['description']),
                        'rain' => $forecast['rain']['3h'] ?? 0
                    ];
    
                    // Mark this date as seen
                    $seenDates[] = $date;
                }
            }
    
            return $formattedData;
    
        } catch (TransportExceptionInterface $e) {
            throw new \Exception("Network error: " . $e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception("Couldn't fetch weather data for city: {$city}. Error: " . $e->getMessage());
        }
    }
    
    
    public function processWeatherData(string $city, array $forecasts): array
    {

        $pressureChanges = $this->weatherCalculationService->calculateRateOfChange($forecasts, 'pressure');
        $humidityChanges = $this->weatherCalculationService->calculateRateOfChange($forecasts, 'humidity');
        $temperatureChanges = $this->weatherCalculationService->calculateRateOfChange($forecasts, 'temperature');
        $averagePressureChanges = $this->weatherCalculationService->calculateAverageRateOfChange($pressureChanges);
        $averageHumidityChanges = $this->weatherCalculationService->calculateAverageRateOfChange($humidityChanges);
        $averageTemperatureChanges = $this->weatherCalculationService->calculateAverageRateOfChange($temperatureChanges);

        $calculationResults = [
           'temperatureChanges' => $temperatureChanges,
            'humidityChanges' => $humidityChanges,
            'pressureChanges' => $pressureChanges,
            'averageTemperatureChanges' => $averageTemperatureChanges,
            'averageHumidityChanges' => $averageHumidityChanges,
            'averagePressureChanges' => $averagePressureChanges,
        ];



        ## Replace these with call to AIExplanationService
        ## Remove getClimateExplanation method
        // Get explanations
        // $temperatureExplanation = $this->getClimateExplanation($averageTemperatureChanges, 'temperature');
        // $humidityExplanation = $this->getClimateExplanation($averageHumidityChanges, 'humidity');
        // $pressureExplanation = $this->getClimateExplanation($averagePressureChanges, 'pressure');
        
        $aiDataExplanations = $this->aiExplanationService->getAIWeatherExplanations($calculationResults, $city ?? '');

        // Return data in the format expected by the Twig template
        return [
            'forecasts' => $forecasts,
            'city' => $city,
            'temperatureChanges' => $temperatureChanges,
            'humidityChanges' => $humidityChanges,
            'pressureChanges' => $pressureChanges,
            'averageTemperatureChanges' => $averageTemperatureChanges,
            'averageHumidityChanges' => $averageHumidityChanges,
            'averagePressureChanges' => $averagePressureChanges,
            'temperatureExplanation' => $aiDataExplanations['temperatureExplanation'],
            'humidityExplanation' => $aiDataExplanations['humidityExplanation'],
            'pressureExplanation' => $aiDataExplanations['pressureExplanation'],
            'showResults' => true
        ];
    }
    
    // Helper method to get climate explanations
    // private function getClimateExplanation(float $value, string $type): string
    // {
    //     $explanations = [
    //         'temperature' => [
    //             'low' => 'Temperature is relatively stable with minimal fluctuations, suggesting consistent weather patterns.',
    //             'medium' => 'Temperature shows moderate variability, which is typical for transitional seasons.',
    //             'high' => 'Temperature fluctuations are significant, indicating unstable weather conditions.'
    //         ],
    //         'humidity' => [
    //             'low' => 'Humidity levels are stable, suggesting consistent atmospheric moisture content.',
    //             'medium' => 'Humidity shows moderate changes, which may result in occasional rainfall or changing comfort levels.',
    //             'high' => 'Humidity fluctuations are significant, potentially indicating alternating periods of dry and wet conditions.'
    //         ],
    //         'pressure' => [
    //             'low' => 'Atmospheric pressure is stable, suggesting consistent weather conditions.',
    //             'medium' => 'Pressure shows moderate changes, which may indicate approaching weather fronts.',
    //             'high' => 'Pressure fluctuations are significant, potentially indicating rapidly changing weather systems.'
    //         ]
    //     ];
        
    //     $category = 'medium';
    //     if ($value < 3) {
    //         $category = 'low';
    //     } elseif ($value > 7) {
    //         $category = 'high';
    //     }
        
    //     return $explanations[$type][$category];
    // }
}
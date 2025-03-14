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
        
            // Use IntlDateFormatter to format the date in "14th March 2025" format
            $dateFormatter = new \IntlDateFormatter(
                'en_US', 
                \IntlDateFormatter::LONG, 
                \IntlDateFormatter::NONE, 
                'GMT', 
                \IntlDateFormatter::GREGORIAN
            );

            foreach ($data['list'] as $forecast) {
                // Extract the date (without time)
                $date = explode(' ', $forecast['dt_txt'])[0];
        
                // Skip the forecasts for today
                if ($date === $todayDate) {
                    continue;
                }
        
                // Only add the first forecast for each unique date after today
                if (!in_array($date, $seenDates)) {
                    // Format the date in the "14th March 2025" format
                    $dateObj = new \DateTime($date);
                    $formattedDate = $dateFormatter->format($dateObj);
                    
                    $formattedData[] = [
                        'time' => $formattedDate, // Replace the time with the formatted date
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
        
        $aiDataExplanations = $this->aiExplanationService->getAIWeatherExplanations($calculationResults, $city ?? '');

        $this->logger->info('AI Explanations', ['explanations' => $aiDataExplanations]);

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

}
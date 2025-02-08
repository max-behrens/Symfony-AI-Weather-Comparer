<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\Exception\TransportExceptionInterface;
use Psr\Log\LoggerInterface;


class WeatherService
{
    private $httpClient;
    private $apiKey;
    private $logger;

    public function __construct(HttpClientInterface $httpClient, string $apiKey, LoggerInterface $logger)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
        $this->logger = $logger;
    }

    public function fetchWeatherByCity(string $city): array
    {
        $url = "https://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$this->apiKey}";

        try {
            // Make the HTTP request
            $response = $this->httpClient->request('GET', $url);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception("Failed to fetch weather data: " . $response->getContent(false));
            }

            // Decode the response content into an array
            $data = json_decode($response->getContent(), true);


            $this->logger->info('$data NOW' , [
                'data' => $data
            ]);

            // Format the data for easier display
            $formattedData = [];
            foreach ($data['list'] as $forecast) {
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
            }

            return $formattedData;

        } catch (TransportExceptionInterface $e) {
            throw new \Exception("Network error: " . $e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception("Couldn't fetch weather data for city: {$city}. Error: " . $e->getMessage());
        }
    }

}

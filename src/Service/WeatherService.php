<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\Exception\TransportExceptionInterface;

class WeatherService
{
    private $httpClient;
    private $apiKey;

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    public function fetchWeatherByCountry(string $country): array
    {
        // Construct the URL for fetching weather data for a specific country
        $geocodeUrl = "https://api.openweathermap.org/data/2.5/weather?q={$country}&appid={$this->apiKey}";

        try {
            // Make the HTTP request
            $response = $this->httpClient->request('GET', $geocodeUrl);


            // TODO: Get hourly figures from API
            
            // // Parse the geolocation response and get lat and lon
            // $geoData = $response->toArray();
            // $lat = $geoData['coord']['lat'];
            // $lon = $geoData['coord']['lon'];

            // // Step 2: Use lat and lon to fetch weather data from the OpenWeather onecall API
            // $oneCallUrl = "https://api.openweathermap.org/data/3.0/onecall?lat={$lat}&lon={$lon}&exclude=current,minutely&appid={$this->apiKey}";

            // // Fetch weather data (hourly and daily) using the onecall API
            // $response = $this->httpClient->request('GET', $oneCallUrl);

            // Check if the response status code is 200 (successful)
            if ($response->getStatusCode() !== 200) {
                throw new \Exception("Failed to fetch weather data: " . $response->getContent(false));
            }

            // Return the response as an array
            return $response->toArray();
        } catch (TransportExceptionInterface $e) {
            // Handle any transport-related exceptions (e.g., network issues)
            throw new \Exception("Network error: " . $e->getMessage());
        } catch (\Exception $e) {
            // Handle other exceptions, such as invalid response
            throw new \Exception("Couldn't fetch weather data for country: {$country}. Error: " . $e->getMessage());
        }
    }
}

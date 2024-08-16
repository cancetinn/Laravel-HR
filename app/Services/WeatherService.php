<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getIstanbulWeather()
    {
        $apiKey = config('services.weather.api_key');
        $lat = '41.0082'; // Latitude for Istanbul
        $lon = '28.9784'; // Longitude for Istanbul
        $url = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&units=metric&appid={$apiKey}";

        $response = Http::get($url);
        return $response->json();
    }
}

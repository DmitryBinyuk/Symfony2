<?php

namespace App\ProjectBundle\Services;

class WeatherService
{
    public function getWeather()
    {
        $baseUrl = "http://api.worldweatheronline.com/premium/v1/weather.ashx";
        $key = "b3a8bf04d8774516b0b122917171004";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl.'?q=Kharkiv&date-today&key='.$key.'&format=json');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        $data = json_decode($response);

        $weatherData = $data->data->current_condition[0];

        $result = array('temperature'=>$weatherData->temp_C.' °C',
                        'time'=>$weatherData->observation_time,
                        'wind_speed'=>$weatherData->windspeedKmph,
                        'pressure'=>$weatherData->pressure,
                        'description'=>$weatherData->weatherDesc[0]->value,
                        'icon'=>$weatherData->weatherIconUrl[0]->value);

        return $result;
    }
}


<?php
require 'auth.php';
require 'database.php';

function fetchCountryData($countryName) {
    $apiUrl = "https://restcountries.com/v3.1/name/" . urlencode($countryName);
    $response = file_get_contents($apiUrl);
    $countries = json_decode($response, true);

    if (isset($countries[0])) {
        $country = $countries[0];
        $filteredData = [
            'name' => $country['name']['common'],
            'currency' => $country['currencies'],
            'capital' => $country['capital'][0],
            'languages' => $country['languages'],
            'flag' => $country['flags']['png']
        ];
        echo json_encode($filteredData);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Country not found']);
    }
}

// Route the request
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if (preg_match('/^\/country\/(.+)$/', $requestUri, $matches) && $requestMethod === 'GET') {
    $countryName = $matches[1];
    fetchCountryData($countryName);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
}
?>
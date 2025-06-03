<?php
header('Content-Type: application/json');
$url = 'https://overpass-api.de/api/interpreter?data=[out:json];node["amenity"="fast_food"]["name"="Maluburger"];out;';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore nella richiesta: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);
echo $result;

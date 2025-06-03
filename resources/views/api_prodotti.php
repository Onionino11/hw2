<?php
header('Content-Type: application/json');
$apiKey = '9dde7ae366c84c1d943b6f3567ff7f2b'; 
$query = isset($_GET['query']) ? urlencode($_GET['query']) : '';
$number = isset($_GET['number']) ? intval($_GET['number']) : 10;
$url = "https://api.spoonacular.com/recipes/complexSearch?query=$query&number=$number&apiKey=$apiKey";
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
?>

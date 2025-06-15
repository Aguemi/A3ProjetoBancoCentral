<?php
// URL do seu back-end Spring Boot
$url = "http://localhost:8080/api/loans"; 

// Inicializa a requisição cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executa a requisição
$response = curl_exec($ch);

// Verifica se houve erro
if (curl_errno($ch)) {
    echo 'Erro na requisição: ' . curl_error($ch);
} else {
    echo 'Resposta do Spring Boot:<br>';
    echo '<pre>' . htmlspecialchars($response) . '</pre>';
}

curl_close($ch);
?>

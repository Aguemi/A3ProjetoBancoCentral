<?php
// Mostrar erros para ajudar no debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mes = (int)$_POST['month_number'];
    $principal = (float)$_POST['principal'];
    $juros = (float)$_POST['interest'];
    $saldo = (float)$_POST['balance'];
    $dataVencimento = $_POST['due_date'];
    $loanId = (int)$_POST['loan_id'];

    // Montar array para JSON
    $data = [
        'monthNumber' => $mes,
        'principal' => $principal,
        'interest' => $juros,
        'balance' => $saldo,
        'dueDate' => $dataVencimento,
        'loan' => ['id' => $loanId]  // loan como objeto com id
    ];

    $jsonData = json_encode($data);

    // 🔁 🔧 ALTERE AQUI para o endpoint correto do seu backend Spring Boot para parcelas
    $url = 'http://localhost:8080/api/installments';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "❌ Erro ao enviar para o Spring Boot: " . curl_error($ch);
    } else {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode === 200 || $httpCode === 201) {
            $responseData = json_decode($response, true);

            echo "<h2>✅ Parcela cadastrada com sucesso!</h2>";
            echo "<strong>ID:</strong> " . ($responseData['id'] ?? 'N/A') . "<br>";
            echo "<strong>Mês:</strong> " . ($responseData['monthNumber'] ?? 'N/A') . "<br>";
            echo "<strong>Principal:</strong> " . ($responseData['principal'] ?? 'N/A') . "<br>";
            echo "<strong>Juros:</strong> " . ($responseData['interest'] ?? 'N/A') . "<br>";
            echo "<strong>Saldo:</strong> " . ($responseData['balance'] ?? 'N/A') . "<br>";
            echo "<strong>Data de Vencimento:</strong> " . ($responseData['dueDate'] ?? 'N/A') . "<br>";
            echo "<strong>ID Empréstimo:</strong> " . ($responseData['loan']['id'] ?? 'N/A') . "<br><br>";
            echo "<a href='../index.php'>🔙 Voltar</a>";
        } else {
            echo "❌ Erro na resposta do Spring Boot (HTTP $httpCode):<br>";
            echo "<pre>" . htmlspecialchars($response) . "</pre>";
        }
    }

    curl_close($ch);
}
?>

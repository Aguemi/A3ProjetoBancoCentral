<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe e sanitiza dados
    $amount = floatval($_POST['amount']);
    $interestRate = floatval($_POST['interest_rate']) / 100;
    $months = intval($_POST['months']);
    $startDateStr = $_POST['start_date'];

    // Valida dados básicos
    if ($amount <= 0 || $interestRate < 0 || $months <= 0 || !$startDateStr) {
        $error = "Preencha todos os campos corretamente.";
    } else {
        $startDate = new DateTime($startDateStr);

        // Cálculo da parcela fixa (PMT) usando fórmula do sistema PRICE
        $i = $interestRate;
        $n = $months;
        $P = $amount;

        if ($i == 0) {
            $pmt = round($P / $n, 2);
        } else {
            $pmt = round(($P * $i) / (1 - pow(1 + $i, -$n)), 2);
        }

        $balance = $P;
        $parcelas = [];

        for ($month = 1; $month <= $n; $month++) {
            $interest = round($balance * $i, 2);
            $amortization = round($pmt - $interest, 2);
            $balance = round($balance - $amortization, 2);

            // Corrige arredondamento final
            if ($month === $n && abs($balance) > 0.01) {
                $amortization += $balance;
                $balance = 0;
            }

            $dueDate = clone $startDate;
            $dueDate->modify("+$month month");

            $total = round($amortization + $interest, 2); // soma correta

            $parcelas[] = [
                'month' => $month,
                'installment' => $total,
                'amortization' => $amortization,
                'interest' => $interest,
                'balance' => $balance,
                'due_date' => $dueDate->format('Y-m-d'),
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Simulador de Parcelas</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: right; }
        th { background-color: #eee; }
        td:first-child, th:first-child { text-align: center; }
        input, button { padding: 8px; margin: 5px 0; width: 100%; box-sizing: border-box; }
        button { cursor: pointer; background-color: #007BFF; border: none; color: white; font-weight: bold; }
        button:hover { background-color: #0056b3; }
        .error { color: red; }
    </style>
</head>
<body>

<h1>📊 Simulador de Parcelas de Empréstimo</h1>

<form method="POST" action="">
    <label>Valor do Empréstimo (R$):</label>
    <input type="number" name="amount" step="0.01" required value="<?= isset($amount) ? htmlspecialchars($amount) : '' ?>" />

    <label>Taxa de Juros Mensal (%):</label>
    <input type="number" name="interest_rate" step="0.01" required value="<?= isset($interestRate) ? htmlspecialchars($interestRate * 100) : '' ?>" />

    <label>Quantidade de Meses:</label>
    <input type="number" name="months" required value="<?= isset($months) ? htmlspecialchars($months) : '' ?>" />

    <label>Data de Início:</label>
    <input type="date" name="start_date" required value="<?= isset($startDateStr) ? htmlspecialchars($startDateStr) : '' ?>" />

    <button type="submit">Simular</button>
</form>

<?php if (!empty($error)): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<?php if (!empty($parcelas)): ?>
    <h2>Parcelas Calculadas</h2>
    <table>
        <thead>
            <tr>
                <th>Mês</th>
                <th>Amortização (R$)</th>
                <th>Juros (R$)</th>
                <th>Saldo (R$)</th>
                <th>Vencimento</th>
                <th>Total a pagar (R$)</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($parcelas as $p): ?>
            <tr>
                <td><?= $p['month'] ?></td>
                <td><?= number_format($p['amortization'], 2, ',', '.') ?></td>
                <td><?= number_format($p['interest'], 2, ',', '.') ?></td>
                <td><?= number_format($p['balance'], 2, ',', '.') ?></td>
                <td><?= $p['due_date'] ?></td>
                <td><?= number_format($p['installment'], 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="/ProjetoBancoCentralPHP/index.php">⬅ Voltar ao início</a>

</body>
</html>

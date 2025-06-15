<?php
include '../conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatórios do Sistema</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 40px; }
        th, td { border: 1px solid #aaa; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        h2 { margin-top: 40px; }
        a.excluir {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
        a.excluir:hover {
            text-decoration: underline;
        }
        a.editar {
            color: green;
            text-decoration: none;
            font-weight: bold;
            margin-right: 8px;
        }
        a.editar:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>📊 Relatórios do Simulador de Empréstimos</h1>

    <!-- Clientes -->
    <h2>👤 Clientes</h2>
    <table>
        <tr><th>ID</th><th>Nome</th><th>Email</th><th>Ações</th></tr>
        <?php
        $clientes = $pdo->query("SELECT * FROM customer")->fetchAll();
        foreach ($clientes as $cliente) {
            $id = $cliente['id'];
            $name = htmlspecialchars($cliente['name']);
            $email = htmlspecialchars($cliente['email']);
            echo "<tr>
                    <td>{$id}</td>
                    <td>{$name}</td>
                    <td>{$email}</td>
                    <td>
                        <a href='/ProjetoBancoCentralPHP/edit.php?type=customer&id={$id}' class='editar'>Editar</a>
                        <a href='/ProjetoBancoCentralPHP/delete.php?type=customer&id={$id}' class='excluir' onclick=\"return confirm('Excluir cliente {$name}?');\">Excluir</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <!-- Fiadores -->
    <h2>🧍 Fiadores</h2>
    <table>
        <tr><th>ID</th><th>Nome</th><th>CPF</th><th>Ações</th></tr>
        <?php
        $fiadores = $pdo->query("SELECT * FROM guarantor")->fetchAll();
        foreach ($fiadores as $f) {
            $id = $f['id'];
            $name = htmlspecialchars($f['name']);
            $cpf = htmlspecialchars($f['cpf']);
            echo "<tr>
                    <td>{$id}</td>
                    <td>{$name}</td>
                    <td>{$cpf}</td>
                    <td>
                        <a href='/ProjetoBancoCentralPHP/edit.php?type=guarantor&id={$id}' class='editar'>Editar</a>
                        <a href='/ProjetoBancoCentralPHP/delete.php?type=guarantor&id={$id}' class='excluir' onclick=\"return confirm('Excluir fiador {$name}?');\">Excluir</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <!-- Empréstimos -->
    <h2>💰 Empréstimos</h2>
    <table>
        <tr><th>ID</th><th>Cliente</th><th>Valor</th><th>Juros (%)</th><th>Meses</th><th>Início</th><th>Ações</th></tr>
        <?php
        $emprestimos = $pdo->query("
            SELECT l.*, c.name AS cliente 
            FROM loan l 
            LEFT JOIN customer c ON c.id = l.customer_id
        ")->fetchAll();
        foreach ($emprestimos as $e) {
            $id = $e['id'];
            $cliente = htmlspecialchars($e['cliente']);
            $amount = number_format($e['amount'], 2, ',', '.');
            $interest = $e['interest_rate'];
            $months = $e['months'];
            $start = $e['start_date'];
            echo "<tr>
                    <td>{$id}</td>
                    <td>{$cliente}</td>
                    <td>R$ {$amount}</td>
                    <td>{$interest}</td>
                    <td>{$months}</td>
                    <td>{$start}</td>
                    <td>
                        <a href='/ProjetoBancoCentralPHP/edit.php?type=loan&id={$id}' class='editar'>Editar</a>
                        <a href='/ProjetoBancoCentralPHP/delete.php?type=loan&id={$id}' class='excluir' onclick=\"return confirm('Excluir empréstimo do cliente {$cliente}?');\">Excluir</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <!-- Contratos -->
    <h2>📄 Contratos</h2>
    <table>
        <tr><th>ID</th><th>Data de Assinatura</th><th>Termos</th><th>Empréstimo</th><th>Fiador</th><th>Ações</th></tr>
        <?php
        $contratos = $pdo->query("
            SELECT c.id, c.signed_date, c.terms, l.id AS loan_id, g.name AS guarantor
            FROM contract c
            LEFT JOIN loan l ON l.id = c.loan_id
            LEFT JOIN guarantor g ON g.id = c.guarantor_id
        ")->fetchAll();
        foreach ($contratos as $c) {
            $id = $c['id'];
            $signed_date = $c['signed_date'];
            $terms = htmlspecialchars($c['terms']);
            $loan_id = $c['loan_id'];
            $guarantor = htmlspecialchars($c['guarantor']);
            echo "<tr>
                    <td>{$id}</td>
                    <td>{$signed_date}</td>
                    <td>{$terms}</td>
                    <td>{$loan_id}</td>
                    <td>{$guarantor}</td>
                    <td>
                        <a href='/ProjetoBancoCentralPHP/edit.php?type=contract&id={$id}' class='editar'>Editar</a>
                        <a href='/ProjetoBancoCentralPHP/delete.php?type=contract&id={$id}' class='excluir' onclick=\"return confirm('Excluir contrato ID {$id}?');\">Excluir</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <!-- Parcelas -->
    <h2>📆 Parcelas</h2>
    <table>
        <tr>
            <th>ID</th><th>Mês</th><th>Principal</th><th>Juros (%)</th><th>Saldo</th><th>Vencimento</th><th>Empréstimo</th><th>Parcela Total</th><th>Ações</th>
        </tr>
        <?php
        $parcelas = $pdo->query("
            SELECT i.*, l.id AS loan_id, l.interest_rate
            FROM installment i
            LEFT JOIN loan l ON l.id = i.loan_id
        ")->fetchAll();
        foreach ($parcelas as $p) {
            $id = $p['id'];
            $month = $p['month_number'];
            $principal_valor = $p['principal'];
            $juros_percentual = $p['interest_rate'];
            $juros_valor = $principal_valor * ($juros_percentual / 100);
            $balance = $p['balance'];
            $due_date = $p['due_date'];
            $loan_id = $p['loan_id'];
            $total_parcela = $principal_valor + $juros_valor;

            $principal = number_format($principal_valor, 2, ',', '.');
            $juros_percent = number_format($juros_percentual, 2, ',', '.');
            $saldo = number_format($balance, 2, ',', '.');
            $total_parcela_formatado = number_format($total_parcela, 2, ',', '.');

            echo "<tr>
                    <td>{$id}</td>
                    <td>{$month}</td>
                    <td>R$ {$principal}</td>
                    <td>{$juros_percent} %</td>
                    <td>R$ {$saldo}</td>
                    <td>{$due_date}</td>
                    <td>{$loan_id}</td>
                    <td>R$ {$total_parcela_formatado}</td>
                    <td>
                        <a href='/ProjetoBancoCentralPHP/edit.php?type=installment&id={$id}' class='editar'>Editar</a>
                        <a href='/ProjetoBancoCentralPHP/delete.php?type=installment&id={$id}' class='excluir' onclick=\"return confirm('Excluir parcela ID {$id}?');\">Excluir</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <a href="../index.php">⬅ Voltar ao início</a>
</body>
</html>

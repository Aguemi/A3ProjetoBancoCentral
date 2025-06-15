<?php include 'conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Simulador de Empréstimos</title>
</head>
<body>
    <h1>📊 Simulador de Empréstimos</h1>

    <hr>
    <h2>👤 Cadastrar Cliente</h2>
    <form action="entidades/cliente.php" method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <button type="submit">Cadastrar</button>
    </form>

    <hr>
    <h2>🧍 Cadastrar Fiador</h2>
    <form action="entidades/fiador.php" method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="cpf" placeholder="CPF" required>
        <button type="submit">Cadastrar</button>
    </form>

    <hr>
    <h2>💰 Cadastrar Empréstimo</h2>
    <?php
    $clientes = $pdo->query("SELECT id, name FROM customer")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <form action="entidades/emprestimo.php" method="POST">
        <input type="number" step="0.01" name="amount" placeholder="Valor" required>
        <input type="number" step="0.01" name="interest_rate" placeholder="Taxa de Juros (%)" required>
        <input type="number" name="months" placeholder="Meses" required>
        <input type="date" name="start_date" required>
        <select name="customer_id" required>
            <option value="">Cliente</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['id'] ?>"><?= $c['name'] ?> (ID <?= $c['id'] ?>)</option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Cadastrar</button>
    </form>

    <hr>
    <h2>📄 Cadastrar Contrato</h2>
    <?php
    $loans = $pdo->query("SELECT id FROM loan")->fetchAll(PDO::FETCH_ASSOC);
    $fiadores = $pdo->query("SELECT id, name FROM guarantor")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <form action="entidades/contrato.php" method="POST">
        <input type="date" name="signed_date" required>
        <textarea name="terms" placeholder="Termos do contrato" required></textarea>
        <select name="loan_id" required>
            <option value="">Empréstimo</option>
            <?php foreach ($loans as $l): ?>
                <option value="<?= $l['id'] ?>"><?= $l['id'] ?></option>
            <?php endforeach; ?>
        </select>
        <select name="guarantor_id" required>
            <option value="">Fiador</option>
            <?php foreach ($fiadores as $f): ?>
                <option value="<?= $f['id'] ?>"><?= $f['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Cadastrar</button>
    </form>

    <hr>
    <h2>📆 Cadastrar Parcela</h2>
    <form action="entidades/parcela.php" method="POST">
        <input type="number" name="month_number" placeholder="Mês" required>
        <input type="number" step="0.01" name="principal" placeholder="Principal" required>
        <input type="number" step="0.01" name="interest" placeholder="Juros" required>
        <input type="number" step="0.01" name="balance" placeholder="Saldo" required>
        <input type="date" name="due_date" required>
        <select name="loan_id" required>
            <option value="">Empréstimo</option>
            <?php foreach ($loans as $l): ?>
                <option value="<?= $l['id'] ?>"><?= $l['id'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Cadastrar</button>
    </form>

    <hr>
    <h2>📑 Relatórios</h2>
<ul>
    <li><a href="relatorios/relatorio.php">Ver todos os relatórios</a></li>
    <li><a href="simulador_parcelas.php">Simulador de parcelas</a></li>

</ul>

</body>
</html>

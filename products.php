<?php
include('includes/connection.php'); // Agora, $pdo é a sua conexão PDO
include('includes/head.php');
include('includes/navigation.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nossos Produtos - <?php echo $title ?? 'Loja Online'; ?></title>
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
            color: #333;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Nossos Produtos</h1>

    <?php
    try {
        // Query para selecionar todos os produtos, incluindo a descrição
        // Usamos $pdo->query() para consultas SELECT simples sem parâmetros
        $stmt = $pdo->query("SELECT idproduto, nome, preco, descricao FROM produto ORDER BY nome ASC");
        
        // Pega todos os resultados como um array associativo (PDO::FETCH_ASSOC é o padrão que setamos no connection.php)
        $produtos = $stmt->fetchAll();

        if (count($produtos) > 0) {
            echo '<table border="1">';
            echo '<thead><tr><th>ID</th><th>Nome do Produto</th><th>Preço</th><th>Descrição</th></tr></thead>';
            echo '<tbody>';
            foreach ($produtos as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row["idproduto"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["nome"]) . '</td>';
                // Formata o preço para R$ X.XXX,XX
                echo '<td>R$ ' . number_format($row["preco"], 2, ',', '.') . '</td>'; 
                // nl2br para quebrar linhas da descrição se houver, e htmlspecialchars para segurança
                echo '<td>' . nl2br(htmlspecialchars($row["descricao"])) . '</td>'; 
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo "<p>Nenhum produto cadastrado ainda.</p>";
        }
    } catch (PDOException $e) {
        // Captura e exibe erros de PDO que possam ocorrer na consulta
        echo "<p class='message error'>Erro ao carregar produtos: " . $e->getMessage() . "</p>";
    }
    // Com PDO, não é estritamente necessário fechar a conexão ($pdo = null;)
    // pois ela será fechada automaticamente ao final do script.
    ?>
</div>

<?php
include('includes/bottom.php');
?>
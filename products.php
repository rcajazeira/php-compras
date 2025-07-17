<?php
include('includes/connection.php'); // Certifique-se de que este caminho está correto
include('includes/head.php');
include('includes/navigation.php');
?>

<div class="container">
    <h1>Nossos Produtos</h1>

    <?php
    // Query para selecionar todos os produtos
    $sql = "SELECT idproduto, nome, preco FROM produto ORDER BY nome ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exibe os produtos em uma tabela ou cards
        echo '<table border="1" style="width:100%; border-collapse: collapse;">';
        echo '<thead><tr><th>ID</th><th>Nome do Produto</th><th>Preço</th></tr></thead>';
        echo '<tbody>';
        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row["idproduto"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["nome"]) . '</td>';
            echo '<td>R$ ' . number_format($row["preco"], 2, ',', '.') . '</td>'; // Formata o preço
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo "<p>Nenhum produto cadastrado ainda.</p>";
    }

    // Fecha a conexão com o banco de dados
    $conn->close(); 
    ?>
</div>

<?php
include('includes/bottom.php');
?>
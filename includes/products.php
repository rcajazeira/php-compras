<?php
include('includes/session.php');
include('includes/connection.php'); // Inclua a conexão AQUI para poder usar o banco
include('includes/head.php');
include('includes/navigation.php');
?>

<div class="container">
    <h1>Nossos Produtos</h1>

    <?php
    // Verifica se a conexão com o banco de dados foi estabelecida
    if (isset($conn) && $conn instanceof mysqli) {
        // Prepare a consulta para obter todos os produtos
        // ATENÇÃO: O nome da tabela deve ser 'produtos' (assumindo que você renomeou no Workbench)
        $stmt = $conn->prepare("SELECT id, nome, preco, descricao FROM produtos ORDER BY id DESC");
        
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Exibe os produtos
                while($produto = $result->fetch_assoc()) {
        ?>
                    <div class="product-item">
                        <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                        <p>Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                        <p><?php echo htmlspecialchars($produto['descricao']); ?></p>
                        </div>
        <?php
                }
            } else {
                echo "<p>Nenhum produto encontrado ainda. <a href='admin_add_product.php'>Adicione alguns!</a></p>";
            }
            $stmt->close();
        } else {
            echo "<p class='message error'>Erro na preparação da consulta: " . $conn->error . "</p>";
        }
    } else {
        echo "<p class='message error'>Erro: Conexão com o banco de dados não estabelecida.</p>";
    }
    ?>
</div>

<?php
include('includes/bottom.php');
?>
<?php
include('includes/session.php');
include('includes/connection.php'); // Inclua a conexão AQUI
include('includes/head.php');
include('includes/navigation.php');

$message = '';
$nome_produto = '';
$preco_produto = '';
$descricao_produto = '';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e sanitiza os dados do formulário
    $nome_produto = htmlspecialchars(trim($_POST['nome']));
    $preco_produto = htmlspecialchars(trim($_POST['preco']));
    $descricao_produto = htmlspecialchars(trim($_POST['descricao']));

    // Validação básica
    if (empty($nome_produto) || empty($preco_produto) || empty($descricao_produto)) {
        $message = "<p class='message error'>Por favor, preencha todos os campos obrigatórios.</p>";
    } else {
        // Verifica se a conexão com o banco de dados foi estabelecida
        if (isset($conn) && $conn instanceof mysqli) {
            // Prepara a consulta SQL para inserção segura (Prepared Statement)
            // ATENÇÃO: O nome da tabela deve ser 'produtos'
            $stmt = $conn->prepare("INSERT INTO produtos (nome, preco, descricao) VALUES (?, ?, ?)");
            
            if ($stmt) {
                // 'sds' -> string, decimal, string para os tipos de dados dos parâmetros
                $stmt->bind_param("sds", $nome_produto, $preco_produto, $descricao_produto);

                // Executa a consulta
                if ($stmt->execute()) {
                    $message = "<p class='message success'>Produto '{$nome_produto}' adicionado com sucesso!</p>";
                    // Limpar campos do formulário após sucesso
                    $nome_produto = '';
                    $preco_produto = '';
                    $descricao_produto = '';
                } else {
                    $message = "<p class='message error'>Erro ao adicionar produto: " . $stmt->error . "</p>";
                }
                $stmt->close();
            } else {
                 $message = "<p class='message error'>Erro na preparação da consulta: " . $conn->error . "</p>";
            }
        } else {
            $message = "<p class='message error'>Erro: Conexão com o banco de dados não estabelecida.</p>";
        }
    }
}
?>

<div class="container">
    <h1>Adicionar Novo Produto</h1>
    <?php echo $message; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $nome_produto; ?>" required><br>

        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" step="0.01" value="<?php echo $preco_produto; ?>" required><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="5" required><?php echo $descricao_produto; ?></textarea><br>

        <input type="submit" value="Adicionar Produto">
    </form>
</div>

<?php
include('includes/bottom.php');
?>
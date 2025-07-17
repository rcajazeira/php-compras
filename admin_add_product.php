<?php
// Inclui o arquivo de sessão. Certifique-se de que session_start() esteja dentro dele
include('includes/session.php'); 
include('includes/connection.php'); // Agora, $pdo é a sua conexão
include('includes/head.php');
include('includes/navigation.php');

$message = ''; // Variável para exibir mensagens ao usuário
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
    } elseif (!is_numeric($preco_produto) || $preco_produto < 0) {
        $message = "<p class='message error'>O preço deve ser um número positivo.</p>";
    } else {
        // CORREÇÃO AQUI: Usando $pdo para preparar a query
        try {
            $stmt = $pdo->prepare("INSERT INTO produto (nome, preco, descricao) VALUES (:nome, :preco, :descricao)");
            
            // Liga os parâmetros nomeados (:nome, :preco, :descricao) aos valores das variáveis
            $stmt->bindParam(':nome', $nome_produto);
            $stmt->bindParam(':preco', $preco_produto);
            $stmt->bindParam(':descricao', $descricao_produto);

            // Executa a consulta
            if ($stmt->execute()) {
                $message = "<p class='message success'>Produto '{$nome_produto}' adicionado com sucesso!</p>";
                // Limpar campos do formulário após sucesso
                $nome_produto = '';
                $preco_produto = '';
                $descricao_produto = '';
            } else {
                // PDO Exceptions serão pegas pelo bloco try-catch da conexão, mas este é para erros de execução
                $message = "<p class='message error'>Erro ao adicionar produto. Tente novamente.</p>";
            }
        } catch (PDOException $e) {
            // Captura qualquer erro de PDO que possa ocorrer na preparação ou execução da query
            $message = "<p class='message error'>Erro no banco de dados: " . $e->getMessage() . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto - <?php echo $title ?? 'Loja Online'; ?></title>
    <style>
        /* Seus estilos CSS, como fornecidos anteriormente */
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
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        form input[type="text"],
        form input[type="number"],
        form textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form textarea {
            resize: vertical;
        }
        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-weight: bold;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<?php // Os includes (head.php, navigation.php) já foram executados acima ?>

<div class="container">
    <h1>Adicionar Novo Produto (Administração)</h1>

    <?php echo $message; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome_produto); ?>" required><br>

        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" step="0.01" value="<?php echo htmlspecialchars($preco_produto); ?>" required><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="5" required><?php echo htmlspecialchars($descricao_produto); ?></textarea><br>

        <input type="submit" value="Adicionar Produto">
    </form>
</div>

<?php
include('includes/bottom.php');
// Com PDO, não é estritamente necessário fechar a conexão ($pdo = null;)
// pois ela será fechada automaticamente ao final do script.
// Se você quiser ser explícito: $pdo = null;
?>
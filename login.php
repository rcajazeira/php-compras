<?php
include('includes/session.php'); // Inicia a sessão
include('includes/connection.php'); // Inclui a conexão PDO (variável $pdo)
include('includes/head.php');     // Inclui o cabeçalho HTML
include('includes/navigation.php'); // Inclui a navegação

$message = ''; // Variável para exibir mensagens
$username_or_email_input = ''; // Para manter o valor no formulário

// Redireciona se o usuário já estiver logado
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redireciona para a página inicial
    exit();
}

// Lógica de login movida para ANTES do HTML para que as mensagens sejam exibidas corretamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email_input = htmlspecialchars(trim($_POST['username_or_email']));
    $password = $_POST['password'];

    if (empty($username_or_email_input) || empty($password)) {
        $message = "<p class='message error'>Por favor, preencha todos os campos.</p>";
    } else {
        try {
            // Prepara a consulta para buscar o usuário por email na tabela 'usuario'
            // CORRIGIDO: tabela 'usuario' e coluna 'usuario_id'
            $stmt = $pdo->prepare("SELECT usuario_id, nome, email, senha FROM usuario WHERE email = :email");
            $stmt->bindParam(':email', $username_or_email_input);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // Busca uma única linha

            if ($user) { // Se um usuário foi encontrado
                // Verifica a senha fornecida com o hash armazenado na coluna 'senha'
                if (password_verify($password, $user['senha'])) {
                    // Login bem-sucedido: Armazena informações na sessão
                    // CORRIGIDO: Armazena 'usuario_id'
                    $_SESSION['user_id'] = $user['usuario_id'];
                    $_SESSION['user_nome'] = $user['nome']; // Armazenar o nome também é útil
                    $_SESSION['user_email'] = $user['email'];

                    // Redireciona para a página inicial ou dashboard
                    header("Location: index.php");
                    exit();
                } else {
                    $message = "<p class='message error'>E-mail ou senha incorretos.</p>";
                }
            } else {
                $message = "<p class='message error'>E-mail ou senha incorretos.</p>";
            }
        } catch (PDOException $e) {
            $message = "<p class='message error'>Erro no banco de dados ao tentar logar: " . $e->getMessage() . "</p>";
        }
    }
}
?>
<style>
    /* Seus estilos CSS permanecem os mesmos */
    .container {
        max-width: 600px;
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
    form input[type="password"] {
        width: calc(100% - 22px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    form input[type="submit"] {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }
    form input[type="submit"]:hover {
        background-color: #0056b3;
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
    p {
        text-align: center;
        margin-top: 20px;
    }
    p a {
        color: #007bff;
        text-decoration: none;
    }
    p a:hover {
        text-decoration: underline;
    }
</style>

<div class="container">
    <h1>Login</h1>
    <?php echo $message; // Exibe a mensagem aqui ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username_or_email">E-mail:</label>
        <input type="text" id="username_or_email" name="username_or_email" value="<?php echo htmlspecialchars($username_or_email_input); ?>" required><br>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Entrar">
    </form>
    <p>Não tem uma conta? <a href="register.php">Crie uma aqui</a>.</p>
</div>

<?php
include('includes/bottom.php');
?>
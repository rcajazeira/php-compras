<?php
include('includes/session.php'); // Inicia a sessão
include('includes/connection.php'); // Inclui a conexão PDO (variável $pdo)
include('includes/head.php');     // Inclui o cabeçalho HTML
include('includes/navigation.php'); // Inclui a navegação

$message = ''; // Variável para exibir mensagens de sucesso/erro
$nome = '';    // Para manter o valor no formulário em caso de erro
$email = '';   // Para manter o valor no formulário em caso de erro

// Lógica de registro movida para ANTES do HTML para que as mensagens sejam exibidas corretamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($nome) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "<p class='message error'>Por favor, preencha todos os campos.</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<p class='message error'>Formato de e-mail inválido.</p>";
    } elseif ($password !== $confirm_password) {
        $message = "<p class='message error'>As senhas não coincidem.</p>";
    } elseif (strlen($password) < 6) {
        $message = "<p class='message error'>A senha deve ter pelo menos 6 caracteres.</p>";
    } else {
        try {
            // Verifica se o email já existe usando PDO na tabela 'usuario'
            // CORRIGIDO: tabela 'usuario' e coluna 'usuario_id'
            $stmt_check = $pdo->prepare("SELECT usuario_id FROM usuario WHERE email = :email");
            $stmt_check->bindParam(':email', $email);
            $stmt_check->execute();
            
            if ($stmt_check->rowCount() > 0) { // PDO usa rowCount() para saber o número de linhas
                $message = "<p class='message error'>E-mail já cadastrado. Por favor, use outro.</p>";
            } else {
                // Hash da senha
                $hashed_senha = password_hash($password, PASSWORD_DEFAULT);

                // Insere o novo usuário na tabela 'usuario' usando PDO
                // CORRIGIDO: tabela 'usuario'
                $stmt = $pdo->prepare("INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)");
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':senha', $hashed_senha);

                if ($stmt->execute()) {
                    $message = "<p class='message success'>Usuário '{$nome}' registrado com sucesso! Você já pode fazer <a href='login.php'>Login</a>.</p>";
                    // Limpa os campos do formulário após o sucesso
                    $nome = '';
                    $email = '';
                } else {
                    $message = "<p class='message error'>Erro ao registrar usuário. Tente novamente.</p>";
                }
            }
        } catch (PDOException $e) {
            $message = "<p class='message error'>Erro no banco de dados ao registrar: " . $e->getMessage() . "</p>";
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
    form input[type="email"],
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
    <h1>Registrar Nova Conta</h1>
    <?php echo $message; // Exibe a mensagem aqui ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="nome">Nome Completo:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">Confirmar Senha:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <input type="submit" value="Registrar">
    </form>
    <p>Já tem uma conta? <a href="login.php">Faça login aqui</a>.</p>
</div>

<?php
include('includes/bottom.php');
?>
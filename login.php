<?php
include('includes/session.php'); // Inicia a sessão
include('includes/connection.php'); // Inclui a conexão com o banco de dados
include('includes/head.php');     // Inclui o cabeçalho HTML
include('includes/navigation.php'); // Inclui a navegação

$message = '';

// Redireciona se o usuário já estiver logado
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redireciona para a página inicial
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = htmlspecialchars(trim($_POST['username_or_email']));
    $password = $_POST['password'];

    if (empty($username_or_email) || empty($password)) {
        $message = "<p class='message error'>Por favor, preencha todos os campos.</p>";
    } else {
        // Prepara a consulta para buscar o usuário por username ou email
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username_or_email, $username_or_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            // Verifica a senha com o hash armazenado
            if (password_verify($password, $user['password'])) {
                // Login bem-sucedido: Armazena informações na sessão
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redireciona para a página inicial ou dashboard
                header("Location: index.php");
                exit();
            } else {
                $message = "<p class='message error'>Senha incorreta.</p>";
            }
        } else {
            $message = "<p class='message error'>Usuário ou e-mail não encontrado.</p>";
        }
        $stmt->close();
    }
}
?>

<div class="container">
    <h1>Login</h1>
    <?php echo $message; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username_or_email">Nome de Usuário ou E-mail:</label>
        <input type="text" id="username_or_email" name="username_or_email" value="<?php echo htmlspecialchars($_POST['username_or_email'] ?? ''); ?>" required><br>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Entrar">
    </form>
    <p>Não tem uma conta? <a href="register.php">Crie uma aqui</a>.</p>
</div>

<?php
include('includes/bottom.php');
?>
<?php
include('includes/session.php'); // Inicia a sessão
include('includes/connection.php'); // Inclui a conexão com o banco de dados
include('includes/head.php');     // Inclui o cabeçalho HTML
include('includes/navigation.php'); // Inclui a navegação

$message = '';
$username = '';
$email = '';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password']; // Senha em texto puro
    $confirm_password = $_POST['confirm_password']; // Confirmação da senha

    // Validação básica
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "<p class='message error'>Por favor, preencha todos os campos.</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<p class='message error'>Formato de e-mail inválido.</p>";
    } elseif ($password !== $confirm_password) {
        $message = "<p class='message error'>As senhas não coincidem.</p>";
    } elseif (strlen($password) < 6) {
        $message = "<p class='message error'>A senha deve ter pelo menos 6 caracteres.</p>";
    } else {
        // Hash da senha (MUITO IMPORTANTE para segurança!)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Verifica se o nome de usuário ou e-mail já existem
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt_check->bind_param("ss", $username, $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $message = "<p class='message error'>Nome de usuário ou e-mail já cadastrado.</p>";
        } else {
            // Insere o novo usuário no banco de dados
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $message = "<p class='message success'>Usuário '{$username}' registrado com sucesso! Você já pode fazer <a href='login.php'>Login</a>.</p>";
                // Limpa os campos do formulário após o sucesso
                $username = '';
                $email = '';
            } else {
                $message = "<p class='message error'>Erro ao registrar usuário: " . $stmt->error . "</p>";
            }
            $stmt->close();
        }
        $stmt_check->close();
    }
}
?>

<div class="container">
    <h1>Registrar Nova Conta</h1>
    <?php echo $message; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Nome de Usuário:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br>

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
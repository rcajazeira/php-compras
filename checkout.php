<?php
include('includes/session.php'); // Inicia a sessão
// Não precisamos de conexão com BD diretamente aqui para um checkout super básico
include('includes/head.php');
include('includes/navigation.php');

// Um exemplo de verificação de login para acesso à página
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "<p class='message error'>Você precisa estar logado para finalizar a compra.</p>";
    header("Location: login.php");
    exit();
}
?>

<div class="container">
    <h1>Finalizar Compra (Checkout)</h1>

    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']); // Limpa a mensagem após exibir
    }
    ?>

    <p>Olá, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuário'); ?>!</p>
    <p>Esta é a página de checkout. Em um sistema real, você veria aqui os itens do seu carrinho,
       opções de pagamento e envio.</p>

    <p>Por enquanto, considere sua compra "finalizada" simbolicamente.</p>

    <form action="checkout.php" method="post">
        <input type="hidden" name="action" value="place_order">
        <input type="submit" value="Confirmar Pedido (Apenas Exemplo)">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'place_order') {
        echo "<p class='message success'>Seu pedido foi 'finalizado' com sucesso! (Isso é apenas um exemplo)</p>";
        // Em um sistema real, aqui você processaria o pedido, salvaria no BD, etc.
    }
    ?>

    <p><a href="products.php">Voltar aos Produtos</a></p>
</div>

<?php
include('includes/bottom.php');
?>
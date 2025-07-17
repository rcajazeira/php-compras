<?php $title = "Compras PHP"; ?>
<?php
include('includes/connection.php');
include('includes/head.php');
include('includes/navigation.php');
?>

<div class="container">
    <h1>Bem-vindo à Sua Loja Online!</h1>
    <p>Aqui você encontrará uma variedade de produtos. Use o menu de navegação para explorar.</p>
    <p>Clique em <a href="products.php">Produtos</a> para ver o catálogo.</p>
    <p>Se você for administrador, pode <a href="admin_add_product.php">Adicionar um Novo Produto</a>.</p>
</div>

<?php
include('includes/bottom.php');
?>
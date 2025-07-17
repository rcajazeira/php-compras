<?php
    // verifica em qual pagina estamos
    $current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="navbar">
    <ul>
        <li><a class="<?php if($current_page == 'index.php') echo 'active' ?>" href="index.php">Home</a></li>
        <li><a class="<?php if($current_page == 'products.php') echo 'active' ?>" href="products.php">Produtos</a></li>
        <li><a class="<?php if($current_page == 'admin_add_product.php') echo 'active' ?>" href="admin_add_product.php">Adicionar Produto</a></li>
        <li><a href="#">Carrinho</a></li>
        <li><a href="#">Checkout</a></li>
        <li><a class="<?php if($current_page == 'login.php') echo 'active' ?>" href="login.php">Login</a></li>
        </ul>
</div>

<style>
    /* Adicionando estilos específicos para a navegação na folha de estilo principal ou aqui */
    .navbar ul {
        list-style: none; /* Remove bolinhas */
        margin: 0;
        padding: 0;
        display: flex; /* Para deixar os itens na mesma linha */
        justify-content: flex-end; /* Alinha os itens à direita */
        background-color: #333; /* Cor de fundo da barra de navegação */
        padding: 10px 20px; /* Espaçamento interno */
    }

    .navbar li {
        margin-left: 20px; /* Espaço entre os itens do menu */
    }

    .navbar a {
        color: white; /* Cor do texto */
        text-decoration: none; /* Remove sublinhado */
        padding: 5px 10px;
        display: block; /* Para o padding funcionar */
    }

    .navbar a:hover {
        background-color: #575757; /* Cor de fundo ao passar o mouse */
        border-radius: 4px;
    }

    /* Estilo para a página ativa */
    .navbar a.active {
        color: #ff0000; /* Cor vermelha para a página ativa */
        font-weight: bold;
        text-decoration: underline;
    }
</style>

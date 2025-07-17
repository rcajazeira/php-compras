<div class="container" style="text-align: center; margin-top: 30px; border-top: 1px solid #eee; padding-top: 15px; color: #888;">
        &copy; <?php echo date("Y"); ?> Compra PHP. Rafael Cajazeira Fullstack.
    </div>

    </body>
</html>
<?php
// Fecha a conexão com o banco de dados se ela estiver aberta.
// É uma boa prática fechar a conexão depois que todo o processamento da página estiver concluído.
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>
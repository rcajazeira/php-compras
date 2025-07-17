<?php
// Inicia a sessão PHP.
// Esta função deve ser chamada no início de cada script que usa sessões.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Você pode adicionar mais lógica de sessão aqui, como:
// - Verificação se o usuário está logado
// - Configurações de tempo de vida da sessão
// - Regeneração de ID de sessão por segurança

?>
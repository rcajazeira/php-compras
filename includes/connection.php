<?php
// Database connection file
$host = 'localhost';
$dbname = 'compra_php';
$dbuser = 'root';
$dbpassword = 'root';


// mysql:host=$host;dbname=$dbname
$pdo = new PDO( "mysql:host=$host;dbname=$dbname", $dbuser, $dbpassword);
// Seta o modo de erro do PDO para exceção
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Seta o modo de busca padrão para FETCH_ASSOC (array associativo)
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);












/*
$servername = "localhost"; // Endereço do seu servidor MySQL (geralmente localhost para desenvolvimento local)
$username = "root";      // Seu nome de usuário do MySQL
$password = "root";          // Sua senha do MySQL. **ATENÇÃO:** Se você definiu uma senha para o usuário 'root' no MySQL Workbench ou na instalação do XAMPP/WAMP/MAMP, você DEVE colocá-la aqui. Se estiver em branco na sua configuração MySQL, pode deixar em branco aqui.
$dbname = "compra_php";  // O nome do banco de dados que você criou no MySQL Workbench (o schema)

// Cria uma nova conexão MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve algum erro na conexão
if ($conn->connect_error) {
    // Se houver um erro, interrompe o script e exibe a mensagem de erro
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Opcional: Define o conjunto de caracteres para UTF-8. Isso ajuda a evitar problemas com acentos e caracteres especiais.
$conn->set_charset("utf8");

// Você pode descomentar a linha abaixo para testar se a conexão foi bem-sucedida,
// mas remova-a em produção para não expor mensagens de depuração.
// echo "Conexão bem-sucedida ao banco de dados!";

*/
?>

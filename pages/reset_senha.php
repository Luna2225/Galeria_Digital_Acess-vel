<?php
// reset_senha.php

// Defina as informações de conexão com o banco de dados
$host = 'localhost';
$dbName = 'galeria';
$username = 'root';
$password = '99323592';

try {
    // Estabeleça a conexão com o banco de dados
    $conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Caso ocorra algum erro na conexão, exiba uma mensagem de erro
    echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verificar se o email existe no banco de dados ou no sistema
    // ...

    // Gerar um token único para o link de redefinição de senha
    $token = uniqid();

    // Salvar o token e o email em um banco de dados ou em uma tabela temporária
    $stmt = $conn->prepare("INSERT INTO tabela_temporaria (token_reset, email) VALUES (:token, :email)");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Enviar o email com o link de redefinição de senha
    $resetLink = 'https://arceble.000webhostapp.com/pages/nova_senha.php?token=' . $token;
    $emailBody = 'Clique no link a seguir para redefinir sua senha: ' . $resetLink;
    mail($email, 'Redefinição de Senha', $emailBody);

    // Redirecionar para a página de login
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>
</head>

<body>
    <h2>Redefinição de Senha</h2>
    <form action="" method="POST">
        <input type="email" name="email" placeholder="Digite o seu email" required>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>
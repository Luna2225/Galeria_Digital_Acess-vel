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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="/assets/css/style.css">

    <link rel="icon" type="image/png" href="/assets/logo/logoarceble copy.png" />

    <title>Redefinição de Senha</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg" id="menu">
        <div class="container-fluid">
            <a href="/index.php" class="navbar-brand disabled" id="logo" aria-label="Página inicial da ARCEBLE">ARCEBLE</a>
        </div>
    </nav>

    <center>
        <div class="container-fluid">
            <form action="" class="contact__form" method="POST">
                <h2 class="section">Redefinição de Senha</h2>
                <div class="mb-3">
                    <input type="email" name="email" placeholder="Digite o seu email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <input type="submit" value="Enviar" class="btn btn-primary">
                </div>
            </form>
        </div>
    </center>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>

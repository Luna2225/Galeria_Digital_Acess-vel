<?php
// nova_senha.php

// Defina as informações de conexão com o banco de dados
$host = 'localhost';
$dbName = 'galeria';
$username = 'root';
$password = '81336840';

try {
    // Estabeleça a conexão com o banco de dados
    $conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Caso ocorra algum erro na conexão, exiba uma mensagem de erro
    echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_senha'])) {
    $token = $_POST['token'];
    $novaSenha = $_POST['nova_senha'];

    // Verificar se o token existe na tabela temporária
    $stmt = $conn->prepare("SELECT * FROM tabela_temporaria WHERE token_reset = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resultado) {
        echo 'Token inválido.';
        exit;
    }

    // Atualizar a senha do usuário na tabela "usuarios"
    $email = $resultado['email'];

    $stmt = $conn->prepare("UPDATE usuarios SET senha = :senha WHERE email = :email");
    $stmt->bindParam(':senha', $novaSenha);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Remover o token da tabela temporária
    $stmt = $conn->prepare("DELETE FROM tabela_temporaria WHERE token_reset = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    // Exibir uma mensagem informando que a senha foi redefinida com sucesso
    echo 'A sua senha foi redefinida com sucesso!';
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

    <title>Nova Senha</title>
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
                <h2 class="section">Nova Senha</h2>
                <div class="mb-3">
                    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                </div>
                <div class="mb-3">
                    <input type="password" name="nova_senha" placeholder="Digite a nova senha" class="form-control" required>
                </div>
                <div class="mb-3">
                    <input type="submit" value="Redefinir Senha" class="btn btn-primary">
                </div>
            </form>
        </div>
    </center>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>

<?php
// nova_senha.php

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha</title>
</head>

<body>
    <h2>Nova Senha</h2>
    <form action="" method="POST">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <input type="password" name="nova_senha" placeholder="Digite a nova senha" required>
        <input type="submit" value="Redefinir Senha">
    </form>
</body>

</html>
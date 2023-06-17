<?php
require_once "../functions.php";
if (isset($_POST['acessar'])) {
  login($conn);
}

// Verifica se há um erro definido na URL
if (isset($_GET['erro']) && $_GET['erro'] == 1) {
  $error_message = "Usuário e senha não encontrados";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

  <link rel="stylesheet" href="/assets/css/style.css">

  <link rel="icon" type="image/png" href="/assets/logo/logoarceble copy.png" />

  <title>Login | Arceble</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg" id="menu">
    <div class="container-fluid">
      <a href="/index.php" class="navbar-brand disabled" id="logo" aria-label="Página inicial da ARCEBLE">ARCEBLE</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" href="/index.php" aria-label="Página inicial">HOME</a>
          <a class="nav-link" href="sobre.php" aria-label="Página sobre">SOBRE</a>
          <a class="nav-link" href="contato.php" aria-label="Página de contato">CONTATO</a>
          <a class="nav-link" href="galeria.php" aria-label="Página da galeria">GALERIA</a>
          <a class="nav-link" href="eventos.php" aria-label="Página de eventos">EVENTOS</a>
          <a class="nav-link active" href="#" aria-label="Página de login">LOGIN</a>
          <a class="nav-link" href="cadastro_pessoa.php" aria-label="Página de cadastro">CADASTRO</a>
        </div>
      </div>
    </div>
  </nav>

  <center>
    <div class="container-fluid">
      <?php if (isset($_GET['erro']) && $_GET['erro'] == 1) : ?>
        <div class="alert alert-danger" role="alert">
          Usuário e senha não encontrados
        </div>
      <?php endif; ?>
      <form action="" class="contact__form" method="post">
        <h2 class="section">Login</h2>
        <label>O que você é?</label> <br>
        <select class="contact__input" placeholder="" name="tipo_usuario" aria-label="Selecione o tipo de usuário">
          <option>Selecione uma opção</option>
          <option value="artista">Artista</option>
          <option value="anfitriao">Curador</option>
        </select>
        <input type="email" name="email" placeholder="Email" autocomplete="name" class="contact__input" required aria-label="Digite o seu email">
        <input type="password" name="senha" placeholder="senha" autocomplete="senha" class="contact__input" required required aria-label="Digite a sua senha">

        <input class="contact__button button" type="submit" name="acessar" value="Acessar" aria-label="Acessar"><br><br>

        <a href="reset_senha.php">Esqueci minha senha</a><br><br>
      </form>
    </div>
  </center>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>
<?php
require_once "../functions.php";
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

  <title>Cadastro | Arceble</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg" id="menu">
    <div class="container-fluid">
      <a href="/index.php" class="navbar-brand disabled" id="logo">ARCEBLE</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" aria-current="page" href="/index.php">HOME</a>
          <a class="nav-link" href="sobre.php">SOBRE</a>
          <a class="nav-link" href="contato.php">CONTATO</a>
          <a class="nav-link" href="galeria.php">GALERIA</a>
          <a class="nav-link" href="eventos.php">EVENTOS</a>
          <a class="nav-link" href="login.php">LOGIN</a>
          <a class="nav-link active" href="#">CADASTRO</a>
        </div>
      </div>
    </div>
  </nav>

  <center>
    <div class="container-fluid">
      <?php
      $tabela = "usuarios";
      $order = "nome";
      inserirUsuario($conn);
      ?>
      <form action="" class="contact__form" method="post">
        <h2 class="section">Cadastro</h2>
        <input type="text" placeholder="Nome Completo" autocomplete="name" class="contact__input" name="nome">
        <input type="date" placeholder="Data de Nascimento" autocomplete="number" class="contact__input" name="data_nasc">
      
        <p>
        <b><label>Gênero</label> <br>
        <select name="genero" class="contact__input" autocomplete="organization-title">
          <option>Selecione uma opção</option>
          <option value="Masculino">Masculino</option>
          <option value="Feminino">Feminino</option>
          <option value="Transgênero">Transgênero</option>
          <option value="Não-binário">Não-binário</option>
          <option value="Outro">Outro</option>
        </select>
        </p>

        <p>
          <label>O que você é?</label> <br>
          <select class="contact__input" autocomplete="organization-title" placeholder="" name="tipo_usuario">
            <option>Selecione uma opção</option>
            <option value="artista">Artista</option>
            <option value="anfitriao">Curador</option>
          </select>
        </p>
        <input type="email" placeholder="Email" autocomplete="email" name="email" class="contact__input">
        <input type="password" placeholder="Senha" name="senha" class="contact__input">
        <input type="password" placeholder="Confirmar Senha" name="repetesenha" class="contact__input">
        <input type="submit" value="Cadastrar" name="cadastrar" class="contact__button button">
      </form>
    </div>
  </center>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
</body>

</html>
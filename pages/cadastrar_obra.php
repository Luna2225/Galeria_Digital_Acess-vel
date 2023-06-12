<?php
session_start();
$seguranca = isset($_SESSION['ativa']) ? TRUE : header("location: ../login.php");
require_once "../functions.php";


if (isset($_POST['cadastrarObra'])) {
    cadastrarObra($conn, $Artista_id);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <script src="https://kit.fontawesome.com/54ae61cac0.js" crossorigin="anonymous"></script>

  <title>Cadastrar Obras</title>

  <link rel="icon" type="image/png" href="../assets/logo/logoarceble copy.png" />

  <link rel="stylesheet" href="../assets/css/autor.css">

</head>

<body>
  <nav class="navbar" id="menu">
    <div class="container-fluid">
      <a class="navbar-brand" id="logo">ARCEBLE</a>
      <a href="../logout.php" id="sair" id="sair">Sair <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
    </div>
  </nav>

  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="inicial_artista.php">Obras Cadastradas</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="#">Cadastrar obras</a>
    </li>
  </ul>

  <center>
    <div class="">
      <form action="" class="contact__form" method="post" enctype="multipart/form-data">
        <h2 class="section-title">Cadastrar Obra</h2>
        <input type="text" placeholder="Autor" autocomplete="name" class="contact__input" name="autor">
        <input type="text" placeholder="Nome da obra" class="contact__input" name="nome_obra">

        <p>
          <b><label class="input-group" for="inputGroupFile02">Imagem</label></b>
          <input type="file" class="input1 contact__input" id="inputGroupFile02" name="imagem">
        </p>

        <p>
          <b><label class="input-group" for="inputGroupFile02">Audiodescrição</label></b>
          <input type="file" class="input1 contact__input" id="inputGroupFile02" name="audiodescricao">
        </p>

        <b><label>Descrição da obra</label></b>
        <textarea name="Descricao" id="" cols="0" rows="10" class="contact__input" required placeholder="Descreva aqui"></textarea>
        
        <b><label>Descreva a imagem da obra</label></b><br>
        <textarea name="LongaDesc" id="" cols="0" rows="10" class="contact__input" required placeholder="Descreva aqui"></textarea>
        
        <input type="submit" value="Cadastrar" name="cadastrarObra" class="button1 button">
      </form>
    </div>
  </center>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>
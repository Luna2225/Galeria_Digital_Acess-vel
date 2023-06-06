<?php
session_start();
$seguranca = isset($_SESSION['id_Usuarios']) ? true : header("location: ../login.php");
require_once "../functions.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <script src="https://kit.fontawesome.com/54ae61cac0.js" crossorigin="anonymous"></script>

  <title>Editar Obra</title>

  <link rel="icon" type="image/png" href="../assets/logo/logoarceble copy.png" />

  <link rel="stylesheet" href="../assets/css/autor.css">

</head>

<body>
  <nav class="navbar" id="menu">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.html" id="logo">ARCEBLE</a>
      <a href="../logout.php" id="sair">Sair <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
    </div>
  </nav>

  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="inicial_artista.php">Obras Cadastradas</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="#">Editar obra</a>
    </li>
  </ul>

  <center>
    <div class="">
      <?php if ($seguranca) { ?>

        <?php if (isset($_GET['id_Obras'])) {
          $id_Obras = $_GET['id_Obras'];
          $tabela = "obras";
          $obra = listar_obra($conn, $tabela, $id_Obras);
          AtualizarObra($conn);
        ?>
          <h2>Editando a obra: <?php echo $_GET['nome_obra']; ?></h2>

        <?php } ?>

        <form action="" class="contact__form" method="post" enctype="multipart/form-data">
          <h2 class="section-title">Editar Obra</h2>

          <input value="<?php echo $_GET['Artista_id']; ?>" type="hidden" name="Artista_id">
          <input value="<?php echo $_GET['dataCriacao']; ?>" type="hidden" name="dataCriacao">
          <input value="<?php echo $_GET['id_Obras']; ?>" type="hidden" name="id_Obras">
          <input value="<?php echo $_GET['autor']; ?>" type="text" placeholder="Autor" autocomplete="name" class="contact__input" name="autor">
          <input value="<?php echo $_GET['nome_obra']; ?>" type="text" placeholder="Nome da obra" class="contact__input" name="nome_obra">

          <p>
            <b><label class="input-group" for="inputGroupFile02">Imagens</label></b>
            <input value="<?php echo $_GET['imagem']; ?>" type="file" class="input1 contact__input" id="inputGroupFile02" name="imagem">
          </p>

          <p>
            <b><label class="input-group" for="inputGroupFile02">Audiodescrição</label></b>
            <input value="<?php echo $_GET['audiodescricao']; ?>" type="file" class="input1 contact__input" id="inputGroupFile02" name="audiodescricao">
          </p>

          <b><label>Descrição da obra</label></b>
          <textarea value="<?php echo $_GET['Descricao']; ?>" name="Descricao" id="" cols="0" rows="10" class="contact__input" required placeholder="Descreva aqui"></textarea>
          <b><label>O que te motivou a produzir sua obra</label></b><br>
          <textarea value="<?php echo $_GET['LongaDesc']; ?>" name="LongaDesc" id="" cols="0" rows="10" class="contact__input" required placeholder="Digite aqui"></textarea>
          <input type="submit" value="Cadastrar" name="atualizarObra" class="button1 button">
        </form>
      <?php } ?>
    </div>
  </center>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>
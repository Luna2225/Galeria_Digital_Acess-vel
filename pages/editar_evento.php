<?php
session_start();
$seguranca = isset($_SESSION['id_Usuarios']) ? TRUE : header("location: ../login.php");
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

  <title>Editar Eventos</title>

  <link rel="icon" type="image/png" href="../assets/logo/logoarceble copy.png" />

  <link rel="stylesheet" href="../assets/css/autor.css">

</head>

<body>
  <nav class="navbar" id="menu">
    <div class="container-fluid">
      <a class="navbar-brand" id="logo">ARCEBLE</a>
      <a href="#" id="sair">Sair <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
    </div>
  </nav>

  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="inicial_curador.php">Eventos Cadastrados</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="#">Editar eventos</a>
    </li>
  </ul>

  <center>
    <div class="">
      <?php if ($seguranca) { ?>

        <?php if (isset($_GET['idExposicoes'])) {
          $idExposicoes = $_GET['idExposicoes'];
          $tabela = "exposicoes";
          $exposicoes = listar_evento($conn, $idExposicoes, $tabela);
          atualizarExposicao($conn);
        ?>
          <h2>Editando o evento: <?php echo $_GET['Nome_expo']; ?></h2>

        <?php } ?>
        <form action="" class="contact__form" method="post" enctype="multipart/form-data">
          <h2 class="section-title">Editar Eventos</h2>
          <input value="<?php echo $_GET['id_Anfitriao']; ?>" type="hidden" name="id_Anfitriao">
          <input value="<?php echo $_GET['idExposicoes']; ?>" type="hidden" name="idExposicoes">

          <input value="<?php echo $_GET['Nome_expo']; ?>" type="text" placeholder="Nome do Evento" autocomplete="name" class="contact__input" name="Nome_expo">

          <b><label class="input-group">Descrição do evento</label></b>
          <textarea value="<?php echo $_GET['Desc_expo']; ?>" name="Desc_expo" id="" cols="0" rows="2" class="contact__input" required placeholder="Descreva aqui"></textarea>

          <p>
            <b><label class="input-group" for="inputGroupFile02">Imagens</label></b>
            <input value="<?php echo $_GET['Imagem']; ?>" type="file" class="input1 contact__input" id="inputGroupFile02" name="Imagem">
          </p>

          <b><label class="input-group">Data inicial do evento</label></b>
          <input value="<?php echo $_GET['DataInicial']; ?>" name="DataInicial" type="date" class="contact__input">

          <b><label class="input-group">Data final do evento</label></b>
          <input value="<?php echo $_GET['DataFinal']; ?>" name="DataFinal" type="date" class="contact__input">

          <p>
            <b><label class="input-group" for="inputGroupFile02">Audiodescrição</label></b>
            <input value="<?php echo $_GET['Audio_expo']; ?>" type="file" class="input1 contact__input" id="inputGroupFile02" name="Audio_expo">
          </p>

          <input type="submit" value="Atualizar" name="atualizarExposicao" class="button1 button">
        </form>
      <?php } ?>
    </div>
  </center>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>
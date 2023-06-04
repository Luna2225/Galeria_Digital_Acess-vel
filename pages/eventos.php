<?php
session_start();
require_once "../functions.php";

$tabela = "exposicoes";
$exposicoes = todos($conn, $tabela);
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

  <title>Home | Arceble</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg" id="menu">
    <div class="container-fluid">
      <a href="/index.php" class="navbar-brand disabled" id="logo">ARCEBLE</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" aria-current="page" href="/index.php">HOME</a>
          <a class="nav-link" href="sobre.php">SOBRE</a>
          <a class="nav-link" href="contato.php">CONTATO</a>
          <a class="nav-link" href="galeria.php">GALERIA</a>
          <a class="nav-link active" href="#">EVENTOS</a>
          <a class="nav-link" href="login.php">LOGIN</a>
          <a class="nav-link" href="cadastro_pessoa.php">CADASTRO</a>
        </div>
      </div>
    </div>
  </nav>

  <center>
    <!-- === NOVOS EVENTOS === -->
    <div class="container-fluid">
      <?php if ($exposicoes) { ?>
        <div class="card mb-3 tela_eventos">
          <div class="row g-0">
            <?php foreach ($exposicoes as $exposicoe) { ?>
              <div class="col-md-4">
                <img src="<?php echo $exposicoe['Imagem']; ?>" class="card-img" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h1 class="card-title"><?php echo $exposicoe['Nome_expo']; ?></h1>
                  <p class="card-text"><?php echo $exposicoe['Desc_expo']; ?></p>
                  <div class="d-grid gap-2 col-6 mx-auto">
                    <a href="descricao_evento.php?idExposicoes=<?php echo $exposicoe['idExposicoes']; ?>" class="btn btn-primary px-4 py-2" id="btn">Mais</a>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>

    <!-- === FOOTER === -->
    <footer class="footer">
      <p class="footer__title">ARCEBLE</p>
      <div class="footer__social">
        <a href="#" class="footer__icon"><i class='bx bxl-github'></i></a>
        <a href="#" class="footer__icon"><i class='bx bxl-linkedin-square'></i></a>
        <a href="#" class="footer__icon"><i class='bx bxl-whatsapp'></i></a>
        <a href="#" class="footer__icon"><i class='bx bxl-facebook-circle'></i></a>
        <a href="#" class="footer__icon"><i class='bx bxl-instagram'></i></a>
      </div>
      <p>&#169; 2023 copyright all right reserved</p>
    </footer>

  </center>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>
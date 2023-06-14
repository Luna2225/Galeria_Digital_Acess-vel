<?php
session_start();
require_once "../functions.php";

$tabela = "obras";
$obras = todos($conn, $tabela);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

  <link rel="stylesheet" href="../assets/css/galeria.css">

  <link rel="icon" type="image/png" href="/assets/logo/logoarceble copy.png" />

  <title>Galeria | Arceble</title>
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
          <a class="nav-link active" href="#" aria-label="Página da galeria">GALERIA</a>
          <a class="nav-link" href="eventos.php" aria-label="Página de eventos">EVENTOS</a>
          <a class="nav-link" href="login.php" aria-label="Página de login">LOGIN</a>
          <a class="nav-link" href="cadastro_pessoa.php" aria-label="Página de cadastro">CADASTRO</a>
        </div>
      </div>
    </div>

  </nav>

  <center>

    <!-- === OBRAS FAVORITAS === -->
    <div class="container-fluid">

      <h2 class="section-title">A arceble apresenta exposições para todos</h2>
      <?php if (empty($obras)) : ?>
        <h1>Sem obras cadastradas</h1>
      <?php else : ?>
        <?php if ($obras) { ?>
          <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($obras as $obra) { ?>
              <div class="col">
                <div class="card h-100" id="card">
                  <a href="descricao_obra.php?id_Obras=<?php echo $obra['id_Obras']; ?>&origem=galeria"><img src="<?php echo $obra['imagem']; ?>" class="img-fluid " alt="<?php echo $obra['LongaDesc']; ?>"></a>
                  <div class="card-body">
                    <h2 class="card-title"><?php echo $obra['nome_obra']; ?></h2>
                    <p><?php echo $obra['autor']; ?></p>
                    <a href="descricao_obra.php?id_Obras=<?php echo $obra['id_Obras']; ?>&origem=galeria" class="btn btn-primary px-4 py-2 fs-5 mt-5" id="button">Mais</a>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      <?php endif; ?>
    </div>
    <!-- === FOOTER === -->
    <footer class="footer">
      <p class="footer__title">ARCEBLE</p>
      <div class="footer__social">
        <a href="#" class="footer__icon" aria-label="GitHub"><i class='bx bxl-github'></i></a>
        <a href="#" class="footer__icon" aria-label="LinkedIn"><i class='bx bxl-linkedin-square'></i></a>
        <a href="#" class="footer__icon" aria-label="WhatsApp"><i class='bx bxl-whatsapp'></i></a>
        <a href="#" class="footer__icon" aria-label="Facebook"><i class='bx bxl-facebook-circle'></i></a>
        <a href="#" class="footer__icon" aria-label="Instagram"><i class='bx bxl-instagram'></i></a>
      </div>
      <p>&copy; 2023 ARCEBLE. Todos os direitos reservados.</p>
    </footer>

  </center>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>
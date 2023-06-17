<?php session_start();
require_once "functions.php";

$tabela = "exposicoes";
$exposicoes = evento_index($conn, $tabela, $where = 1, $order = "idExposicoes DESC", $limit = 1);

$tabela1 = "obras";
$obras = obra_index($conn, $tabela1, $limit = 3);
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

  <link rel="stylesheet" href="assets/css/style.css">

  <link rel="icon" type="image/png" href="assets/logo/logoarceble copy.png" />

  <title>Home | Arceble</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg" id="menu">
    <div class="container-fluid">
      <a class="navbar-brand disabled" id="logo">ARCEBLE</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active" aria-current="page" href="#">HOME</a>
          <a class="nav-link" href="pages/sobre.php">SOBRE</a>
          <a class="nav-link" href="pages/contato.php">CONTATO</a>
          <a class="nav-link" href="pages/galeria.php">GALERIA</a>
          <a class="nav-link" href="pages/eventos.php">EVENTOS</a>
          <a class="nav-link" href="pages/login.php">LOGIN</a>
          <a class="nav-link" href="pages/cadastro_pessoa.php">CADASTRO</a>
        </div>
      </div>
    </div>
  </nav>

  <center>
    <!-- === LOGO E TITULO === -->
    <div class="container-fluid">
      <div class="row" id="principal">

        <div class="col-md-8">
          <div class="card-body">
            <h1 class="title">
              <span class="title-color">ARCEBLE</span><br>
              Uma Galeria de<br>
              Artes Virtuais<br>
              Acessível.
            </h1>
          </div>
        </div>
        <div class="col-md-4">
          <img src="assets/logo/logoarceble copy.png" class="img-fluid" alt="Logotipo da ARCEBLE">
        </div>
      </div>
    </div>

    <!-- === NOVAS OBRAS === -->
    <div class="container-fluid">
      <h2 class="section-title">Novas obras</h2>

      <?php if (empty($obras)): ?>
        <h1>Sem obras cadastradas</h1>
      <?php else: ?>
        <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <?php for ($i = 0; $i < count($obras); $i++): ?>
              <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="<?php echo $i; ?>" <?php if ($i === 0)
                   echo 'class="active" aria-current="true"'; ?> aria-label="Slide <?php echo ($i + 1); ?>"></button>
            <?php endfor; ?>
          </div>

          <div class="carousel-inner">
            <?php foreach ($obras as $index => $obra): ?>
              <div class="carousel-item <?php if ($index === 0)
                echo 'active'; ?> c-item">
                <img src="<?php echo $obra['imagem']; ?>" class="d-block w-100 c-img"
                  alt="Slide <?php echo ($index + 1); ?>">
                <div class="carousel-caption top-0 mt-4">
                  <p class="mt-5 fs-3 text-uppercase">
                    <?php echo $obra['autor']; ?>
                  </p>
                  <h1 class="display-1 fw-bolder text-capitalize">
                    <?php echo $obra['nome_obra']; ?>
                  </h1>
                  <a href="/pages/descricao_obra.php?id_Obras=<?php echo $obra['id_Obras']; ?>"
                    class="btn btn-primary px-4 py-2 fs-5 mt-5 detalhar-btn"
                    aria-label="Ver detalhes da obra <?php echo $obra['nome_obra']; ?>">Detalhar</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel" data-bs-slide="prev"
            aria-label="Slide anterior">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#hero-carousel" data-bs-slide="next"
            aria-label="Próximo slide">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      <?php endif; ?>
    </div>

    <!-- === NOVOS EVENTOS === -->
    <div class="container-fluid">
      <h2 class="section-title">Novo Evento</h2>

      <?php if (empty($exposicoes)): ?>
        <h1>Sem exposições cadastradas</h1>
      <?php else: ?>
        <div class="card mb-3 eventos" id="card">
          <?php foreach ($exposicoes as $exposicoe): ?>
            <div class="row g-0">
              <div class="col-md-4">
                <img src="<?php echo $exposicoe['Imagem']; ?>" class="card-img"
                  alt="<?php echo $exposicoe['Desc_Imagem']; ?>">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h1 class="card-title">
                    <?php echo $exposicoe['Nome_expo']; ?>
                  </h1>
                  <p class="card-text">
                    <?php echo $exposicoe['Desc_expo']; ?>
                  </p>
                  <p class="card-text">
                    <strong><i class="bi bi-calendar3"></i> Início:</strong>
                    <?php echo date('d/m/Y', strtotime($exposicoe['DataInicial'])); ?>
                  </p>
                  <p class="card-text">
                    <strong><i class="bi bi-calendar3"></i> Fim:</strong>
                    <?php echo date('d/m/Y', strtotime($exposicoe['DataFinal'])); ?>
                  </p>
                  <div class="d-grid gap-2 col-6 mx-auto">
                    <a href="/pages/descricao_evento.php?idExposicoes=<?php echo $exposicoe['idExposicoes']; ?>"
                      class="btn btn-primary px-4 py-2 detalhar-btn">Detalhar</a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
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
      <p>&copy; 2023 ARCEBLE. Todos os direitos reservados.</p>
    </footer>

  </center>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
</body>

</html>
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
          <img src="assets/logo/logoarceble copy.png" class="img-fluid" alt="...">
        </div>
      </div>
    </div>

    <!-- === NOVAS OBRAS === -->
    <div class="container-fluid">

      <h2 class="section-title">ARCEBLE</h2>

      <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="0" class="active" aria-current="true"
            aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">
          <div class="carousel-item active c-item">
            <img src="assets/img/01.jpg" class="d-block w-100 c-img" alt="Slide 1">
            <div class="carousel-caption top-0 mt-4">
              <p class="mt-5 fs-3 text-uppercase">Nome do Autor</p>
              <h1 class="display-1 fw-bolder text-capitalize">Nome da Obra</h1>

              <a href="descricao_obra.html" class="btn btn-primary px-4 py-2 fs-5 mt-5" id="button">Ver</a>
            </div>
          </div>
          <div class="carousel-item c-item">
            <img src="assets/img/02.jpg" class="d-block w-100 c-img" alt="Slide 2">
            <div class="carousel-caption top-0 mt-4">
              <p class="text-uppercase fs-3 mt-5">Nome do Autor</p>
              <p class="display-1 fw-bolder text-capitalize">Nome da Obra</p>

              <a href="descricao_obra.html" class="btn btn-primary px-4 py-2 fs-5 mt-5" id="button">Ver</a>
            </div>
          </div>
          <div class="carousel-item c-item">
            <img src="assets/img/03.jpg" class="d-block w-100 c-img" alt="Slide 3">
            <div class="carousel-caption top-0 mt-4">
              <p class="text-uppercase fs-3 mt-5">Nome do Autor</p>
              <p class="display-1 fw-bolder text-capitalize">Nome da Obra</p>

              <a href="descricao_obra.html" class="btn btn-primary px-4 py-2 fs-5 mt-5" id="button">Ver</a>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#hero-carousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

    </div>

    <!-- === NOVOS EVENTOS === -->
    <div class="container-fluid">
      <h2 class="section-title">Novos Eventos</h2>

      <div class="card mb-3 eventos" id="card">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="assets/img/05.jpg" class="card-img" alt="...">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h1 class="card-title">Card title</h1>
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                content. This content is a little bit longer.</p>
              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
              <div class="d-grid gap-2 col-6 mx-auto">
                <a href="#" class="btn btn-primary px-4 py-2">Ver</a>
              </div>
            </div>
          </div>
        </div>
      </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="icon" type="image/png" href="assets/logo/logoarceble copy.png" />
    <title>Editar_Eventos | Arceble</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg" id="menu">
        <div class="container-fluid">
          <a href="index.html" class="navbar-brand disabled" id="logo">ARCEBLE</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link" aria-current="page" href="index.html" id="nav__link">HOME</a>
              <a class="nav-link" href="galeria.html" id="nav__link">GALERIA</a>
              <a class="nav-link" href="eventos.html" id="nav__link">EVENTOS</a>
              <a class="nav-link" href="login.html" id="nav__link">LOGIN</a>
              <a class="nav-link" href="#" id="nav__link">CADASTRAR_OBRA</a>
              <a class="nav-link" href="#" id="nav__link">EDITAR_EVENTOS</a>
            </div>
          </div>
        </div>
      </nav>

      <center>
        <div class="">
            <form class="contact__form">
                <h2 class="section-title">Editar Eventos</h2>
                <input type="text" placeholder="Nome do autor" autocomplete="name" class="contact__input">
                <p><label for="data">Data Inicio:</label>
                <input type="date" id="data" name="data" value=""></p>
                <p><label for="data">Data Termino:</label>
                <input type="date" id="data" name="data" value=""><b></p>

                <p><label class="input-group" for="inputGroupFile02">Imagens</label>
                <input type="file" class="input1" id="inputGroupFile02"></p>

                <p><label class="input-group" for="inputGroupFile02">Audiodescrição</label>
                <input type="file" class="input1" id="inputGroupFile02"></p>

                <b><label>Descrição do Evento</label></b>
                <textarea name="" id="" cols="0" rows="10" class="contact__input" required
                    placeholder="Descreva aqui"></textarea>
                <input type="button" value="Salvar" class="button1 button">
            </form>
        </div>
      </center>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
</body>

</html>
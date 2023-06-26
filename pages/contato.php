<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="icon" type="image/png" href="/assets/logo/logoarceble copy.png" />

    <title>Contato | Arceble</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg" id="menu">
        <div class="container-fluid">
            <a href="/index.php" class="navbar-brand disabled" id="logo"
                aria-label="Página inicial da ARCEBLE">ARCEBLE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="/index.php" aria-label="Página inicial">HOME</a>
                    <a class="nav-link" href="sobre.php" aria-label="Página sobre">SOBRE</a>
                    <a class="nav-link active" href="#" aria-label="Página de contato">CONTATO</a>
                    <a class="nav-link" href="galeria.php" aria-label="Página da galeria">GALERIA</a>
                    <a class="nav-link" href="eventos.php" aria-label="Página de eventos">EVENTOS</a>
                    <a class="nav-link" href="login.php" aria-label="Página de login">LOGIN</a>
                    <a class="nav-link" href="cadastro_pessoa.php" aria-label="Página de cadastro">CADASTRO</a>
                </div>
            </div>
        </div>
    </nav>

    <center  class="bg1">
        <div class="container-fluid">
            <form class="contact__form" method="post">
                <h2 class="section">Contato</h2>
                <input type="text" placeholder="Name" autocomplete="name" class="contact__input">
                <input type="mail" placeholder="Email" autocomplete="email" class="contact__input">
                <textarea placeholder="Mensagem" name="" id="" cols="0" rows="10" class="contact__input"></textarea>
                <input type="button" value="Enviar" class="contact__button button" aria-label="Enviar mensagem">
            </form>
        </div>
    </center>

    <?php require_once "../footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>
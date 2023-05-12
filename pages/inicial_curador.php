<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/54ae61cac0.js" crossorigin="anonymous"></script>

    <title>Home| Anfitrião</title>

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
            <a class="nav-link active" aria-current="page" href="#">Eventos cadastrados</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="cadastrar_evento.php">Cadastrar evento</a>
        </li>
    </ul>


    <center>

        <!-- === NOVOS EVENTOS === -->
        <div class="container-fluid">

            <div class="card mb-3 tela_eventos">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="../assets/img/01.jpg" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h1 class="card-title">Card title</h1>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                additional
                                content. This content is a little bit longer.</p>
                            <div class="gap-2 col-6 mx-auto">
                                <a href="../editar_obra.html" class="btn btn-primary px-4 py-2" id="btn">Editar</a>
                                <a href="#" class="btn btn-primary px-4 py-2" id="btn">Ecluir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3 tela_eventos">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="../assets/img/03.jpg" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h1 class="card-title">Card title</h1>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                additional
                                content. This content is a little bit longer.</p>
                            <div class="gap-2 col-6 mx-auto">
                                <a href="../editar_obra.html" class="btn btn-primary px-4 py-2" id="btn">Editar</a>
                                <a href="#" class="btn btn-primary px-4 py-2" id="btn">Ecluir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>
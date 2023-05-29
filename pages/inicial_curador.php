<?php session_start();
$seguranca = isset($_SESSION['id_Usuarios']) ? TRUE : header("location: login.php");
require_once "../functions.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/54ae61cac0.js" crossorigin="anonymous"></script>

    <title>Home| Anfitrião</title>

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
            <a class="nav-link active" aria-current="page" href="#">Eventos cadastrados</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="cadastrar_evento.php">Cadastrar evento</a>
        </li>
    </ul>


    <center>

        <!-- === NOVOS EVENTOS === -->
        <div class="container-fluid">

            <?php if ($seguranca) { ?>
                <h3>Bem Vindo, <?php echo $_SESSION['nome']; ?></h3>

                <?php
                $tabela = "exposicoes";
                $id_Usuarios = $_SESSION['id_Usuarios'];
                $exposicoes = listar_evento($conn, $id_Usuarios, $tabela);

                if (isset($_GET['id'])) { ?>
                    <h2>Tem certeza que deseja deletar o evento <?php echo $_GET['Nome_expo']; ?></h2>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                        <input type="submit" name="deletar_exposicoes" value="Deletar">
                    </form>
                <?php } ?>

                <?php
                if (isset($_POST['deletar_exposicoes'])) {
                    deletar_exposicoes($conn, "exposicoes", $_POST['id']);
                    header("location: inicial_curador.php");
                }
                ?>

                <div class="card mb-3 tela_eventos">
                    <?php foreach ($exposicoes as $exposicoe) : ?>
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="<?php echo $exposicoe['Imagem']; ?>" class="card-img" alt="<?php echo $exposicoe['Desc_expo']; ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h1 class="card-title"><?php echo $exposicoe['Nome_expo']; ?></h1>
                                    <p class="card-text"><?php echo $exposicoe['Desc_expo']; ?></p>
                                    <div class="gap-2 col-6 mx-auto">
                                        <a href="editar_evento.php?idExposicoes=<?php echo $exposicoe['idExposicoes']; ?>&Nome_expo=<?php echo $exposicoe['Nome_expo']; ?>&Desc_expo=<?php echo $exposicoe['Desc_expo']; ?>&Imagem=<?php echo $exposicoe['Imagem']; ?>&DataInicial=<?php echo $exposicoe['DataInicial']; ?>&DataFinal=<?php echo $exposicoe['DataFinal']; ?>&Audio_expo=<?php echo $exposicoe['Audio_expo']; ?>&id_Anfitriao=<?php echo $exposicoe['id_Anfitriao']; ?>" class="btn btn-primary px-4 py-2" id="btn">Editar</a>
                                        <a href="inicial_curador.php?id=<?php echo $exposicoe['idExposicoes']; ?>&Nome_expo=<?php echo $exposicoe['Nome_expo']; ?>" class="btn btn-primary px-4 py-2" id="btn">Excluir</a>
                                        <a href="obra_evento.php?idExposicoes=<?php echo $exposicoe['idExposicoes']; ?>" class="btn btn-primary px-4 py-2" id="btn">Selecionar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php } ?>

        </div>
    </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>
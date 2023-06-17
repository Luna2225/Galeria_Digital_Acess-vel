<?php session_start();
$seguranca = isset($_SESSION['id_Usuarios']) ? TRUE : header("location: login.php");
require_once "../functions.php";
$tabela = "obras";
$id_Usuarios = $_SESSION['id_Usuarios'];
$obras = listar_obra($conn, $id_Usuarios, $tabela);

if (isset($_POST['deletar'])) {
    deletar($conn, "obras", $_POST['id']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/54ae61cac0.js" crossorigin="anonymous"></script>

    <title>Home | Artista</title>

    <link rel="icon" type="image/png" href="../assets/logo/logoarceble copy.png" />

    <link rel="stylesheet" href="../assets/css/autor.css">

</head>

<body>
    <nav class="navbar" id="menu">
        <div class="container-fluid">
            <a class="navbar-brand" id="logo">ARCEBLE</a>
            <a href="../logout.php" id="sair">Sair <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
        </div>
    </nav>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Obras Cadastradas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="cadastrar_obra.php">Cadastrar obra</a>
        </li>
    </ul>


    <center>
        <!-- === NOVOS EVENTOS === -->
        <div class="container-fluid">
            <?php if ($seguranca) { ?>
                <h3>Bem Vindo,
                    <?php echo $_SESSION['nome']; ?>
                </h3>

                <?php
                if (isset($_GET['id'])) { ?>
                    <h2>Tem certeza que deseja deletar a obra:
                        <?php echo $_GET['nome_obra']; ?>
                    </h2>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                        <input type="submit" name="deletar" class="btn btn-primary px-4 py-2" value="Deletar">
                        <a href="javascript:history.back()" class="btn btn-primary px-4 py-2">Cancelar</a>
                    </form>
                <?php } ?>

                <div class="card mb-3 tela_eventos">
                    <?php if (empty($obras)): ?>
                        <h1>Sem obras cadastradas</h1>
                    <?php else: ?>
                        <?php foreach ($obras as $obra): ?>
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="<?php echo $obra['imagem']; ?>" class="card-img"
                                        alt="<?php echo $obra['LongaDesc']; ?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h1 class="card-title">
                                            <?php echo $obra['nome_obra']; ?>
                                        </h1>
                                        <p class="card-text">
                                            <?php echo $obra['Descricao']; ?>
                                        </p>
                                        <div class="gap-2 col-6 mx-auto">
                                            <a href="Editar_Obra.php?id_Obras=<?php echo $obra['id_Obras']; ?>&nome_obra=<?php echo $obra['nome_obra']; ?>&autor=<?php echo $obra['autor']; ?>&Descricao=<?php echo $obra['Descricao']; ?>&LongaDesc=<?php echo $obra['LongaDesc']; ?>&imagem=<?php echo $obra['imagem']; ?>&audiodescricao=<?php echo $obra['audiodescricao']; ?>&dataCriacao=<?php echo $obra['dataCriacao']; ?>&Artista_id=<?php echo $obra['Artista_id']; ?>"
                                                class="btn btn-primary px-4 py-2" id="btn">Editar</a>
                                            <a href="inicial_artista.php?id=<?php echo $obra['id_Obras']; ?>&nome_obra=<?php echo $obra['nome_obra']; ?>"
                                                class="btn btn-primary px-4 py-2" id="btn">Excluir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php } ?>
        </div>
    </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>
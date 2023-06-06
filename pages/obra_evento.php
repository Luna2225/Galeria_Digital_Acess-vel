<?php
session_start();
$seguranca = isset($_SESSION['id_Usuarios']) ? TRUE : header("location: ../login.php");
require_once "../functions.php";

if (isset($_GET['idExposicoes'])) {
    $idExposicoes = $_GET['idExposicoes'];
    $tabela = "exposicoes";
    $exposicao = listar_exposicao($conn, $idExposicoes, $tabela);
} else {
    // Caso contrário, defina um valor padrão ou exiba uma mensagem de erro
    $idExposicoes = 1; // Exemplo: assume o ID 1 caso não esteja presente na URL
    // Ou exiba uma mensagem de erro e interrompa a execução da página
    // echo "ID de exposição não fornecido!";
    // exit;
}
$tabela = "obras";
$obras = listar_obras($conn, $tabela); // Função para obter todas as obras cadastradas

$tabelaExposicoesObras = "exposicoesobras";
$obrasExposicao = listar_obras_exposicao($conn, $idExposicoes, $tabelaExposicoesObras);

if (isset($_POST['salvar'])) {
    obra_evento($conn, $idExposicoes);
    header("Location: " . $_SERVER['PHP_SELF'] . "?idExposicoes=" . $idExposicoes);
    exit;
}

if (isset($_GET['removerObra'])) {
    $id_Obras = $_GET['removerObra'];
    remover_obra_exposicao($conn, $idExposicoes, $id_Obras);
    header("Location: " . $_SERVER['PHP_SELF'] . "?idExposicoes=" . $idExposicoes);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR" prefix="og: https://ogp.me/ns#">

<head>
    <meta property="og:title" content="The Rock" />
    <meta property="og:url" content="https://www.imdb.com/title/tt0117500/" />
    <meta property="og:description" content="Sean Connery found fame and fortune as the
           suave, sophisticated British agent, James Bond." />
    <meta property="og:type" content="article" />
    <meta property="whatsapp/site" content="https://br.freepik.com/fotos/flores" />

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/54ae61cac0.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../assets/css/autor.css">
    <link rel="stylesheet" href="../assets/css/teste-evento.css">

    <title>Descrição do Evento | Arceble</title>
</head>

<body>

    <nav class="navbar" id="menu">
        <div class="container-fluid">
            <a class="navbar-brand" href="inicial_curador.php" id="logo"><i class="fa-solid fa-arrow-left"></i> ARCEBLE</a>
            <a href="../logout.php" id="sair" id="sair">Sair <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
        </div>
    </nav>

    <center>
        <div class="container-fluid" id="container">
            <?php if ($seguranca && $exposicao) { ?>

                <!-- Código HTML para exibir os dados do evento -->
                <img src="<?php echo $exposicao['Imagem']; ?>" class="img-fluid img_even" alt="..."><br>
                <audio controls autoplay>
                    <source src="<?php echo $exposicao['Audio_expo']; ?>" type="audio/mpeg">
                </audio>
                <h1><?php echo $exposicao['Nome_expo']; ?></h1>
                <p><?php echo $exposicao['Desc_expo']; ?></p>
                <button type="button" class="btn btn-primary botao" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Cadastrar
                </button>
                <hr>

                <h2>Obras Cadastradas Neste Evento
                </h2>


                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar obra</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="">
                                    <div class="row">
                                        <?php foreach ($obras as $obra) { ?>
                                            <div class="col">
                                                <img src="<?php echo $obra['imagem']; ?>" alt="">
                                                <h6><?php echo $obra['nome_obra']; ?></h6>
                                                <p><?php echo $obra['autor']; ?></p>
                                                <label>
                                                    <input type="checkbox" name="obras[]" value="<?php echo $obra['id_Obras']; ?>" class="input">
                                                    <i class="btn btn-primary bt">Selecionar</i>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="salvar" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($obrasExposicao)) { ?>
                    <div class="container-fluid im">
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <?php foreach ($obrasExposicao as $obraExposicao) { ?>
                                <div class="col">
                                    <div class="card img">
                                        <img src="<?php echo $obraExposicao['imagem']; ?>" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $obraExposicao['nome_obra']; ?></h5>
                                            <p class="card-text"><?php echo $obraExposicao['autor']; ?></p>
                                            <div class="d-grid gap-2 col-6 mx-auto">
                                                <a href="<?php echo $_SERVER['PHP_SELF'] . '?idExposicoes=' . $idExposicoes . '&removerObra=' . $obraExposicao['id_Obras']; ?>" class="btn btn-danger">Remover</a>
                                                <a href="#" class="btn btn-primary ">Ver</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </center>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script src="assets/js/modal.js"></script>

    <script>
        var botoes = document.getElementsByClassName("bt");

        for (var i = 0; i < botoes.length; i++) {
            var botao = botoes[i];
            botao.addEventListener("click", function() {
                if (this.textContent === "Selecionar") {
                    this.textContent = "Selecionado";
                } else {
                    this.textContent = "Selecionar";
                }
            });
        }
    </script>
</body>

</html>
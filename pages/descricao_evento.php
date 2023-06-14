<?php
session_start();
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

// Verifique se o parâmetro origem está presente na URL
if (isset($_GET['origem']) && $_GET['origem'] === "eventos") {
    $origem = $_GET['origem'];
    $breadcrumbs = [
        ["Eventos", "eventos.php"],
        ["Descrição do evento", ""]
    ];
} else {
    // Caso a origem seja diferente de "galeria" ou não esteja definida
    $breadcrumbs = [
        ["Página inicial", "/index.php"],
        ["Descrição do evento", ""]
    ];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/54ae61cac0.js" crossorigin="anonymous"></script>

    <link rel="icon" type="image/png" href="../assets/logo/logoarceble copy.png" />

    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Descrição do Evento | Arceble</title>
</head>

<body>

    <nav class="navbar" id="menu">
        <div class="container-fluid">
            <a class="navbar-brand" href="javascript:history.back()" id="logo"><i class="fa-solid fa-arrow-left"></i> ARCEBLE</a>
        </div>
    </nav>

    <!-- Migalhas de pão -->
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);">
        <ul class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php if (!empty($breadcrumb[1])) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo $breadcrumb[1]; ?>"><?php echo $breadcrumb[0]; ?></a></li>
                <?php } else { ?>
                    <li class="breadcrumb-item" aria-current="page"><?php echo $breadcrumb[0]; ?></li>
                <?php } ?>
            <?php } ?>
        </ul>
    </nav>

    <center>
        <div class="container-fluid" id="container">
            <?php if ($exposicao) { ?>
                <img src="<?php echo $exposicao['Imagem']; ?>" class="img-fluid obra" alt="<?php echo $exposicao['Desc_Imagem']; ?>"><br>
                <audio controls autoplay>
                    <source src="<?php echo $exposicao['Audio_expo']; ?>" type="audio/mpeg">
                    <track kind="captions" src="<?php echo $exposicao['Desc_expo']; ?>" srclang="pt-BR" label="Português" default>
                </audio>

                <h1><?php echo $exposicao['Nome_expo']; ?>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" aria-label="Compartilhar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-share-fill" viewBox="0 0 16 16">
                            <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z" />
                        </svg>
                    </button>
                </h1>
                <p><?php echo $exposicao['Desc_expo']; ?></p>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Compartilhar</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <a href="whatsapp://send?text=Nome da obra:%0ahttps://br.freepik.com/fotos/flores" style="color: darkgreen;"><i class="fa-brands fa-whatsapp fa-3x"></i><br>whatsapp</a><br>
                                <a href="" style="color: blue;"><i class="fa-brands fa-facebook fa-3x"></i><br>Facebook</a><br>
                                <a href="" style="color: rgb(129, 39, 151);"><i class="fa-brands fa-instagram fa-3x"></i><br>Instagram</a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h2>Obras Cadastradas Neste Evento</h2>
                <div class="container-fluid im">
                    <?php if (empty($obrasExposicao)) : ?>
                        <h1>Sem obras cadastradas neste evento</h1>
                    <?php else : ?>
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <?php foreach ($obrasExposicao as $obraExposicao) { ?>
                                <div class="col">
                                    <div class="card img">
                                        <img src="<?php echo $obraExposicao['imagem']; ?>" class="card-img-top" alt="<?php echo $obraExposicao['LongaDesc']; ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $obraExposicao['nome_obra']; ?></h5>
                                            <p class="card-text"><?php echo $obraExposicao['autor']; ?></p>
                                            <div class="d-grid gap-2 col-6 mx-auto">
                                                <a href="descricao_obra.php?id_Obras=<?php echo $obraExposicao['id_Obras']; ?>&origem=descricao_evento" class="btn btn-primary ">Ver</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php } ?>
        </div>
    </center>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script src="assets/js/modal.js"></script>
</body>

</html>
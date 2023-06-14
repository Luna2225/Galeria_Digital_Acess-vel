<?php
session_start();
require_once "../functions.php";

// Verifique se o parâmetro id_Obras está presente na URL
if (isset($_GET['id_Obras'])) {
  $id_Obras = $_GET['id_Obras'];
  $tabela = "obras";
  $tipo = "id_Obras";
  $obras = consultar_obras($conn, $id_Obras, $tabela, $tipo);

  // Verifique se o parâmetro origem está presente na URL
  if (isset($_GET['origem']) && $_GET['origem'] === "galeria") {
    $origem = $_GET['origem'];
    $breadcrumbs = [
      ["Galeria", "galeria.php"],
      ["Descrição da obra", ""]
    ];
  } elseif (isset($_GET['origem']) && $_GET['origem'] === "descricao_evento") {
    $origem = $_GET['origem'];
    $breadcrumbs = [
      ["Eventos", "eventos.php"],
      ["Descrição do evento", ""]
    ];
  } else {
    // Caso a origem seja diferente de "galeria" ou "descricao_evento" ou não esteja definida
    $breadcrumbs = [
      ["Página inicial", "/index.php"],
      ["Descrição da obra", ""]
    ];
  }
} else {
  // Caso o parâmetro id_Obras não esteja presente, redirecione o usuário para a página galeria.php
  header("Location: galeria.php");
  exit; // Encerre a execução deste script após o redirecionamento
}

$Artista_id = $obras['Artista_id']; // ID do autor desejado
$tabela = "obras"; // Nome da tabela de obras
$tipo = "Artista_id";
$autor = consultar_obras($conn, $Artista_id, $tabela, $tipo);
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

  <title>Descrição da obra | Arceble</title>
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

      <?php if ($obras) { ?>
        <img src="<?php echo $obras['imagem']; ?>" class="img-fluid obra" alt="<?php echo $obras['LongaDesc']; ?>"><br>
        <audio controls autoplay>
          <source src="<?php echo $obras['audiodescricao']; ?>" type="audio/mpeg">
        </audio>
        <hr>
        <h1><?php echo $obras['nome_obra']; ?>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-share-fill" viewBox="0 0 16 16">
              <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z" />
            </svg>
          </button>
        </h1>

        <p><?php echo $obras['Descricao']; ?></p>
      <?php } ?>

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

      <h2>Obras do mesmo autor</h2>
      <div class="container-fluid im">
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php
          // Verifica se existem obras do mesmo autor
          if ($obras) {

            // Loop para exibir cada obra do mesmo autor
            foreach ($autor as $obra) {
          ?>
              <div class="col">
                <div class="card img">
                  <img src="<?php echo $obra['imagem']; ?>" class="card-img-top" alt="<?php echo $obra['LongaDesc']; ?>">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $obra['nome_obra']; ?></h5>
                    <p class="card-text"><?php echo $obra['Descricao']; ?></p>
                    <div class="d-grid gap-2 col-6 mx-auto">
                      <a href="descricao_obra.php?id_Obras=<?php echo $obra['id_Obras']; ?>&origem=galeria" class="btn btn-primary">Ver</a>
                    </div>
                  </div>
                </div>
              </div>
          <?php
            }
          } else {
            echo "<p>Nenhuma obra encontrada.</p>";
          }
          ?>
        </div>
      </div>
    </div>
  </center>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

  <script src="assets/js/modal.js"></script>
</body>

</html>
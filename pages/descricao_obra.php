<?php
session_start();
require_once "../functions.php";

if (isset($_GET['id_Obras'])) {
  $id_Obras = $_GET['id_Obras'];
  $tabela = "obras";
  $obras = todas_obras($conn, $id_Obras, $tabela);
} else {
  // Caso contrário, defina um valor padrão ou exiba uma mensagem de erro
  $idExposicoes = 1; // Exemplo: assume o ID 1 caso não esteja presente na URL
  // Ou exiba uma mensagem de erro e interrompa a execução da página
  // echo "ID de exposição não fornecido!";
  // exit;
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

  <title>Descrição da obra | Arceble</title>
</head>

<body>

  <nav class="navbar" id="menu">
    <div class="container-fluid">
      <a class="navbar-brand" href="javascript:history.back()" id="logo"><i class="fa-solid fa-arrow-left"></i> ARCEBLE</a>
    </div>
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

      <h2>Obras Recomendadas</h2>
      <div class="container-fluid im">
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col">
            <div class="card img">
              <img src="../assets/img/01.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <div class="d-grid gap-2 col-6 mx-auto">
                  <a href="#" class="btn btn-primary ">Ver</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card img">
              <img src="../assets/img/01.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <div class="d-grid gap-2 col-6 mx-auto">
                  <a href="#" class="btn btn-primary ">Ver</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card img">
              <img src="../assets/img/01.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <div class="d-grid gap-2 col-6 mx-auto">
                  <a href="#" class="btn btn-primary ">Ver</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </center>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

  <script src="assets/js/modal.js"></script>
</body>

</html>
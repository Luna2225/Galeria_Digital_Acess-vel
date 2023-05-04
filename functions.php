<?php
$servidor = "localhost";
$usuario = "root";
$senha = "99323592";
$banco = "galeria";

$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

function login($conn)
{
  if (isset($_POST['acessar']) and !empty($_POST['email']) and !empty($_POST['senha']) and !empty($_POST['tipo_usuario'])) {
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Adicione a cláusula WHERE para filtrar pelo tipo de usuário
    // Use JOIN para unir as tabelas
    $query = "SELECT usuarios.*, IFNULL(anfitriao.nome, artista.nome) AS nome FROM usuarios LEFT JOIN anfitriao ON usuarios.id = anfitriao.id LEFT JOIN artista ON usuarios.id = artista.id WHERE usuarios.email = '$email' AND usuarios.senha = '$senha' AND usuarios.tipo_usuario = '$tipo_usuario'";
    $executar = mysqli_query($conn, $query);
    $return = mysqli_fetch_assoc($executar);

    if (!empty($return['email'])) {
      // echo "Bem vindo " . $return['nome'];
      session_start();
      $_SESSION['nome'] = $return['nome'];
      $_SESSION['id'] = $return['id'];
      $_SESSION['ativa'] = TRUE;
      header("location: ../autor/index.php");
    } else {
      echo "Usuário e senha não encontrados";
    }
  }
}

function logout()
{
  session_start();
  session_unset();
  session_destroy();
  header("location: login.php");
}

/* Seleciona(busca) no BD apenas um resultado com base no iD*/
function listar_obra($conn, $id)
{
  $query = "SELECT * FROM obras JOIN artista ON obras.Artista_id = artista.id WHERE artista.id =" . (int) $id;
  $execute = mysqli_query($conn, $query);
  $obras = array();
  while ($result = mysqli_fetch_assoc($execute)) {
    $obras[] = $result;
  }
  return $obras;
}



/* Seleciona(busca) no BD todos os resultado com base no WHERE*/
function listar_obras($conn, $tabela, $where = 1, $order = "")
{
  if (!empty($order)) {
    $order = "ORDER BY $order";
  }

  $query = "SELECT * FROM $tabela WHERE $where $order";
  $execute = mysqli_query($conn, $query);
  $results = mysqli_fetch_all($execute, MYSQLI_ASSOC);
  return $results;
}

/* Inserir novos usuarios */
function inserirUsuario($conn)
{
  if ((isset($_POST['cadastrar']) and !empty($_POST['email']) and !empty($_POST['senha']))) {
    $erros = array();
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $senha = $_POST['senha'];
    $tipo_usuario = mysqli_real_escape_string($conn, $_POST['tipo_usuario']);
    $data_nasc = $_POST['data_nasc'];
    $genero = $_POST['genero'];

    if ($_POST['senha'] != $_POST['repetesenha']) {
      $erros[] = "Senhas não conferem!";
    }
    $queryEmail = "SELECT email FROM usuarios WHERE email = '$email'";
    $buscaEmail = mysqli_query($conn, $queryEmail);

    if ($buscaEmail === false) {
      $erros[] = "Erro ao verificar email";
    } else {
      $verifica = mysqli_num_rows($buscaEmail);

      if (!empty($verifica)) {
        $erros[] = "Email já cadastrado!";
      }
    }

    if (empty($erros)) {
      $sql = "INSERT INTO usuarios (email, senha, tipo_usuario) VALUES ('$email', '$senha', '$tipo_usuario')";
      if ($conn->query($sql) === TRUE) {
        $id_usuario = $conn->insert_id;

        if ($tipo_usuario === 'anfitriao') {
          $sql = "INSERT INTO anfitriao (id, nome, data_nasc, genero) VALUES ($id_usuario, '$nome', '$data_nasc', '$genero')";
        } elseif ($tipo_usuario === 'artista') {
          $sql = "INSERT INTO artista (id, nome, data_nasc, genero) VALUES ($id_usuario, '$nome', '$data_nasc', '$genero')";
        }
        $executar = mysqli_query($conn, $sql);
        if ($executar) {
          header("location: login.php");
        } else {
          echo "Erro ao inserir usuário!";
        }
      } else {
        echo "Erro ao inserir usuário!";
      }
    } else {
      foreach ($erros as $erro) {
        echo "<p>$erro</p>";
      }
    }
  }
}

/* Apagar algum dado do BD */
function deletar($conn, $tabela, $id)
{
  if (!empty($id)) {
    $query = "DELETE FROM $tabela WHERE id =" . (int) $id;
    $execute = mysqli_query($conn, $query);
    if ($execute) {
      echo "Dado deletado com sucesso!";
    } else {
      echo "Erro ao deletar dado!";
    }
  }
}

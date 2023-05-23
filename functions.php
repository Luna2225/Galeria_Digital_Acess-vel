<?php
$servidor = "localhost";
$usuario = "root";
$senha = "81336840";
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
    $query = "SELECT usuarios.*, IFNULL(anfitriao.nome, artista.nome) AS nome FROM usuarios LEFT JOIN anfitriao ON usuarios.id_Usuarios = anfitriao.id_Anfitriao LEFT JOIN artista ON usuarios.id_Usuarios = artista.id_Artista WHERE usuarios.email = '$email' AND usuarios.senha = '$senha' AND usuarios.tipo_usuario = '$tipo_usuario'";
    $executar = mysqli_query($conn, $query);
    $return = mysqli_fetch_assoc($executar);

    if (!empty($return['email'])) {
      // echo "Bem vindo " . $return['nome'];
      session_start();
      $_SESSION['nome'] = $return['nome'];
      $_SESSION['id_Usuarios'] = $return['id_Usuarios'];
      $_SESSION['ativa'] = TRUE;
      header("location: /pages/inicial_artista.php");
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
  header("location: /pages/login.php");
}

/* Seleciona(busca) no BD apenas um resultado com base no iD*/
function listar_obra($conn, $id_Obras, $tabela)
{
  $query = "SELECT * FROM obras JOIN artista ON obras.Artista_id = artista.id_Artista WHERE artista.id_Artista =" . (int) $id_Obras;
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
          $sql = "INSERT INTO anfitriao (id_Anfitriao, nome, data_nasc, genero) VALUES ($id_usuario, '$nome', '$data_nasc', '$genero')";
        } elseif ($tipo_usuario === 'artista') {
          $sql = "INSERT INTO artista (id_Artista, nome, data_nasc, genero) VALUES ($id_usuario, '$nome', '$data_nasc', '$genero')";
        }
        $executar = mysqli_query($conn, $sql);
        if ($executar) {
          header("location: /pages/login.php");
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
function deletar($conn, $tabela, $id_Obras)
{
  if (!empty($id_Obras)) {
    $query = "DELETE FROM $tabela WHERE id_Obras =" . (int) $id_Obras;
    $execute = mysqli_query($conn, $query);
    if ($execute) {
      echo "Dado deletado com sucesso!";
    } else {
      echo "Erro ao deletar dado!";
    }
  }
}

function cadastrarObra($conn, $Artista_id)
{
  if (isset($_POST['cadastrarObra'])) {
    $id_Obras = rand(1, 999999);
    $autor = mysqli_real_escape_string($conn, $_POST['autor']);
    $Descricao = mysqli_real_escape_string($conn, $_POST['Descricao']);
    $nome_obra = mysqli_real_escape_string($conn, $_POST['nome_obra']);
    $imagem = $_FILES['imagem'];
    $LongaDesc = mysqli_real_escape_string($conn, $_POST['LongaDesc']);
    $audiodescricao = $_FILES['audiodescricao'];

    // Verificar se os arquivos foram enviados corretamente
    if ($imagem['error'] != UPLOAD_ERR_OK || $audiodescricao['error'] != UPLOAD_ERR_OK) {
      echo "Erro ao enviar arquivos: " . $imagem['error'] . ", " . $audiodescricao['error'];
      return;
    }

    // Validar os dados recebidos do formulário
    if (empty($autor) || empty($Descricao) || empty($nome_obra) || empty($LongaDesc)) {
      echo "Por favor, preencha todos os campos.";
      return;
    }

    // Obter a extensão do arquivo de imagem
    $imagem_extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));

    // Gerar um nome único para o arquivo de imagem
    $imagem_nome = uniqid() . "." . $imagem_extensao;

    // Mover o arquivo de imagem para o diretório de uploads
    $imagem_caminho = '../assets/img/';
    move_uploaded_file($imagem['tmp_name'], $imagem_caminho . $imagem_nome);

    // Obter a extensão do arquivo de áudio
    $audiodescricao_extensao = strtolower(pathinfo($audiodescricao['name'], PATHINFO_EXTENSION));

    // Gerar um nome único para o arquivo de áudio
    $audiodescricao_nome = uniqid() . "." . $audiodescricao_extensao;

    // Mover o arquivo de áudio para o diretório de uploads
    $audiodescricao_caminho = '../assets/audio/';
    move_uploaded_file($audiodescricao['tmp_name'], $audiodescricao_caminho . $audiodescricao_nome);

    $imagem_caminho_completo = $imagem_caminho . $imagem_nome;
    $audiodescricao_caminho_completo = $audiodescricao_caminho . $audiodescricao_nome;

    $Artista_id = $_SESSION['id_Usuarios'];
    // Obter a data atual
    $dataCriacao = date('Y-m-d');

    // Executar a inserção dos dados no banco de dados
    $query = "INSERT INTO obras (id_Obras, autor, Descricao, nome_obra, imagem, dataCriacao, LongaDesc, audiodescricao, Artista_id) VALUES ('$id_Obras', '$autor', '$Descricao', '$nome_obra', '$imagem_caminho_completo', '$dataCriacao', '$LongaDesc', '$audiodescricao_caminho_completo', '$Artista_id')";
    $resultado = mysqli_query($conn, $query);

    if ($resultado) {
      echo "Obra cadastrada com sucesso!";
      header("location: /pages/inicial_artista.php");
    } else {
      echo "Erro ao cadastrar obra: " . mysqli_error($conn);
    }
  }
}

function AtualizarObra($conn)
{
  if (isset($_POST['atualizar'])) {
    $Artista_id = $_SESSION['id_Usuarios'];
    $id_Obras = filter_input(INPUT_POST, "id_Obras", FILTER_VALIDATE_INT);
    $autor = mysqli_real_escape_string($conn, $_POST['autor']);
    $Descricao = mysqli_real_escape_string($conn, $_POST['Descricao']);
    $nome_obra = mysqli_real_escape_string($conn, $_POST['nome_obra']);
    $imagem = $_FILES['imagem'];
    $LongaDesc = mysqli_real_escape_string($conn, $_POST['LongaDesc']);
    $audiodescricao = $_FILES['audiodescricao'];

    if ($imagem['error'] != UPLOAD_ERR_OK || $audiodescricao['error'] != UPLOAD_ERR_OK) {
      echo "Erro ao enviar arquivos: " . $imagem['error'] . ", " . $audiodescricao['error'];
      return;
    }

    // Validar os dados recebidos do formulário
    if (empty($autor) || empty($Descricao) || empty($nome_obra) || empty($LongaDesc)) {
      echo "Por favor, preencha todos os campos.";
      return;
    }

    // Obter a extensão do arquivo de imagem
    $imagem_extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));

    // Gerar um nome único para o arquivo de imagem
    $imagem_nome = uniqid() . "." . $imagem_extensao;

    // Mover o arquivo de imagem para o diretório de uploads
    $imagem_caminho = '../assets/img/';
    move_uploaded_file($imagem['tmp_name'], $imagem_caminho . $imagem_nome);

    // Obter a extensão do arquivo de áudio
    $audiodescricao_extensao = strtolower(pathinfo($audiodescricao['name'], PATHINFO_EXTENSION));

    // Gerar um nome único para o arquivo de áudio
    $audiodescricao_nome = uniqid() . "." . $audiodescricao_extensao;

    // Mover o arquivo de áudio para o diretório de uploads
    $audiodescricao_caminho = '../assets/audio/';
    move_uploaded_file($audiodescricao['tmp_name'], $audiodescricao_caminho . $audiodescricao_nome);

    $imagem_caminho_completo = $imagem_caminho . $imagem_nome;
    $audiodescricao_caminho_completo = $audiodescricao_caminho . $audiodescricao_nome;

    // Obter a data atual
    $dataCriacao = date('Y-m-d');

    $query = "UPDATE obras SET autor='$autor', Descricao='$Descricao', nome_obra='$nome_obra', imagem='$imagem_caminho_completo', dataCriacao='$dataCriacao', LongaDesc='$LongaDesc', audiodescricao='$audiodescricao_caminho_completo', Artista_id='$Artista_id' WHERE id_Obras='$id_Obras'";
    $resultado = mysqli_query($conn, $query);

    if ($resultado) {
      echo "Obra atualizada com sucesso!";
      header("location: index.php");
    } else {
      echo "Erro ao atualizar obra: " . mysqli_error($conn);
    }
  }
}

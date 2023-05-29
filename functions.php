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
      session_start();
      $_SESSION['nome'] = $return['nome'];
      $_SESSION['id_Usuarios'] = $return['id_Usuarios'];
      $_SESSION['ativa'] = TRUE;
      if ($tipo_usuario === 'artista') {
        header("location: /pages/inicial_artista.php");
      } elseif ($tipo_usuario === 'anfitriao') {
        header("location: /pages/inicial_curador.php");
      }
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

function listar_evento($conn, $idExposicoes, $tabela)
{
  $query = "SELECT * FROM exposicoes JOIN anfitriao ON exposicoes.id_Anfitriao = anfitriao.id_Anfitriao WHERE anfitriao.id_Anfitriao =" . (int) $idExposicoes;
  $execute = mysqli_query($conn, $query);
  $exposicoes = array();
  while ($result = mysqli_fetch_assoc($execute)) {
    $exposicoes[] = $result;
  }
  return $exposicoes;
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

function deletar_exposicoes($conn, $tabela, $idExposicoes)
{
  if (!empty($idExposicoes)) {
    $query = "DELETE FROM $tabela WHERE idExposicoes =" . (int) $idExposicoes;
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
  if (!isset($_SESSION['id_Usuarios'])) {
    header("Location: login.php");
    exit;
  }

  if (isset($_POST['atualizarObra'])) {
    $Artista_id = $_SESSION['id_Usuarios'];
    $id_Obras = filter_input(INPUT_POST, "id_Obras", FILTER_VALIDATE_INT);
    $autor = mysqli_real_escape_string($conn, $_POST['autor']);
    $Descricao = mysqli_real_escape_string($conn, $_POST['Descricao']);
    $nome_obra = mysqli_real_escape_string($conn, $_POST['nome_obra']);
    $imagem = $_FILES['imagem'];
    $LongaDesc = mysqli_real_escape_string($conn, $_POST['LongaDesc']);
    $audiodescricao = $_FILES['audiodescricao'];

    if ($id_Obras === false) {
      echo "ID da obra inválido.";
      return;
    }

    if ($imagem['error'] !== UPLOAD_ERR_OK || $audiodescricao['error'] !== UPLOAD_ERR_OK) {
      echo "Erro ao enviar arquivos.";
      return;
    }

    if (empty($autor) || empty($Descricao) || empty($nome_obra) || empty($LongaDesc)) {
      echo "Por favor, preencha todos os campos.";
      return;
    }

    // Verificar comprimento máximo dos campos de texto, se aplicável
    $max_length_autor = 100; // exemplo de comprimento máximo permitido
    if (strlen($autor) > $max_length_autor) {
      echo "O campo 'Autor' excede o comprimento máximo permitido.";
      return;
    }

    // Validação de tamanho e tipo de arquivo
    $max_file_size = 80048576; // exemplo de tamanho máximo permitido (1MB)
    $allowed_image_types = array("jpeg", "jpg", "png"); // tipos de imagem permitidos
    $allowed_audio_types = array("mp3", "wav", "mp4"); // tipos de áudio permitidos

    if ($imagem['size'] > $max_file_size || !in_array(strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION)), $allowed_image_types)) {
      echo "Por favor, selecione uma imagem válida com tamanho máximo de 1MB.";
      return;
    }

    if ($audiodescricao['size'] > $max_file_size || !in_array(strtolower(pathinfo($audiodescricao['name'], PATHINFO_EXTENSION)), $allowed_audio_types)) {
      echo "Por favor, selecione um arquivo de áudio válido com tamanho máximo de 1MB.";
      return;
    }

    $imagem_extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
    $imagem_nome = uniqid() . "." . $imagem_extensao;
    $imagem_caminho = '../assets/img/';

    $audiodescricao_extensao = strtolower(pathinfo($audiodescricao['name'], PATHINFO_EXTENSION));
    $audiodescricao_nome = uniqid() . "." . $audiodescricao_extensao;
    $audiodescricao_caminho = '../assets/audio/';

    $imagem_caminho_completo = $imagem_caminho . $imagem_nome;
    $audiodescricao_caminho_completo = $audiodescricao_caminho . $audiodescricao_nome;

    move_uploaded_file($imagem['tmp_name'], $imagem_caminho . $imagem_nome);
    move_uploaded_file($audiodescricao['tmp_name'], $audiodescricao_caminho . $audiodescricao_nome);

    $dataCriacao = date('Y-m-d');

    $query = "UPDATE obras SET autor='$autor', Descricao='$Descricao', nome_obra='$nome_obra', imagem='$imagem_caminho_completo', dataCriacao='$dataCriacao', LongaDesc='$LongaDesc', audiodescricao='$audiodescricao_caminho_completo', Artista_id='$Artista_id' WHERE id_Obras='$id_Obras'";
    $resultado = mysqli_query($conn, $query);

    if ($resultado) {
      echo "Obra atualizada com sucesso!";
      header("location: inicial_artista.php");
    } else {
      echo "Erro ao atualizar obra: " . mysqli_error($conn);
    }
  }
}

function cadastrarExposicao($conn, $id_Anfitriao)
{
  if (isset($_POST['cadastrarExposicao'])) {
    $idExposicoes = rand(1, 999999);
    $Nome_expo = mysqli_real_escape_string($conn, $_POST['Nome_expo']);
    $Desc_expo = mysqli_real_escape_string($conn, $_POST['Desc_expo']);
    $Imagem = $_FILES['Imagem'];
    $DataInicial = $_POST['DataInicial'];
    $DataFinal = $_POST['DataFinal'];
    $Audio_expo = $_FILES['Audio_expo'];

    // Verificar se os arquivos foram enviados corretamente
    if ($Imagem['error'] != UPLOAD_ERR_OK || $Audio_expo['error'] != UPLOAD_ERR_OK) {
      echo "Erro ao enviar arquivos: " . $Imagem['error'] . ", " . $Audio_expo['error'];
      return;
    }

    // Validar os dados recebidos do formulário
    if (empty($Nome_expo) || empty($Desc_expo) || empty($DataInicial) || empty($DataFinal)) {
      echo "Por favor, preencha todos os campos.";
      return;
    }

    // Obter a extensão do arquivo de imagem
    $imagem_extensao = strtolower(pathinfo($Imagem['name'], PATHINFO_EXTENSION));

    // Gerar um nome único para o arquivo de imagem
    $imagem_nome = uniqid() . "." . $imagem_extensao;

    // Mover o arquivo de imagem para o diretório de uploads
    $imagem_caminho = '../assets/img/';
    move_uploaded_file($Imagem['tmp_name'], $imagem_caminho . $imagem_nome);

    // Obter a extensão do arquivo de áudio
    $audio_extensao = strtolower(pathinfo($Audio_expo['name'], PATHINFO_EXTENSION));

    // Gerar um nome único para o arquivo de áudio
    $audio_nome = uniqid() . "." . $audio_extensao;

    // Mover o arquivo de áudio para o diretório de uploads
    $audio_caminho = '../assets/audio/';
    move_uploaded_file($Audio_expo['tmp_name'], $audio_caminho . $audio_nome);

    $imagem_caminho_completo = $imagem_caminho . $imagem_nome;
    $audio_caminho_completo = $audio_caminho . $audio_nome;

    $id_Anfitriao = $_SESSION['id_Usuarios'];

    // Executar a inserção dos dados no banco de dados
    $query = "INSERT INTO exposicoes (idExposicoes, Nome_expo, Desc_expo, Imagem, DataInicial, DataFinal, Audio_expo, id_Anfitriao) VALUES ('$idExposicoes', '$Nome_expo', '$Desc_expo', '$imagem_caminho_completo', '$DataInicial', '$DataFinal', '$audio_caminho_completo', '$id_Anfitriao')";
    $resultado = mysqli_query($conn, $query);

    if ($resultado) {
      echo "Exposição cadastrada com sucesso!";
      header("location: /pages/inicial_curador.php");
    } else {
      echo "Erro ao cadastrar exposição: " . mysqli_error($conn);
    }
  }
}

function atualizarExposicao($conn)
{

  if (!isset($_SESSION['id_Usuarios'])) {
    header("Location: login.php");
    exit;
  }

  if (isset($_POST['atualizarExposicao'])) {
    $id_Anfitriao = $_SESSION['id_Usuarios'];
    $idExposicoes = filter_input(INPUT_POST, "idExposicoes", FILTER_VALIDATE_INT);
    $Nome_expo = mysqli_real_escape_string($conn, $_POST['Nome_expo']);
    $Desc_expo = mysqli_real_escape_string($conn, $_POST['Desc_expo']);
    $Imagem = $_FILES['Imagem'];
    $DataInicial = $_POST['DataInicial'];
    $DataFinal = $_POST['DataFinal'];
    $Audio_expo = $_FILES['Audio_expo'];

    if ($idExposicoes === false) {
      echo "ID da exposição inválido.";
      return;
    }

    // Verificar se os arquivos foram enviados corretamente
    if ($Imagem['error'] != UPLOAD_ERR_OK || $Audio_expo['error'] != UPLOAD_ERR_OK) {
      echo "Erro ao enviar arquivos: " . $Imagem['error'] . ", " . $Audio_expo['error'];
      return;
    }

    // Validar os dados recebidos do formulário
    if (empty($Nome_expo) || empty($Desc_expo) || empty($DataInicial) || empty($DataFinal)) {
      echo "Por favor, preencha todos os campos.";
      return;
    }

    // Validação de tamanho e tipo de arquivo
    $max_file_size = 80048576; // exemplo de tamanho máximo permitido (1MB)
    $allowed_image_types = array("jpeg", "jpg", "png"); // tipos de imagem permitidos
    $allowed_audio_types = array("mp3", "wav", "mp4"); // tipos de áudio permitidos

    if ($Imagem['size'] > $max_file_size || !in_array(strtolower(pathinfo($Imagem['name'], PATHINFO_EXTENSION)), $allowed_image_types)) {
      echo "Por favor, selecione uma imagem válida com tamanho máximo de 1MB.";
      return;
    }

    if ($Audio_expo['size'] > $max_file_size || !in_array(strtolower(pathinfo($Audio_expo['name'], PATHINFO_EXTENSION)), $allowed_audio_types)) {
      echo "Por favor, selecione um arquivo de áudio válido com tamanho máximo de 1MB.";
      return;
    }

    // Obter a extensão do arquivo de imagem
    $imagem_extensao = strtolower(pathinfo($Imagem['name'], PATHINFO_EXTENSION));

    // Gerar um nome único para o arquivo de imagem
    $imagem_nome = uniqid() . "." . $imagem_extensao;

    // Mover o arquivo de imagem para o diretório de uploads
    $imagem_caminho = '../assets/img/';
    move_uploaded_file($Imagem['tmp_name'], $imagem_caminho . $imagem_nome);

    // Obter a extensão do arquivo de áudio
    $audio_extensao = strtolower(pathinfo($Audio_expo['name'], PATHINFO_EXTENSION));

    // Gerar um nome único para o arquivo de áudio
    $audio_nome = uniqid() . "." . $audio_extensao;

    // Mover o arquivo de áudio para o diretório de uploads
    $audio_caminho = '../assets/audio/';
    move_uploaded_file($Audio_expo['tmp_name'], $audio_caminho . $audio_nome);

    $imagem_caminho_completo = $imagem_caminho . $imagem_nome;
    $audio_caminho_completo = $audio_caminho . $audio_nome;

    // Executar a atualização dos dados no banco de dados
    $query = "UPDATE exposicoes SET Nome_expo='$Nome_expo', Desc_expo='$Desc_expo', Imagem='$imagem_caminho_completo', DataInicial='$DataInicial', DataFinal='$DataFinal', Audio_expo='$audio_caminho_completo', id_Anfitriao='$id_Anfitriao' WHERE idExposicoes=$idExposicoes";
    $resultado = mysqli_query($conn, $query);

    if ($resultado) {
      echo "Exposição atualizada com sucesso!";
      header("location: inicial_curador.php");
    } else {
      echo "Erro ao atualizar exposição: " . mysqli_error($conn);
    }
  }
}

function listar_exposicao($conn, $idExposicoes, $tabela)
{
  $query = "SELECT * FROM $tabela WHERE idExposicoes = " . (int) $idExposicoes;
  $execute = mysqli_query($conn, $query);
  $exposicao = mysqli_fetch_assoc($execute);
  return $exposicao;
}

function listar_obras_exposicao($conn, $idExposicoes, $tabelaExposicoesObras)
{
  $obras = array();

  $sql = "SELECT obras.id_Obras, obras.nome_obra, obras.autor, obras.imagem FROM obras
          INNER JOIN $tabelaExposicoesObras ON obras.id_Obras = $tabelaExposicoesObras.Obras_idObras
          WHERE $tabelaExposicoesObras.Exposicoes_idExposicoes = $idExposicoes";

  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $obras[] = $row;
    }
  }

  return $obras;
}

function obra_evento($conn, $idExposicoes)
{
  if (isset($_POST['salvar'])) {
    $obrasSelecionadas = $_POST['obras'];

    // Iterar pelas obras selecionadas e inserir na tabela exposicoesobras
    foreach ($obrasSelecionadas as $obraSelecionada) {
      $idExposicoesObras = rand(1, 999999);
      $sql = "INSERT INTO exposicoesobras (idExposicoesObras, Obras_idObras, Exposicoes_idExposicoes) VALUES ($idExposicoesObras, $obraSelecionada, $idExposicoes)";
      // Execute a consulta SQL
      // Por exemplo, usando a função mysqli_query:
      mysqli_query($conn, $sql);
    }
    // Exibir uma mensagem de sucesso ou redirecionar para outra página
    // ou
    // header("Location: outra_pagina.php");
  }
}

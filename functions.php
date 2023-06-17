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
        exit(); // Termina a execução do script para evitar que o restante da página seja exibido
      } elseif ($tipo_usuario === 'anfitriao') {
        header("location: /pages/inicial_curador.php");
        exit(); // Termina a execução do script para evitar que o restante da página seja exibido
      }
    } else {
      header("location: /pages/login.php?erro=1"); // Redireciona para a página de login com o parâmetro 'erro' definido como 1
      exit(); // Termina a execução do script para evitar que o restante da página seja exibido
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

function evento_index($conn, $tabela, $where = 1, $order = "idExposicoes DESC", $limit = 1)
{
  $query = "SELECT * FROM $tabela WHERE $where ORDER BY $order LIMIT $limit";
  $execute = mysqli_query($conn, $query);
  $results = mysqli_fetch_all($execute, MYSQLI_ASSOC);
  return $results;
}

function obra_index($conn, $tabela1, $where = 1, $order = "id_Obras DESC", $limit = 3)
{
  $query = "SELECT * FROM $tabela1 WHERE $where ORDER BY $order LIMIT $limit";
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
    // Excluir as entradas relacionadas na tabela exposicoesobras
    $queryExposicoesObras = "DELETE FROM exposicoesobras WHERE Obras_idObras = ?";
    $stmtExposicoesObras = mysqli_prepare($conn, $queryExposicoesObras);
    mysqli_stmt_bind_param($stmtExposicoesObras, "i", $id_Obras);
    mysqli_stmt_execute($stmtExposicoesObras);
    mysqli_stmt_close($stmtExposicoesObras);

    // Excluir a obra na tabela obras
    $queryObras = "DELETE FROM $tabela WHERE id_Obras = ?";
    $stmtObras = mysqli_prepare($conn, $queryObras);
    mysqli_stmt_bind_param($stmtObras, "i", $id_Obras);
    mysqli_stmt_execute($stmtObras);

    if (mysqli_stmt_affected_rows($stmtObras) > 0) {
      echo "Dado deletado com sucesso!";
    } else {
      echo "Erro ao deletar dado!";
    }

    mysqli_stmt_close($stmtObras);
  }
}

function deletar_exposicoes($conn, $tabela, $idExposicoes)
{
  if (!empty($idExposicoes)) {
    // Excluir as entradas relacionadas na tabela exposicoesobras
    $queryExposicoesObras = "DELETE FROM exposicoesobras WHERE Exposicoes_idExposicoes = ?";
    $stmtExposicoesObras = mysqli_prepare($conn, $queryExposicoesObras);
    mysqli_stmt_bind_param($stmtExposicoesObras, "i", $idExposicoes);
    mysqli_stmt_execute($stmtExposicoesObras);
    mysqli_stmt_close($stmtExposicoesObras);

    // Excluir a exposição na tabela exposicoes
    $queryExposicoes = "DELETE FROM $tabela WHERE idExposicoes = ?";
    $stmtExposicoes = mysqli_prepare($conn, $queryExposicoes);
    mysqli_stmt_bind_param($stmtExposicoes, "i", $idExposicoes);
    mysqli_stmt_execute($stmtExposicoes);

    if (mysqli_stmt_affected_rows($stmtExposicoes) > 0) {
      header("Location: /pages/inicial_curador.php");
    } else {
      echo "Erro ao deletar dado!";
    }

    mysqli_stmt_close($stmtExposicoes);
  }
}

function cadastrarObra($conn)
{
  if (!isset($_SESSION['id_Usuarios'])) {
    header("Location: login.php");
    exit;
  }

  if (isset($_POST['cadastrarObra'])) {
    $Artista_id = $_SESSION['id_Usuarios'];
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

    // Obter a data atual
    $dataCriacao = date('Y-m-d');

    // Executar a inserção dos dados no banco de dados
    $query = "INSERT INTO obras (id_Obras, autor, Descricao, nome_obra, imagem, dataCriacao, LongaDesc, audiodescricao, Artista_id) VALUES ('$id_Obras', '$autor', '$Descricao', '$nome_obra', '$imagem_caminho_completo', '$dataCriacao', '$LongaDesc', '$audiodescricao_caminho_completo', '$Artista_id')";
    $resultado = mysqli_query($conn, $query);

    if ($resultado) {
      header("Location: /pages/inicial_artista.php");
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

    // Verificar comprimento máximo dos campos de texto, se aplicável
    $max_length_autor = 100; // exemplo de comprimento máximo permitido
    if (!empty($autor) && strlen($autor) > $max_length_autor) {
      echo "O campo 'Autor' excede o comprimento máximo permitido.";
      return;
    }

    // Validação de tamanho e tipo de arquivo
    $max_file_size = 80048576; // exemplo de tamanho máximo permitido (1MB)
    $allowed_image_types = array("jpeg", "jpg", "png"); // tipos de imagem permitidos
    $allowed_audio_types = array("mp3", "wav", "mp4"); // tipos de áudio permitidos

    if (!empty($imagem['tmp_name']) && ($imagem['size'] > $max_file_size || !in_array(strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION)), $allowed_image_types))) {
      echo "Por favor, selecione uma imagem válida com tamanho máximo de 1MB.";
      return;
    }

    if (!empty($audiodescricao['tmp_name']) && ($audiodescricao['size'] > $max_file_size || !in_array(strtolower(pathinfo($audiodescricao['name'], PATHINFO_EXTENSION)), $allowed_audio_types))) {
      echo "Por favor, selecione um arquivo de áudio válido com tamanho máximo de 1MB.";
      return;
    }

    // Processar a imagem, se fornecida
    $imagem_caminho_completo = '';
    if (!empty($imagem['tmp_name'])) {
      $imagem_extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
      $imagem_nome = uniqid() . "." . $imagem_extensao;
      $imagem_caminho = '../assets/img/';
      $imagem_caminho_completo = $imagem_caminho . $imagem_nome;
      move_uploaded_file($imagem['tmp_name'], $imagem_caminho . $imagem_nome);
    }

    // Processar o áudio, se fornecido
    $audiodescricao_caminho_completo = '';
    if (!empty($audiodescricao['tmp_name'])) {
      $audiodescricao_extensao = strtolower(pathinfo($audiodescricao['name'], PATHINFO_EXTENSION));
      $audiodescricao_nome = uniqid() . "." . $audiodescricao_extensao;
      $audiodescricao_caminho = '../assets/audio/';
      $audiodescricao_caminho_completo = $audiodescricao_caminho . $audiodescricao_nome;
      move_uploaded_file($audiodescricao['tmp_name'], $audiodescricao_caminho . $audiodescricao_nome);
    }

    // Executar a atualização dos dados no banco de dados
    $query = "UPDATE obras SET";

    if (!empty($autor)) {
      $query .= " autor='$autor',";
    }

    if (!empty($Descricao)) {
      $query .= " Descricao='$Descricao',";
    }

    if (!empty($nome_obra)) {
      $query .= " nome_obra='$nome_obra',";
    }

    if (!empty($imagem_caminho_completo)) {
      $query .= " imagem='$imagem_caminho_completo',";
    }

    if (!empty($LongaDesc)) {
      $query .= " LongaDesc='$LongaDesc',";
    }

    if (!empty($audiodescricao_caminho_completo)) {
      $query .= " audiodescricao='$audiodescricao_caminho_completo',";
    }

    $query .= " Artista_id='$Artista_id' WHERE id_Obras='$id_Obras'";

    $resultado = mysqli_query($conn, $query);

    if ($resultado) {
      header("Location: /pages/inicial_artista.php");
    } else {
      echo "Erro ao atualizar obra: " . mysqli_error($conn);
    }
  }
}

function cadastrarExposicao($conn)
{
  if (isset($_POST['cadastrarExposicao'])) {
    $id_Anfitriao = $_SESSION['id_Usuarios'];
    $idExposicoes = rand(1, 999999);
    $Nome_expo = mysqli_real_escape_string($conn, $_POST['Nome_expo']);
    $Desc_expo = mysqli_real_escape_string($conn, $_POST['Desc_expo']);
    $Desc_Imagem = mysqli_real_escape_string($conn, $_POST['Desc_Imagem']);
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

    // Executar a inserção dos dados no banco de dados
    $query = "INSERT INTO exposicoes (idExposicoes, Nome_expo, Desc_expo, Imagem, Desc_Imagem, DataInicial, DataFinal, Audio_expo, id_Anfitriao) VALUES ('$idExposicoes', '$Nome_expo', '$Desc_expo', '$imagem_caminho_completo', '$Desc_Imagem', '$DataInicial', '$DataFinal', '$audio_caminho_completo', '$id_Anfitriao')";
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

    // Validação de tamanho e tipo de arquivo
    $max_file_size = 80048576; // exemplo de tamanho máximo permitido (1MB)
    $allowed_image_types = array("jpeg", "jpg", "png", "webp"); // tipos de imagem permitidos
    $allowed_audio_types = array("mp3", "wav", "mp4"); // tipos de áudio permitidos

    $imagem_caminho_completo = "";
    if (!empty($Imagem['tmp_name']) && $Imagem['size'] > 0 && $Imagem['size'] <= $max_file_size && in_array(strtolower(pathinfo($Imagem['name'], PATHINFO_EXTENSION)), $allowed_image_types)) {
      // Obter a extensão do arquivo de imagem
      $imagem_extensao = strtolower(pathinfo($Imagem['name'], PATHINFO_EXTENSION));

      // Gerar um nome único para o arquivo de imagem
      $imagem_nome = uniqid() . "." . $imagem_extensao;

      // Mover o arquivo de imagem para o diretório de uploads
      $imagem_caminho = '../assets/img/';
      move_uploaded_file($Imagem['tmp_name'], $imagem_caminho . $imagem_nome);

      $imagem_caminho_completo = $imagem_caminho . $imagem_nome;
    }

    $audio_caminho_completo = "";
    if (!empty($Audio_expo['tmp_name']) && $Audio_expo['size'] > 0 && $Audio_expo['size'] <= $max_file_size && in_array(strtolower(pathinfo($Audio_expo['name'], PATHINFO_EXTENSION)), $allowed_audio_types)) {
      // Obter a extensão do arquivo de áudio
      $audio_extensao = strtolower(pathinfo($Audio_expo['name'], PATHINFO_EXTENSION));

      // Gerar um nome único para o arquivo de áudio
      $audio_nome = uniqid() . "." . $audio_extensao;

      // Mover o arquivo de áudio para o diretório de uploads
      $audio_caminho = '../assets/audio/';
      move_uploaded_file($Audio_expo['tmp_name'], $audio_caminho . $audio_nome);

      $audio_caminho_completo = $audio_caminho . $audio_nome;
    }

    // Executar a atualização dos dados no banco de dados
    $query = "UPDATE exposicoes SET";

    if (!empty($Nome_expo)) {
      $query .= " Nome_expo='$Nome_expo',";
    }

    if (!empty($Desc_expo)) {
      $query .= " Desc_expo='$Desc_expo',";
    }

    if (!empty($imagem_caminho_completo)) {
      $query .= " Imagem='$imagem_caminho_completo',";
    }

    if (!empty($_POST['Desc_Imagem'])) {
      $Desc_Imagem = mysqli_real_escape_string($conn, $_POST['Desc_Imagem']);
      $query .= " Desc_Imagem='$Desc_Imagem',";
    }

    if (!empty($DataInicial)) {
      $query .= " DataInicial='$DataInicial',";
    }

    if (!empty($DataFinal)) {
      $query .= " DataFinal='$DataFinal',";
    }

    if (!empty($audio_caminho_completo)) {
      $query .= " Audio_expo='$audio_caminho_completo',";
    }

    $query .= " id_Anfitriao='$id_Anfitriao' WHERE idExposicoes=$idExposicoes";

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

  $sql = "SELECT * FROM obras
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

function consultar_obras($conn, $id, $tabela, $tipo)
{
  $query = "SELECT * FROM $tabela WHERE ";

  if ($tipo === 'id_Obras') {
    $query .= "id_Obras = " . (int) $id;
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
  } elseif ($tipo === 'Artista_id') {
    $query .= "Artista_id = " . (int) $id;
    $result = mysqli_query($conn, $query);
    $obras = array();

    while ($row = mysqli_fetch_assoc($result)) {
      $obras[] = $row;
    }

    return $obras;
  } else {
    return null;
  }
}

function todos($conn, $tabela)
{
  $query = "SELECT * FROM $tabela";
  $execute = mysqli_query($conn, $query);

  $todos = array(); // Cria um array vazio para armazenar todos os resultados

  // Percorre o conjunto de resultados e adiciona cada linha ao array
  while ($row = mysqli_fetch_assoc($execute)) {
    $todos[] = $row;
  }

  return $todos;
}

function remover_obra_exposicao($conn, $idExposicoes, $id_Obras)
{
  if (!empty($idExposicoes) && !empty($id_Obras)) {
    $query = "DELETE FROM exposicoesobras WHERE Exposicoes_idExposicoes = ? AND Obras_idObras = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $idExposicoes, $id_Obras);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
      echo "Obra removida com sucesso da exposição!";
    } else {
      echo "Erro ao remover a obra da exposição!";
    }

    mysqli_stmt_close($stmt);
  }
}
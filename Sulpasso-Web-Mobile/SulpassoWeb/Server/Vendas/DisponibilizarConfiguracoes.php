<?php
    require_once "Modelos/Configurador.php";
    require_once "DadosConexao.php";
    require_once "Modelos/Usuario.php";
    require_once "../utf8ize.php";


  session_start(); 
  
  if(isset($_SESSION["usuario"]))
    $sessionUsr = $_SESSION["usuario"];

  $data_js;
  $data;
  $usr;
  $config;
  $empresa = $sessionUsr->getEmpresaUsuario();

  $data_js = file_get_contents('php://input');
  $data = explode("%", $data_js);

  $i = 0;
  for($i = 0; $i < count($data); $i++)
  {
    if(substr($data[$i], 0, 3) == "usr")
    {
      $ndata = explode(" - ", $data[$i]);
      $usr[] = $ndata[1];
    }
    else
    {
      if(substr($data[$i], 0, 5) == "confg")
      {
        $ndata = explode(" - ", $data[$i]);
        $config[] = $ndata[1];
      }
    }
  }

  buscarConfiguracao();

  function buscarConfiguracao()
  {
    global $empresa;
    global $usr;
    global $config;
    global $empresa;

    $configuracoes;

    $i = 0;
    for($i = 0; $i < count($usr); $i++)
    {
      $configurador = new Configurador();
      $usuario = $usr[$i];

      $d = 0;
      for($d = 0; $d < count($config); $d++)
      {
        switch ($config[$d]) 
        {
          case 0:
            $configurador->setTelas(carregarTela($empresa, $usuario));
            break;
          case 1:
            $configurador->setHorario(carregarHorario($empresa, $usuario));
            break;
          case 2:
            $configurador->setUsuario(carregarUsuario($empresa, $usuario));
            break;
          case 3:
            $configurador->setVendas(carregarVenda($empresa, $usuario));
            break;
          case 4:
            $configurador->setEmpresa(carregarEmpresa($empresa));
            break;
          case 5:
            $configurador->setConexao(carregarConexao($empresa, $usuario));
            break;
          
          default:
            # code...
            break;
        }
      }

      $configuracoes[] = $configurador;
    }


    disponibilizarConfiguracoes($configuracoes);
    }

    function carregarEmpresa($empresa)
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "select * from condifuradoreempresa where empresa = $empresa";

        $qr = $db->query($sql);
    
    $empresa = new ConfiguradorEmpresa();

        while($row = $qr->fetch_assoc()) :
      $empresa->setCodigo($row['empresa']);
      $empresa->setNome($row['fantasia']);
      $empresa->setEndereco($row['endereco']);
      $empresa->setFone($row['cidade']);
      $empresa->setCidade($row['fone']);
      $empresa->setEmail($row['email']);
      $empresa->setSite($row['site']);
      $empresa->setLogin($row['acesso']);

      return $empresa;
        endwhile;
    }

    function carregarUsuario($empresa, $usuario)
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "select config.*, user.nomeUsuario AS nome, user.senhaUsuario AS senha
        from configuradorusuario AS config JOIN usuario AS user ON user.idUsuario = config.usuario 
        and user.empresaUsuario = config.empresa
        where empresa = $empresa and (usuario = $usuario OR usuario = 0)";

        $qr = $db->query($sql);

    $usuario = new ConfiguradorUsuario();

        while($row = $qr->fetch_assoc()) :
      $usuario->setCodigo($row['usuario']);
      $usuario->setNome($row['nome']);
      $usuario->setSenha($row['senha']);
      $usuario->setTipoFlex($row['tipoFlex']);
      $usuario->setValorFlex($row['valorFlexMostrado']);
      $usuario->setPedidoMinimo($row['pedidoMinimo']);
      $usuario->setDecontoCliente($row['descontoCliente']);
      $usuario->setDescontoItem($row['descontoItem']);
      $usuario->setDescontoPedido($row['descontoPedido']);
      $usuario->setContribuicaoIdeal($row['contribuicaoIdeal']);
      $usuario->setTabelaMinimo($row['tabMinimo']);
      $usuario->setTabelaTroca($row['tabTroca']);
      $usuario->setRoteiro($row['roteiro']);
      $usuario->setTipoOrdenacao($row['ordenacao']);
      $usuario->setTipoBusca($row['busca']);
      $usuario->setSaldo($row['saldoFlex']);
      $usuario->setComissao($row['comissao']);
      $usuario->setContribuicao($row['contribuicao']);
        endwhile;

    return $usuario;      
    }

    function carregarVenda($empresa, $usuario)
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "select * from configuradorvendas where empresa = $empresa and (usuario = $usuario OR usuario = 0)";

        $qr = $db->query($sql);

        $vendas = new ConfiguradorVendas();

        while($row = $qr->fetch_assoc()) :

            $alteraNatureza = $row['alteraNatureza'];
            $alteraPrazo = $row['alteraPrazo'];
            $mostraFlex = $row['mostraFlex'];

            $alteraNaturezaInicio = 0;
            $alteraPrazoInicio = 0;
            $mostraFlexVenda = 0;
            $alteraNaturezaFim = 0;
            $alteraPrazoFim = 0;
            $mostraFlexItem = 0;

          switch ($alteraNatureza) 
          {
            case 3:
              $alteraNaturezaInicio = 1;
              $alteraNaturezaFim = 1;
              break;
            case 2:
              $alteraNaturezaInicio = 0;
              $alteraNaturezaFim = 1;
              break;
            case 1:
              $alteraNaturezaInicio = 1;
              $alteraNaturezaFim = 0;
              break;
            
            default:
              $alteraNaturezaInicio = 0;
              $alteraNaturezaFim = 0;
              break;
          }

          switch ($alteraPrazo) 
          {
            case 3:
              $alteraPrazoInicio = 1;
              $alteraPrazoFim = 1;
              break;
            case 2:
              $alteraPrazoInicio = 0;
              $alteraPrazoFim = 1;
              break;
            case 1:
              $alteraPrazoInicio = 1;
              $alteraPrazoFim = 0;
              break;
            
            default:
              $alteraPrazoInicio = 0;
              $alteraPrazoFim = 0;
              break;
          }

          switch ($mostraFlex) 
          {
            case 3:
              $mostraFlexVenda = 1;
              $mostraFlexItem = 1;
              break;
            case 2:
              $mostraFlexVenda = 0;
              $mostraFlexItem = 1;
              break;
            case 1:
              $mostraFlexVenda = 1;
              $mostraFlexItem = 0;
              break;
            
            default:
              $mostraFlexVenda = 0;
              $mostraFlexItem = 0;
              break;
          }

          $vendas->setGerenciarVisitas($row['visitas']);
          $vendas->setVenderDevedores($row['devedores']);
          $vendas->setAlteraNaturezaInicio($alteraNaturezaInicio);
          $vendas->setAlteraNaturezaFim($alteraNaturezaFim);
          $vendas->setAlteraPrazoInicio($alteraPrazoInicio);
          $vendas->setAlteraPrazoFim($alteraPrazoFim);
          $vendas->setRecalcularPrecos($row['recalculaPrecos']);
          $vendas->setAlteraPrecos($row['alteraPrecos']);
          $vendas->setLimiteCredito($row['limiteCredito']);
          $vendas->setTipoFlex($row['tipoFlex']);
          $vendas->setFlexVenda($mostraFlexVenda);
          $vendas->setFlexItem($mostraFlexItem);
          $vendas->setControlaEstoque($row['controlaEstoque']);
          $vendas->setDescontoGrupo($row['descontoGrupo']);
          $vendas->setFrete($row['frete']);
          $vendas->setSolicitaSenha($row['solicitaSenha']);
          $vendas->setEspecialAlteraValor($row['especialAlteraValor']);
          $vendas->setMinimoPrazo($row['minimoPrazo']);
          $vendas->setControlaGps($row['controlaLocalizacao']);
          $vendas->setDescontoPecentual($row['descontoPercentual']);
          $vendas->setValidade($row['validade']);
          $vendas->setItensDiferentes($row['minimoItensDiferentes']);
        endwhile;

        return $vendas;
    }

    function carregarConexao($empresa, $usuario)
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "select * from configuradorconexa where empresa = $empresa and (usuario = $usuario OR usuario = 0)";

        $qr = $db->query($sql);
    
    $conexao = new ConfiguradorConexao();

        while($row = $qr->fetch_assoc()) :
          $conexao->setServerFtp($row['servidor1']);
          $conexao->setServerFtp2($row['servidor2']);
          $conexao->setServerWeb($row['servidor3']);
          $conexao->setFtpUser($row['usuarioServidor']);
          $conexao->setFtpPswd($row['senha']);
          $conexao->setUploadFolder($row['enviar']);
          $conexao->setDownloadFolder($row['receber']);
          $conexao->setEmailSender($row['remetente']);
          $conexao->setEmailPswd($row['senhaEmail']);
          $conexao->setEmail1($row['destinatario1']);
          $conexao->setEmail2($row['destinatario2']);
          $conexao->setEmail3($row['destinatario3']);
          $conexao->setConectionType($row['conexao']);
        endwhile;


        $sql = "select * from empresa where idEmpresa = $empresa";

        $qr = $db->query($sql);

        while($row = $qr->fetch_assoc()) :
      $conexao->setEmpresaCliente($row['nomeEmpresa']);
        endwhile;

    return $conexao;
    }

    function carregarHorario($empresa, $usuario)
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "select * from configuradorhorarios where empresa = $empresa and (usuario = $usuario OR usuario = 0)";

        $qr = $db->query($sql);

    $horarios = new ConfiguradorHorarios();

        while($row = $qr->fetch_assoc()) :
      $horarios->setInicioManha($row['inicioManha']);
      $horarios->setFinalManha($row['finalManha']);
      $horarios->setInicioTarde($row['inicioTarde']);
      $horarios->setFinalTarde($row['finalTarde']);
      $horarios->setTempoPedidos($row['tempoPedidos']);
      $horarios->setTempoClientes($row['tempoClientes']);
      $horarios->setMaximoItens($row['maximoItens']);
      $horarios->setPedidos($row['seqPedidos']);
      $horarios->setClientes($row['seqClientes']);
      $horarios->setAtualizacao($row['seqAtualizacao']);
      $horarios->setDataAtualizacao($row['dataAtualizacao']);
        endwhile;

        return $horarios;
    }

    function carregarTela($empresa, $usuario)
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "select * from configuradortelas where empresa = $empresa and (usuario = $usuario OR usuario = 0)";

        $qr = $db->query($sql);

    $telas = new ConfiguradorTelas();

        while($row = $qr->fetch_assoc()) :
      $telas->setEfetuaTroca($row['trocas']);
      $telas->setVendaDireta($row['diretas']);
      $telas->setMixIdeal($row['mix']);
      $telas->setMostraMeta($row['meta']);
      $telas->setCadastroCliente($row['cadastro']);
      $telas->setTipoFoco($row['resumo']);
      $telas->setPesquisaPedidos($row['pesquisaPedidos']);
      $telas->setPesquisaItens($row['pesquisaClientes']);
      $telas->setPesquisaClientes($row['pesquisaClientes']);
      $telas->setPesquisaGeral($row['pesquisaGerencial']);
      $telas->setTelaInicial($row['telaInicial']);
        endwhile;
    
    return $telas;      
    }

    function disponibilizarConfiguracoes($configurador)
    {
      global $usr;
      $nomeEmpresa = buscarNomeEmpresa();
      /*
    echo "<br />Configuracoes <br />";
        echo json_encode(utf8ize($configurador));
        */

    $i = 0;
    for($i = 0; $i < count($usr); $i++)
    {
      $config = new Configurador();
      $vendedor = $usr[$i];
      $config = $configurador[$i];

      $starterPath = "../../../../CLIENTES";
      $midlePath = "../../../../CLIENTES/$nomeEmpresa";
      $fullPath = "../../../../CLIENTES/$nomeEmpresa/$vendedor";
      
      if(file_exists($starterPath) && is_dir($starterPath))
      {
        if(file_exists($midlePath) && is_dir($midlePath))
        {
          if(file_exists($fullPath) && is_dir($fullPath))
          {
            /*IGNORED*/
          }
          else
          {
            mkdir($fullPath, 0700);
          }
        }
        else
        {
          mkdir($midlePath, 0700);
          mkdir($fullPath, 0700);
        }
      }
      else
      {
        mkdir($starterPath, 0700);
        mkdir($midlePath, 0700);
        mkdir($fullPath, 0700);
      }
      
      criarArquivos($config, $fullPath);
    }
    }

    function criarArquivos($config, $fullPath)
    {
      $conexao = null;
      $empresa = null;
      $vendas = null;
      $usuario = null;
      $horarios = null;
      $telas = null;

      $conexao = $config->getConexao();
      $empresa = $config->getEmpresa();
      $vendas = $config->getVendas();
      $usuario = $config->getUsuario();
      $horarios = $config->getHorario();
      $telas = $config->getTelas();

    //echo json_encode($config);

      //echo "" . $config->returnJsonConfig();

      //echo "<br />" . $config->returnJsonConfig();


    try 
    { 
      $fp = fopen("$fullPath/configurador.json", "w");
      fwrite($fp, $config->returnJsonConfig());
      fclose($fp);

      echo "true";
    }
        catch (Excption $e)
    { 
      echo "false";
    } 
    }

    function buscarNomeEmpresa()
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;
        global $empresa;
        $nome = "";

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "select nomeEmpresa from empresa where idEmpresa = $empresa";

        $qr = $db->query($sql);

        while($row = $qr->fetch_assoc()) :
      $nome = $row['nomeEmpresa'];
        endwhile;
    
    return $nome;   
    }
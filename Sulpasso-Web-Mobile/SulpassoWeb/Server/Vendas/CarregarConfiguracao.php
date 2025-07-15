<?php
    require_once "Modelos/Configurador.php";
    require_once "DadosConexao.php";
    require_once "Modelos/Usuario.php";
    require_once "../utf8ize.php";

    $usr;

    session_start(); 
    
    if(isset($_SESSION["usuario"]))
    {
        $usr = $_SESSION["usuario"];
    }
    else
    {
    	echo "Efetue login para acessar essa parte do sistema!";
    	exit;
    }

	$empresa = $usr->getEmpresaUsuario();

	if(isset($_GET["usuario"])){
		$internal_usuario = $_GET["usuario"];
		if($internal_usuario == 999){
		$internal_usuario = $usr->getIdUsuario();
		}
	}
	else
		$internal_usuario = 0;

	if(isset($_GET["configuracao"]))
		switch ($_GET["configuracao"]) 
		{
			case 0:
				echo json_encode(utf8ize(carregarConexao($empresa, $internal_usuario)));
				break;
			case 1:
				echo json_encode(utf8ize(carregarEmpresa($empresa)));
				break;
			case 2:
				echo json_encode(utf8ize(carregarHorario($empresa, $internal_usuario)));
				break;
			case 3:
				echo json_encode(utf8ize(carregarTela($empresa, $internal_usuario)));
				break;
			case 4:
				echo json_encode(utf8ize(carregarUsuario($empresa, $internal_usuario)));
				break;
			case 5:
				echo json_encode(utf8ize(carregarVenda($empresa, $internal_usuario)));
				break;
			case 6:
				echo json_encode(carregarDadosLogin($empresa, $internal_usuario));
			break;
			default:
				echo json_encode(utf8ize(carregarVenda($empresa, $internal_usuario)));
				break;
		}
	else
		buscarConfiguracao();


	function buscarConfiguracao()
	{
		global $empresa;
		global $internal_usuario;

		$configurador = new Configurador();

		$configurador->setConexao(carregarConexao($empresa, $internal_usuario));
		$configurador->setEmpresa(carregarEmpresa($empresa));
		$configurador->setHorario(carregarHorario($empresa, $internal_usuario));
		$configurador->setTelas(carregarTela($empresa, $internal_usuario));
		$configurador->setUsuario(carregarUsuario($empresa, $internal_usuario));
		$configurador->setVendas(carregarVenda($empresa, $internal_usuario));

        echo json_encode(utf8ize($configurador));
    }
	//MAGICA!
	function carregarDadosLogin($empresa, $internal_usuario){
		global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "select idUsuario,nomeCompletoUsuario,nomeUsuario,senhaUsuario from usuario where empresaUsuario = $empresa and idUsuario = $internal_usuario";

        $qr = $db->query($sql);

		$result = array();
        while($row = $qr->fetch_assoc()) :
			$result[0] = ($row['idUsuario']);
			$result[1] = ($row['nomeCompletoUsuario']);
			$result[2] = ($row['nomeUsuario']);
			$result[3] = ($row['senhaUsuario']);
        endwhile;

		return $result;  
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
            $empresa->setFone($row['fone']);
            $empresa->setCidade($row['cidade']);
            $empresa->setEmail($row['email']);
            $empresa->setSite($row['site']);
            $empresa->setLogin($row['acesso']);

            return $empresa;
        endwhile;
    }

    function carregarUsuario($empresa, $internal_usuario)
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "select * from configuradorusuario where empresa = $empresa and (usuario = $internal_usuario OR usuario = 0)";

        $qr = $db->query($sql);

		$internal_usuario = new ConfiguradorUsuario();

        while($row = $qr->fetch_assoc()) :
			$internal_usuario->setCodigo(1);
			$internal_usuario->setNome("nome");
			$internal_usuario->setSenha("senha");
			$internal_usuario->setTipoFlex($row['tipoFlex']);
			$internal_usuario->setValorFlex($row['valorFlexMostrado']);
			$internal_usuario->setPedidoMinimo($row['pedidoMinimo']);
			$internal_usuario->setDecontoCliente(10);
			$internal_usuario->setDescontoItem($row['descontoItem']);
			$internal_usuario->setDescontoPedido($row['descontoPedido']);
			$internal_usuario->setContribuicaoIdeal($row['contribuicaoIdeal']);
			$internal_usuario->setTabelaMinimo($row['tabMinimo']);
			$internal_usuario->setTabelaTroca($row['tabTroca']);
			$internal_usuario->setRoteiro($row['roteiro']);
			$internal_usuario->setTipoOrdenacao($row['ordenacao']);
			$internal_usuario->setTipoBusca($row['busca']);
			$internal_usuario->setSaldo($row['saldoFlex']);
			$internal_usuario->setComissao($row['comissao']);
			$internal_usuario->setContribuicao($row['contribuicao']);
        endwhile;

		return $internal_usuario;    	
    }

    function carregarVenda($empresa, $internal_usuario)
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "select * from configuradorvendas where empresa = $empresa and (usuario = $internal_usuario OR usuario = 0)";

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

    function carregarConexao($empresa, $internal_usuario)
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "select * from configuradorconexa where empresa = $empresa and (usuario = $internal_usuario OR usuario = 0)";

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

		return $conexao;
    }

    function carregarHorario($empresa, $internal_usuario)
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "select * from configuradorhorarios where empresa = $empresa and (usuario = $internal_usuario OR usuario = 0)";

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

    function carregarTela($empresa, $internal_usuario)
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $sql = "SELECT * FROM configuradortelas WHERE empresa = $empresa AND (usuario = $internal_usuario OR usuario = 0) ORDER BY usuario DESC limit 1";

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
			$telas->setPesquisaItens($row['pesquisaItens']);
			$telas->setPesquisaClientes($row['pesquisaClientes']);
			$telas->setPesquisaGeral($row['pesquisaGerencial']);
			$telas->setTelaInicial($row['telaInicial']);
        endwhile;
		
		return $telas;    	
    }
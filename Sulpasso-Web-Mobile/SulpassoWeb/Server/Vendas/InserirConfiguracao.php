<?php

    header('Content-Type: application/json');
    require_once "Modelos/Configurador.php";
    require_once "Modelos/Usuario.php";
    require_once "DadosConexao.php";
    require_once "../utf8ize.php";


	$str_json = file_get_contents('php://input');

	$str_json_decoded = json_decode($str_json, true);

    $usuario_a_configurar = 0;

    if($_GET['usuario_a_configurar'])
    {
        $usuario_a_configurar = $_GET['usuario_a_configurar'];
    }
    else
    {
        $usuario_a_configurar = 0;
    }


	if($_GET['action'] == 'conexao')
	{
		salvarConexao();
	}
	else if($_GET['action'] == 'empresa')
	{
		salvarEmpresa();
	}
	else if($_GET['action'] == 'usuario')
	{
		salvarUsuario();
	}
	else if($_GET['action'] == 'horario')
	{
		salvarHorarios();
	}
	else if($_GET['action'] == 'vendas')
	{
		salvarVendas();
	}
	else if($_GET['action'] == 'telas')
	{
		salvarTelas();
	}
    else if($_GET['action'] == 'dadosLogin')
	{
		salvarDadosLogin();
	}


	function salvarConexao()
	{
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;    
        global $str_json_decoded;
        global $usuario_a_configurar;

        session_start(); 
        
        if(isset($_SESSION["usuario"]))
        {
            $usuario = $_SESSION["usuario"];
            $cod_user = $_SESSION["cod_user"];
            $emp_user = $_SESSION["emp_user"];
        }

        try
        {
            $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);
    		
            $sql = "REPLACE INTO `configuradorconexa`(`usuario`, `empresa`, `servidor1`, `servidor2`, `servidor3`, `usuarioServidor`, `senha`, `enviar`, `receber`, `remetente`, `senhaEmail`, `destinatario1`, `destinatario2`, `destinatario3`, `conexao`) VALUES ('$usuario_a_configurar', '" . $emp_user . "', '" . $str_json_decoded['serverFtp'] . "', '" . $str_json_decoded['serverFtp2'] . "', '" . $str_json_decoded['serverWeb'] . "', '" . $str_json_decoded['ftpUser'] . "', '" . $str_json_decoded['ftpPswd'] . "', '" . $str_json_decoded['uploadFolder'] . "', '" . $str_json_decoded['downloadFolder'] . "', '" . $str_json_decoded['emailSender'] . "', '" . $str_json_decoded['emailPswd'] . "', '" . $str_json_decoded['email1'] . "', '" . $str_json_decoded['email2'] . "', '" . $str_json_decoded['email3'] . "', '" . $str_json_decoded['conectionType'] . "');";

            $qr = $db->query($sql);

        	echo "true";
        }
        catch(Exeption $e)
        {
            echo "Erro ao inserir o objeto no banco: , $e->getMessage(), \n";
            exit;
        }
	}

	function salvarUsuario()
	{
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;    
        global $str_json_decoded;
        global $usuario_a_configurar;

        session_start(); 
        
        if(isset($_SESSION["usuario"]))
        {
            $usuario = $_SESSION["usuario"];
            $cod_user = $_SESSION["cod_user"];
            $emp_user = $_SESSION["emp_user"];
        }

        try
        {
            $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);
    		
            $sql = "REPLACE INTO `configuradorusuario`(`usuario`, `empresa`, `tipoFlex`, `valorFlexMostrado`, `pedidoMinimo`, `descontoItem`, `descontoPedido`, `contribuicaoIdeal`, `tabMinimo`, `tabTroca`, `roteiro`, `ordenacao`, `busca`, `saldoFlex`, `comissao`, `contribuicao`) VALUES ('$usuario_a_configurar', '" . $emp_user . "', '" . $str_json_decoded['tipoFlex'] . "', '" . $str_json_decoded['valorFlex'] . "', '" . $str_json_decoded['pedidoMinimo'] . "', '" . $str_json_decoded['descontoItem'] . "', '" . $str_json_decoded['descontoPedido'] . "', '" . $str_json_decoded['contribuicaoIdeal'] . "', '" . $str_json_decoded['tabelaMinimo'] . "', '" . $str_json_decoded['tabelaTroca'] . "', '" . $str_json_decoded['roteiro'] . "', '" . $str_json_decoded['tipoOredenacao'] . "', '" . $str_json_decoded['tipoBusca'] . "', '" . $str_json_decoded['saldo'] . "', '" . $str_json_decoded['comissao'] . "', '" . $str_json_decoded['contribuicao'] . "');";

            $qr = $db->query($sql);

        	echo "true";
        }
        catch(Exeption $e)
        {
            echo "Erro ao inserir o objeto no banco: , $e->getMessage(), \n";
            exit;
        }
	}
    //MAGICA
    function salvarDadosLogin()
	{
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;    
        global $str_json_decoded;
        global $usuario_a_configurar;

        $login = $str_json_decoded['aliasUsuario'];
        $nome = $str_json_decoded['nomeUsuario'];
        $senha = $str_json_decoded['senhaUsuario'];

        session_start(); 
        
        if(isset($_SESSION["usuario"]))
        {
            $usuario = $_SESSION["usuario"];
            $cod_user = $_SESSION["cod_user"];
            $emp_user = $_SESSION["emp_user"];
        }

        try
        {
            $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);
            $sql = "UPDATE usuario SET nomeUsuario = '$login', nomeCompletoUsuario = '$nome',senhaUsuario = '$senha' WHERE idUsuario = $usuario_a_configurar and empresaUsuario = $emp_user;";

            $qr = $db->query($sql);

        	echo "true";
        }
        catch(Exeption $e)
        {
            echo "Erro ao inserir o objeto no banco: , $e->getMessage(), \n";
            exit;
        }
	}

	function salvarTelas()
	{
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;    
        global $str_json_decoded;
        global $usuario_a_configurar;

        session_start(); 
        
        if(isset($_SESSION["usuario"]))
        {
            $usuario = $_SESSION["usuario"];
            $cod_user = $_SESSION["cod_user"];
            $emp_user = $_SESSION["emp_user"];
        }

        try
        {
            $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);
    		
            $sql = "REPLACE INTO `configuradortelas`(`usuario`, `empresa`, `trocas`, `diretas`, `mix`, `meta`, `cadastro`, `resumo`, `pesquisaPedidos`, `pesquisaItens`, `pesquisaClientes`, `pesquisaGerencial`, `telaInicial`) VALUES ('$usuario_a_configurar', '$emp_user', '" . $str_json_decoded['efetuaTroca'] . "', '" . $str_json_decoded['vendasDireta'] . "', '" . $str_json_decoded['mixIdeal'] . "', '" . $str_json_decoded['mostraMeta'] . "', '" . $str_json_decoded['cadastroCliente'] . "', '" . $str_json_decoded['tipoFoco'] . "', '" . $str_json_decoded['pesquisaPedidos'] . "', '" . $str_json_decoded['pesquisaItens'] . "', '" . $str_json_decoded['pesquisaClientes'] . "', '" . $str_json_decoded['pesquisaGeral'] . "', '" . $str_json_decoded['telaInicial'] . "');";

            $qr = $db->query($sql);

        	echo "true";
        }
        catch(Exeption $e)
        {
            echo "Erro ao inserir o objeto no banco: , $e->getMessage(), \n";
            exit;
        }
	}

	function salvarVendas()
	{
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;    
        global $str_json_decoded;
        global $usuario_a_configurar;

        session_start(); 
        
        if(isset($_SESSION["usuario"]))
        {
            $usuario = $_SESSION["usuario"];
            $cod_user = $_SESSION["cod_user"];
            $emp_user = $_SESSION["emp_user"];
        }

        $alteraNatureza = 0;
        $alteraPrazo = 0;
        $mostraFlex = 0;

        if($str_json_decoded['alteraNaturezaInicio'] == 1)
        {
        	if($str_json_decoded['alteraNaturezaFim'] == 1) { $alteraNatureza = 3; }
			else { $alteraNatureza = 1; }
        }
        else if($str_json_decoded['alteraNaturezaFim'] == 1) { $alteraNatureza = 2; }
    	else { $alteraNatureza = 0; }

        if($str_json_decoded['alteraPrazoInicio'] == 1)
        {
        	if($str_json_decoded['alteraPrazoFim'] == 1) { $alteraPrazo = 3; }
			else { $alteraPrazo = 1; }
        }
        else if($str_json_decoded['alteraPrazoFim'] == 1) { $alteraPrazo = 2; }
    	else { $alteraPrazo = 0; }

        if($str_json_decoded['flexVenda'] == 1)
        {
        	if($str_json_decoded['flexItem'] == 1) { $mostraFlex = 3; }
			else { $mostraFlex = 1; }
        }
        else if($str_json_decoded['flexItem'] == 1) { $mostraFlex = 2; }
    	else { $mostraFlex = 0; }

        try
        {
            $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);
    		
            $sql = "REPLACE INTO `configuradorvendas`(`usuario`, `empresa`, `visitas`, `devedores`, `alteraNatureza`, `alteraPrazo`, `recalculaPrecos`, `alteraPrecos`, `limiteCredito`, `tipoFlex`, `mostraFlex`, `controlaEstoque`, `descontoGrupo`, `frete`, `solicitaSenha`, `especialAlteraValor`, `minimoPrazo`, `controlaLocalizacao`, `descontoPercentual`, `validade`, `minimoItensDiferentes`) VALUES ('$usuario_a_configurar', '" . $emp_user . "', '" . $str_json_decoded['gerenciarVisitas'] . "', '" . $str_json_decoded['venderDevedores'] . "', '" . $alteraNatureza . "', '" . $alteraPrazo . "', '" . $str_json_decoded['recalcularPreco'] . "', '" . $str_json_decoded['alteraPrecos'] . "', '" . $str_json_decoded['limiteCredito'] . "', '" . $str_json_decoded['tipoFlex'] . "', '" . $mostraFlex . "', '" . $str_json_decoded['controlaEstoque'] . "', '" . $str_json_decoded['descontoGrupo'] . "', '" . $str_json_decoded['frete'] . "', '" . $str_json_decoded['solicitaSenha'] . "', '" . $str_json_decoded['especialAlteraValor'] . "', '" . $str_json_decoded['minimoPrazo'] . "', '" . $str_json_decoded['controlaGps'] . "', '" . $str_json_decoded['descontoPecentual'] . "', '" . $str_json_decoded['validade'] . "', '" . $str_json_decoded['itensDiferentes'] . "');";

            $qr = $db->query($sql);

        	echo "true";
        	exit;
        }
        catch(Exeption $e)
        {
            echo "Erro ao inserir o objeto no banco: , $e->getMessage(), \n";
            exit;
        }
	}

	function salvarHorarios()
	{
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;    
        global $str_json_decoded;
        global $usuario_a_configurar;

        session_start(); 
        
        if(isset($_SESSION["usuario"]))
        {
            $usuario = $_SESSION["usuario"];
            $cod_user = $_SESSION["cod_user"];
            $emp_user = $_SESSION["emp_user"];
        }

        try
        {
            $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);
    		
            $sql = "REPLACE INTO `configuradorhorarios`(`usuario`, `empresa`, `inicioManha`, `finalManha`, `inicioTarde`, `finalTarde`, `tempoPedidos`, `tempoClientes`, `maximoItens`, `seqPedidos`, `seqClientes`, `seqAtualizacao`, `dataAtualizacao`) VALUES ('$usuario_a_configurar', '" . $emp_user . "', '" . $str_json_decoded['inicioManha'] . "', '" . $str_json_decoded['finalManha'] . "', '" . $str_json_decoded['inicioTarde'] . "', '" . $str_json_decoded['finalTarde'] . "', '" . $str_json_decoded['tempoPedidos'] . "', '" . $str_json_decoded['tempoClientes'] . "', '" . $str_json_decoded['maximoItens'] . /*"', '" . $str_json_decoded['horaSistema'] . */"', '" . $str_json_decoded['pedidos'] . "', '" . $str_json_decoded['clientes'] . "', '" . $str_json_decoded['atualizacao'] . "', '" . $str_json_decoded['dataAtualizacao'] . "');";

            $qr = $db->query($sql);

        	echo "true";
        }
        catch(Exeption $e)
        {
            echo "Erro ao inserir o objeto no banco: , $e->getMessage(), \n";
            exit;
        }
	}

	function salvarEmpresa()
	{
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;    
        global $str_json_decoded;
        global $usuario_a_configurar;

        session_start(); 
        
        if(isset($_SESSION["usuario"]))
        {
            $usuario = $_SESSION["usuario"];
            $cod_user = $_SESSION["cod_user"];
            $emp_user = $_SESSION["emp_user"];
        }

        try
        {
            $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);
            
            $sql = "REPLACE INTO condifuradoreempresa (empresa, fantasia, endereco, cidade, fone, email, site, acesso) VALUES ('" . $emp_user . "', '" . $str_json_decoded['nome'] . "', '" . $str_json_decoded['endereco'] . "', '" . $str_json_decoded['cidade'] . "', '" . $str_json_decoded['fone'] . "', '" . $str_json_decoded['email'] . "', '" . $str_json_decoded['site'] . "', '" . $str_json_decoded['login'] . "');";

            $qr = $db->query($sql);

        	echo "true";
        }
        catch(Exeption $e)
        {
            echo "Erro ao inserir o objeto no banco: , $e->getMessage(), \n";
            exit;
        }
	}


 /*       
 $sql = "insert into usuario (nomeUsuario, empresaUsuario, senhaUsuario, nomeCompletoUsuario) values ('" . $str_json_decoded['aliasUsuario'] . "', '" . $usuario->getEmpresaUsuario() . "', '" . $str_json_decoded['senhaUsuario'] . "', '" . $str_json_decoded['nomeUsuario'] . "');";
 

 		
$sql = "REPLACE INTO `configuradorvendas`(`usuario`, `empresa`, `visitas`, `devedores`, `alteraNatureza`, `alteraPrazo`, `recalculaPrecos`, `alteraPrecos`, `limiteCredito`, `tipoFlex`, `mostraFlex`, `controlaEstoque`, `descontoGrupo`, `frete`, `solicitaSenha`, `especialAlteraValor`, `minimoPrazo`, `controlaLocalizacao`, `descontoPercentual`, `validade`) VALUES ('0', '" . $usuario->getEmpresaUsuario() . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "', '" . $str_json_decoded[''] . "');";
 */
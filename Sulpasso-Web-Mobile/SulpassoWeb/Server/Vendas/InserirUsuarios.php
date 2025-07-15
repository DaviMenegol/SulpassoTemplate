<?php
    header('Content-type: application/json');
    
    require_once "Modelos/Usuario.php";
    require_once "DadosConexao.php";
    require_once "../utf8ize.php";


	$obj_usuario; 
	    
	inserirUsuario();
	  
    function inserirUsuario()
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;    

		$str_json = file_get_contents('php://input');

		$str_json_decoded = json_decode($str_json, true);

        session_start(); 
        
        if(isset($_SESSION["usuario"]))
            $usuario = $_SESSION["usuario"];

        try
        {
            $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);
        
    		$sql = "insert into usuario (idUsuario, nomeUsuario, empresaUsuario, senhaUsuario, nomeCompletoUsuario, tipoUsuario) values ('" . $str_json_decoded['codigoUsuario'] . "', '" . $str_json_decoded['aliasUsuario'] . "', '" . $usuario->getEmpresaUsuario() . "', '" . $str_json_decoded['senhaUsuario'] . "', '" . $str_json_decoded['nomeUsuario'] . "', '" . $str_json_decoded['tipoUsuario'] . "');";

            $qr = $db->query($sql);
        }
        catch(Exeption $e)
        {
            echo "Erro ao inserir o objeto no banco: , $e->getMessage(), \n";
            exit;
        }
        echo "true";
    }
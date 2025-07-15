<?php
    require_once "Modelos/Usuario.php";
    require_once "DadosConexao.php";
    require_once "../utf8ize.php";

    $user;
    $password;
    $cliente;

    if(isset($_POST['user']))
    {
        $user = $_POST['user'];
        if(isset($_POST['pswd']))
        {
            $password = $_POST['pswd'];
	        if(isset($_POST['empresa']))
	        {
	            $cliente = $_POST['empresa'];
	            verificaUsuario();
	        }
        	else { dadosInvalidos("empresa não indicada para o usuario $user com senha $password"); }
        }
        else { dadosInvalidos("senha não indicada para o usuario $user"); }
    }
    else { dadosInvalidos("usuario não idicado"); }

    function verificaUsuario()
    {
        global $user;
        global $password;
        global $cliente;

        if(empty($user)){ dadosInvalidos(); }
        else
        {
            if(empty($password)){ dadosInvalidos(); }
            else
            {
	            if(empty($cliente)){ dadosInvalidos(); }
	            else
	            {
	                // $user = (!get_magic_quotes_gpc()) ? addslashes($user) :  $user;
	                // $password = (!get_magic_quotes_gpc()) ? addslashes($password) :  $password;
	                acessaBanco();
	            }
            }
        }
    }

    function acessaBanco()
    {
        global $user;
        global $password;
        global $cliente;

        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        if(is_numeric($user))
        {
            $sql = "select idUsuario, nomeUsuario, empresaUsuario from usuario where idUsuario = $user and senhaUsuario like('$password') and empresaUsuario = $cliente;";
            $sql_count = "select count(*) from usuario where idUsuario = $user and senhaUsuario like('$password') and empresaUsuario = $cliente;";
        } 
        else
        {
            $sql = "select idUsuario, nomeUsuario, empresaUsuario from usuario where nomeUsuario like('$user') and senhaUsuario like('$password') and empresaUsuario = $cliente;";
            $sql_count = "select count(*) from usuario where nomeUsuario like('$user') and senhaUsuario like('$password') and empresaUsuario = $cliente;";
        }

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        if(contarRegistros($db, $sql_count)) :
            $qr = $db->query($sql);
            while($row = $qr->fetch_assoc()) :
                $usuario = new Usuario();
                $usuario ->setIdUsuario($row['idUsuario']);
                $usuario ->setNomeUsuario($row['nomeUsuario']);
                $usuario ->setEmpresaUsuario($row['empresaUsuario']);

    			session_start();
	    		$_SESSION["usuario"] = $usuario;
                $_SESSION["cod_user"] = $usuario->getIdUsuario();
                $_SESSION["emp_user"] = $usuario->getEmpresaUsuario();
                echo "true";
                exit;
            endwhile;
        else :
            dadosInvalidos("Dados incorretos");
            exit;
        endif;
    }

    function contarRegistros($db, $sql_count)
    {
        $qr_count = $db->query($sql_count);

        while($row_count = $qr_count->fetch_assoc()):
            if($row_count['count(*)'] == 1) { return true; }

        endwhile;
    }

    function dadosInvalidos($retorno)
    {
        echo "$retorno";
        exit;
    }
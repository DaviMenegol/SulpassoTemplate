<?php
    require_once "Modelos/Usuario.php";
    require_once "DadosConexao.php";
    require_once "../utf8ize.php";

  if($_GET['action'] == 'codigo')
  {
    echo buscarCodigo();
  }
  else if($_GET['action'] == 'empresa')
  {
    buscarUsuario();
  }

  else if($_GET['action'] == 'funcionarios')
  {
    buscarFuncionarios();
  }

  function buscarCodigo()
  {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $sql = "select max(idUsuario) from usuario";

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $qr = $db->query($sql);
        while($row = $qr->fetch_assoc()) :
            echo  $row['max(idUsuario)'];
            exit;
        endwhile;
        exit;
    }

    function buscarUsuario()
    {
        session_start(); 
        
        if(isset($_SESSION["usuario"]))
        {
            $usuario = $_SESSION["usuario"];
            $cod_user = $_SESSION["cod_user"];
            $emp_user = $_SESSION["emp_user"];
        }

        unset($_SESSION["usuario"]);

        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $sql = "select idUsuario, nomeUsuario from usuario where empresaUsuario = " . $emp_user . " and tipoUsuario <> 0 order by nomeUsuario desc";

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $qr = $db->query($sql);

        $listaUsuarios = array();

        $_SESSION["usuario"] = $usuario;

        while($row = $qr->fetch_assoc()) :
            $usr = new Usuario();

            $usr ->setIdUsuario($row['idUsuario']);
            $usr ->setNomeUsuario($row['nomeUsuario']);
            $usr ->setEmpresaUsuario($usuario->getEmpresaUsuario());

            $listaUsuarios[] = $usr;
        endwhile;

        echo json_encode(utf8ize($listaUsuarios));
        exit;
    }

    function buscarFuncionarios()
    {
        session_start(); 
        
        if(isset($_SESSION["usuario"]))
        {
            $usuario = $_SESSION["usuario"];
            $cod_user = $_SESSION["cod_user"];
            $emp_user = $_SESSION["emp_user"];
        }

        unset($_SESSION["usuario"]);

        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;

        $sql = "select idUsuario, nomeUsuario from usuario where empresaUsuario = " . $emp_user . " order by nomeUsuario desc";

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);

        $qr = $db->query($sql);

        $listaUsuarios = array();

        $_SESSION["usuario"] = $usuario;

        while($row = $qr->fetch_assoc()) :
            $usr = new Usuario();

            $usr ->setIdUsuario($row['idUsuario']);
            $usr ->setNomeUsuario($row['nomeUsuario']);
            $usr ->setEmpresaUsuario($usuario->getEmpresaUsuario());

            $listaUsuarios[] = $usr;
        endwhile;

        echo json_encode(utf8ize($listaUsuarios));
        exit;
    }
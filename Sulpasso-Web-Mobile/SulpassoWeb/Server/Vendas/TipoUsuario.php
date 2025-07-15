<?php
    
    require_once "Modelos/Usuario.php";
    require_once "DadosConexao.php";
    require_once "../utf8ize.php";

    
    session_start(); 
    
    if(isset($_SESSION["usuario"]))
    {
        $usuario = $_SESSION["usuario"];
        $empresa = $usuario->getEmpresaUsuario();

            try
            {
                $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);
            
                $sql = "select tipoUsuario from usuario where idUsuario = '" . $usuario->getIdUsuario() . "'and empresaUsuario = $empresa;";

                $qr = $db->query($sql);

                $tipoUsr = -1;

                while($row = $qr->fetch_assoc()) :
                
                    $tipoUsr = $row['tipoUsuario'];

                endwhile;
                
            }
            catch(Exception $e)
            {
                header("Location: Logout.php");
                exit;
            }


            if($tipoUsr == 0)
            {
                header("location: ../../../SulpassoWeb/Vendas/Administradores.html");
                exit;
            }
            header("Location: Logout.php");
            exit;
    }
    else
    {
        header("Location: Logout.php");
    }
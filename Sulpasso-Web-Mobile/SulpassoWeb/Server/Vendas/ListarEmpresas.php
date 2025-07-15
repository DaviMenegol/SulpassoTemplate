<?php
    require_once "Modelos/Empresa.php";
    require_once "DadosConexao.php";
    require_once "../utf8ize.php";

    buscarTodos();

    function buscarTodos()
    {
        global $dbServer;
        global $dbUser;
        global $dbPassword;
        global $dbDatabase;    

        $sql = "select * from empresa order by idEmpresa desc";

        $db = new mysqli( $dbServer, $dbUser, $dbPassword, $dbDatabase);
        $qr = $db->query($sql);

        $listaEmpresa = array();
        
        while($row = $qr->fetch_assoc()) :
        
            $empresa = new Empresa();

            $empresa ->setIdEmpresa($row['idEmpresa']);
            $empresa ->setNomeEmpresa($row['nomeEmpresa']);

            $listaEmpresa[] = $empresa;

        endwhile;
        
        echo json_encode(utf8ize($listaEmpresa));
        
        exit;
    }
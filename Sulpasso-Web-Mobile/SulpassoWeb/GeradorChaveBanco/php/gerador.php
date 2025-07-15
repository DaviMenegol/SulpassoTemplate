<?php 
    include ("../../Server/Vendas/DadosConexao.php");
    include ("modelo/objRetorno.php");

    $chave = $_POST['chave1'];
    $idEmpresa = $_POST['idEmpresa'];
    $idSupervisor = $_POST['idSupervisor'];
    $vendedor = $_POST['vendedores'];
    $modo = $_POST['modo'];

    if(!isset($_POST['chave1'])){
        echo json_encode(array('error' => 'Erro em parametros! Contate o suporte Sulpasso'));
        exit;
    }

    session_start();
    if(!isset($_SESSION["usuario"]))
    {
        echo json_encode(["error" => "O usuário não esta logado!"]);
        exit;
    }
    global $connection;

    if($modo == "true"){
        $sql = "select calculaChave('$chave',$idSupervisor,$idEmpresa,$vendedor) as resultado";
    }else{
        $sql = "select calculaConfigurador('$chave',$idSupervisor,$idEmpresa,$vendedor) as resultado";
    }
    
    $result = $connection->query($sql);
    $connection->store_result();

    $obj = new objRetorno();

 
    if ($result->num_rows > 0) {
        // Recuperar o resultado
        $row = $result->fetch_assoc();
        $resultado = $row["resultado"];
    
        // Processar o resultado


        // $valores = explode(',', $resultado);
        // $obj->setvalor($valores[0]);
        // $obj->setqtd($valores[1]);
        // $obj->setchaveResult($valores[2]);

        echo json_encode($resultado);
        exit;
    }else{
        echo json_encode(array("error" => "Erro no gerador! Contate o suporte Sulpasso"));
        exit;
    }

?>

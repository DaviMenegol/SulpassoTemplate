<?php 
include("../../Server/Vendas/DadosConexao.php");

$idEmpresa = $_POST['idEmpresa'];
$idSupervisor = $_POST['idSupervisor'];

 $date = date("Y-m-d");
//busca no banco requisições de hoje
 $sql = "SELECT chave_recebida,vendedor,quantidade,valor,chave_resultante,data_hora
         FROM requisicoeschave 
         where id_empresa = $idEmpresa and id_supervisor = $idSupervisor and data_hora between '$date 00:00:00' and '$date 23:59:59';";

 global $connection;
 $qr = $connection->query($sql);

 $listaRequisicoes = array();

 // Verifica se há resultados na consulta
 if ($qr->num_rows > 0) {
     while ($row = $qr->fetch_assoc()) {
         $listaRequisicoes[] = $row;
     }
     // Retorna os dados como JSON
     echo json_encode($listaRequisicoes);
     exit;
 } else {
     // Se não houver resultados, retorna uma mensagem de erro
     echo json_encode(array('error' => 'Nenhuma requisicao hoje!'));
     exit;
 }

?>
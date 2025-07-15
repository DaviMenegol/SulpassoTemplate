<?php
    include("../../Server/Vendas/DadosConexao.php");

    buscarTodos();

    function buscarTodos()
    {
        
        // Verifica se o parâmetro idEmpresa foi enviado via POST
        if(isset($_POST['idEmpresa'])) {
            $idEmpresa = $_POST['idEmpresa'];

            global $connection;

            $sql = "select idUsuario,nomeUsuario from webmobile.usuario WHERE empresaUsuario =  $idEmpresa and tipoUsuario = 1 order by idUsuario desc";

            $qr = $connection->query($sql);

            $listaVendedores = array();

            // Verifica se há resultados na consulta
            if ($qr->num_rows > 0) {
                while ($row = $qr->fetch_assoc()) {
                    $listaVendedores[] = $row;
                }
                // Retorna os dados como JSON
                echo json_encode($listaVendedores);
                exit;
            } else {
                // Se não houver resultados, retorna uma mensagem de erro
                echo json_encode(array('error' => 'Nenhum vendedor encontrado para esta empresa'));
                exit;
            }

            exit; // Termina a execução do script após enviar a resposta
        } else {
            // Se idEmpresa não foi enviado, retorna uma mensagem de erro
            echo json_encode(array('error' => 'Parâmetro idEmpresa não foi enviado'));
            exit;
        }
    }
?>
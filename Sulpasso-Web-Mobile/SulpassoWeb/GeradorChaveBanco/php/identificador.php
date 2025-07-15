<?php 
session_start(); 
        
if(isset($_SESSION["emp_user"]) && isset($_SESSION["cod_user"]))
{
    $emp_user = $_SESSION["emp_user"];
    $cod_user = $_SESSION["cod_user"];

    echo json_encode(["emp_user" => $emp_user , "cod_user" => $cod_user]);
    exit;
}
else{
    echo json_encode(["error" => "O usuário não esta logado!"]);
    exit;
}

?>
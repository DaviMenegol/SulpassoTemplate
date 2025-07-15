<?php
    require_once "Modelos/Usuario.php";
	session_start(); 
	
	if(isset($_SESSION["usuario"]))
		$usuario = $_SESSION["usuario"];

	if(!empty($usuario))
	{
		echo "TRUE";
		exit;
	}
	else
	{
		echo "FALSE";
		exit;
	}

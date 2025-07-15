<?php
 
class Usuario 
{
    public $idUsuario;
    public $nomeUsuario;
    public $empresaUsuario;
            
    public function __construct(){}

    public function setIdUsuario ($valor){$this->idUsuario = $valor;}
    public function getIdUsuario (){return $this->idUsuario;}

    public function setNomeUsuario ($valor){$this->nomeUsuario = $valor;}
    public function getNomeUsuario(){return $this->nomeUsuario;}        

    public function setEmpresaUsuario ($valor){$this->empresaUsuario = $valor;}
    public function getEmpresaUsuario(){return $this->empresaUsuario;}        
}
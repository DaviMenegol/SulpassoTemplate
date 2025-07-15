<?php
 
class Empresa 
{
        public $idEmpresa;
        public $nomeEmpresa;
                
        public function __construct(){}

        public function setIdEmpresa ($valor){$this->idEmpresa = $valor;}
        public function getIdEmpresa (){return $this->idEmpresa;}

        public function setNomeEmpresa ($valor){$this->nomeEmpresa = $valor;}
        public function getNomeEmpresa(){return $this->nomeEmpresa;}        
}
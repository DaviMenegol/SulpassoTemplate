<?php
 
class objRetorno 
{
    public $chaveBruta;
    public $vendedor;
    public $qtd;
    public $valor;
    public $chaveResult;
            
    public function __construct(){}

    public function setChaveBruta ($chaveBruta){$this->chaveBruta = $chaveBruta;}
    public function getChaveBruta (){return $this->chaveBruta;}

    public function setVendedor ($vendedor){$this->vendedor = $vendedor;}
    public function getVendedor (){return $this->vendedor;}


    public function setqtd ($qtd){$this->qtd = $qtd;}
    public function getqtd (){return $this->qtd;}

    public function setvalor ($valor){$this->valor = $valor;}
    public function getvalor(){return $this->valor;}        

    public function setchaveResult ($chaveResult){$this->chaveResult = $chaveResult;}
    public function getchaveResult(){return $this->chaveResult;} 
    
}
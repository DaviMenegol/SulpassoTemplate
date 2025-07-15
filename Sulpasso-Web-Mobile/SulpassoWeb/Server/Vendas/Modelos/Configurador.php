<?php

class Configurador 
{
	public $conexao;
	public $empresa;
	public $vendas;
	public $usuario;
	public $horarios;
	public $telas; 

    public function __construct()
    {
    	$this->conexao = new ConfiguradorConexao();
    	$this->empresa = new ConfiguradorEmpresa();
    	$this->vendas = new ConfiguradorVendas();
    	$this->usuario = new ConfiguradorUsuario();
    	$this->horarios = new ConfiguradorHorarios();
    	$this->telas = new ConfiguradorTelas();
    }

    public function setConexao($valor){$this->conexao = $valor;}
    public function getConexao(){return $this->conexao;} 

    public function setEmpresa($valor){$this->empresa = $valor;}
    public function getEmpresa(){return $this->empresa;} 

    public function setVendas($valor){$this->vendas = $valor;}
    public function getVendas(){return $this->vendas;} 

    public function setUsuario($valor){$this->usuario = $valor;}
    public function getUsuario(){return $this->usuario;} 

    public function setTelas($valor){$this->telas = $valor;}
    public function getTelas(){return $this->telas;} 

    public function setHorario($valor){$this->horarios = $valor;}
    public function getHorario(){return $this->horarios;} 

    public function returnJsonConfig()
    {
        $strJson = "{\"Configurador\":{";

        if($this->conexao->getServerFtp() != null)
        {
            $strJson .= "\"conexao\":";
            $strJson .= json_encode($this->conexao);
            $strJson .= ", ";
        }

        if($this->empresa->getCodigo() != null)
        {
            $strJson .= "\"empresa\":";
            $strJson .= json_encode($this->empresa);
            $strJson .= ", ";
        }

        if($this->vendas->getGerenciarVisitas() != null)
        {
            $strJson .= "\"vendas\":";
            $strJson .= json_encode($this->vendas);
            $strJson .= ", ";
        }

        if($this->usuario->getCodigo() != null)
        {
            $strJson .= "\"usuario\":";
            $strJson .= json_encode($this->usuario);
            $strJson .= ", ";
        }

        if($this->horarios->getInicioManha() != null)
        {
            $strJson .= "\"horarios\":";
            $strJson .= json_encode($this->horarios);
            $strJson .= ", ";
        }

        if($this->telas->getEfetuaTroca() != null)
        {
            $strJson .= "\"telas\":";
            $strJson .= json_encode($this->telas);
            $strJson .= ", ";
        }

        $strJson = substr($strJson, 0, (count($strJson) - 3));

        $strJson .= "}}";

        return $strJson;
    }
}

class ConfiguradorEmpresa 
{
    public $codigo;
    public $nome;
    public $endereco;
    public $fone;
    public $cidade;
    public $email;
    public $site;
    public $login;

    public function __construct(){}

    public function setCodigo($valor){$this->codigo = $valor;}
    public function getCodigo(){return $this->codigo;} 

    public function setNome($valor){$this->nome = $valor;}
    public function getNome(){return $this->nome;} 

    public function setEndereco($valor){$this->endereco = $valor;}
    public function getEndereco(){return $this->endereco;} 

    public function setFone($valor){$this->fone = $valor;}
    public function getFone(){return $this->fone;} 

    public function setCidade($valor){$this->cidade = $valor;}
    public function getCidade(){return $this->cidade;} 

    public function setEmail($valor){$this->email = $valor;}
    public function getEmail(){return $this->email;} 

    public function setSite($valor){$this->site = $valor;}
    public function getSite(){return $this->site;} 

    public function setLogin($valor){$this->login = $valor;}
    public function getLogin(){return $this->login;} 
}

class ConfiguradorUsuario 
{
    public $codigo;
    public $nome;
    public $senha;
    public $tipoFlex;
    public $valorFlex;
    public $pedidoMinimo;
    public $descontoCliente;
    public $descontoItem;
    public $descontoPedido;
    public $contribuicaoIdeal;
    public $tabelaMinimo;
    public $tabelaTroca;
    public $roteiro;
    public $tipoOredenacao;
    public $tipoBusca;
    public $saldo;
    public $comissao;
    public $contribuicao;

    public function __construct(){}

    public function setCodigo($valor){$this->codigo = $valor;}
    public function getCodigo(){return $this->codigo;}
 
    public function setNome($valor){$this->nome = $valor;}
    public function getNome(){return $this->nome;}
 
    public function setSenha($valor){$this->senha = $valor;}
    public function getSenha(){return $this->senha;}
 
    public function setTipoFlex($valor){$this->tipoFlex = $valor;}
    public function getTipoFlex(){return $this->tipoFlex;}
 
    public function setValorFlex($valor){$this->valorFlex = $valor;}
    public function getValorFlex(){return $this->valorFlex;}
 
    public function setPedidoMinimo($valor){$this->pedidoMinimo = $valor;}
    public function getPedidoMinimo(){return $this->pedidoMinimo;}
 
    public function setDecontoCliente($valor){$this->descontoCliente = $valor;}
    public function getDecontoCliente(){return $this->descontoCliente;}
 
    public function setDescontoItem($valor){$this->descontoItem = $valor;}
    public function getDescontoItem(){return $this->descontoItem;}
 
    public function setDescontoPedido($valor){$this->descontoPedido = $valor;}
    public function getDescontoPedido(){return $this->descontoPedido;}
 
    public function setContribuicaoIdeal($valor){$this->contribuicaoIdeal = $valor;}
    public function getContribuicaoIdeal(){return $this->contribuicaoIdeal;}
 
    public function setTabelaMinimo($valor){$this->tabelaMinimo = $valor;}
    public function getTabelaMinimo(){return $this->tabelaMinimo;}
 
    public function setTabelaTroca($valor){$this->tabelaTroca = $valor;}
    public function getTabelaTroca(){return $this->tabelaTroca;}
 
    public function setRoteiro($valor){$this->roteiro = $valor;}
    public function getRoteiro(){return $this->roteiro;}
 
    public function setTipoOrdenacao($valor){$this->tipoOredenacao = $valor;}
    public function getTipoOrdenacao(){return $this->tipoOredenacao;}
 
    public function setTipoBusca($valor){$this->tipoBusca = $valor;}
    public function getTipoBusca(){return $this->tipoBusca;}
 
    public function setSaldo($valor){$this->saldo = $valor;}
    public function getSaldo(){return $this->saldo;}
 
    public function setComissao($valor){$this->comissao = $valor;}
    public function getComissao(){return $this->comissao;}
 
    public function setContribuicao($valor){$this->contribuicao = $valor;}
    public function getContribuicao(){return $this->contribuicao;}
}

class ConfiguradorVendas 
{
    public $gerenciarVisitas;
    public $venderDevedores;
    public $alteraNaturezaInicio;
    public $alteraNaturezaFim;
    public $alteraPrazoInicio;
    public $alteraPrazoFim;
    public $recalcularPreco;
    public $alteraPrecos;
    public $limiteCredito;
    public $tipoFlex;
    public $flexVenda;
    public $flexItem;
    public $controlaEstoque;
    public $descontoGrupo;
    public $frete;
    public $solicitaSenha;
    public $especialAlteraValor;
    public $minimoPrazo;
    public $controlaGps;
    public $descontoPecentual;
    public $validade;
    public $itensDiferentes;

    public function __construct(){}

    public function setGerenciarVisitas($valor){$this->gerenciarVisitas = $valor;}
    public function getGerenciarVisitas(){return $this->gerenciarVisitas;}  
    
    public function setVenderDevedores($valor){$this->venderDevedores = $valor;}
    public function getVenderDevedores(){return $this->venderDevedores;}  
    
    public function setAlteraNaturezaInicio($valor){$this->alteraNaturezaInicio = $valor;}
    public function getAlteraNaturezaInicio(){return $this->alteraNaturezaInicio;}  
    
    public function setAlteraNaturezaFim($valor){$this->alteraNaturezaFim = $valor;}
    public function getAlteraNaturezaFim(){return $this->alteraNaturezaFim;}  
    
    public function setAlteraPrazoInicio($valor){$this->alteraPrazoInicio = $valor;}
    public function getAlteraPrazoInicio(){return $this->alteraPrazoInicio;}  
    
    public function setAlteraPrazoFim($valor){$this->alteraPrazoFim = $valor;}
    public function getAlteraPrazoFim(){return $this->alteraPrazoFim;}  
    
    public function setRecalcularPrecos($valor){$this->recalcularPreco = $valor;}
    public function getRecalcularPrecos(){return $this->recalcularPreco;}  
    
    public function setAlteraPrecos($valor){$this->alteraPrecos = $valor;}
    public function getAlteraPrecos(){return $this->alteraPrecos;}
    
    public function setLimiteCredito($valor){$this->limiteCredito = $valor;}
    public function getLimiteCredito(){return $this->limiteCredito;}  
    
    public function setTipoFlex($valor){$this->tipoFlex = $valor;}
    public function getTipoFlex(){return $this->tipoFlex;}  
    
    public function setFlexVenda($valor){$this->flexVenda = $valor;}
    public function getFlexVenda(){return $this->flexVenda;}  
    
    public function setFlexItem($valor){$this->flexItem = $valor;}
    public function getFlexItem(){return $this->flexItem;}  
    
    public function setControlaEstoque($valor){$this->controlaEstoque = $valor;}
    public function getControlaEstoque(){return $this->controlaEstoque;}  
    
    public function setDescontoGrupo($valor){$this->descontoGrupo = $valor;}
    public function getDescontoGrupo(){return $this->descontoGrupo;}  
    
    public function setFrete($valor){$this->frete = $valor;}
    public function getFrete(){return $this->frete;}  
    
    public function setSolicitaSenha($valor){$this->solicitaSenha = $valor;}
    public function getSolicitaSenha(){return $this->solicitaSenha;}    
    
    public function setEspecialAlteraValor($valor){$this->especialAlteraValor = $valor;}
    public function getEspecialAlteraValor(){return $this->especialAlteraValor;}    
    
    public function setMinimoPrazo($valor){$this->minimoPrazo = $valor;}
    public function getMinimoPrazo(){return $this->minimoPrazo;}    
    
    public function setControlaGps($valor){$this->controlaGps = $valor;}
    public function getControlaGps(){return $this->controlaGps;}    
    
    public function setDescontoPecentual($valor){$this->descontoPecentual = $valor;}
    public function getDescontoPecentual(){return $this->descontoPecentual;}  
    
    public function setValidade($valor){$this->validade = $valor;}
    public function getValidade(){return $this->validade;}  
    
    public function setItensDiferentes($valor){$this->itensDiferentes = $valor;}
    public function getItensDiferentes(){return $this->itensDiferentes;}  
}

class ConfiguradorTelas 
{
    public $efetuaTroca;
    public $vendasDireta;
    public $mixIdeal;
    public $mostraMeta;
    public $cadastroCliente;
    public $tipoFoco;
    public $pesquisaPedidos;
    public $pesquisaItens;
    public $pesquisaClientes;
    public $pesquisaGeral;
    public $telaInicial;

    public function __construct(){}

    public function setEfetuaTroca($valor){$this->efetuaTroca = $valor;}
    public function getEfetuaTroca(){return $this->efetuaTroca;}  
    
    public function setVendaDireta($valor){$this->vendasDireta = $valor;}
    public function getVendaDireta(){return $this->vendasDireta;}  
    
    public function setMixIdeal($valor){$this->mixIdeal = $valor;}
    public function getMixIdeal(){return $this->mixIdeal;}  
    
    public function setMostraMeta($valor){$this->mostraMeta = $valor;}
    public function getMostraMeta(){return $this->mostraMeta;}  
    
    public function setCadastroCliente($valor){$this->cadastroCliente = $valor;}
    public function getCadastroCliente(){return $this->cadastroCliente;}  
    
    public function setTipoFoco($valor){$this->tipoFoco = $valor;}
    public function getTipoFoco(){return $this->tipoFoco;}  
    
    public function setPesquisaPedidos($valor){$this->pesquisaPedidos = $valor;}
    public function getPesquisaPedidos(){return $this->pesquisaPedidos;}  
    
    public function setPesquisaItens($valor){$this->pesquisaItens = $valor;}
    public function getPesquisaItens(){return $this->pesquisaItens;}  
    
    public function setPesquisaClientes($valor){$this->pesquisaClientes = $valor;}
    public function getPesquisaClientes(){return $this->pesquisaClientes;}  
    
    public function setPesquisaGeral($valor){$this->pesquisaGeral = $valor;}
    public function getPesquisaGeral(){return $this->pesquisaGeral;}  
    
    public function setTelaInicial($valor){$this->telaInicial = $valor;}
    public function getTelaInicial(){return $this->telaInicial;}  
}

class ConfiguradorConexao 
{
    public $serverFtp;
    public $serverFtp2;
    public $serverWeb;
    public $ftpUser;
    public $ftpPswd;
    public $uploadFolder;
    public $downloadFolder;
    public $emailSender;
    public $emailPswd;
    public $email1;
    public $email2;
    public $email3;
    public $conectionType;
    public $empresaCliente;

    public function __construct(){}

    public function setServerFtp($valor){$this->serverFtp = $valor;}
    public function getServerFtp(){return $this->serverFtp;}  
    
    public function setServerFtp2($valor){$this->serverFtp2 = $valor;}
    public function getServerFtp2(){return $this->serverFtp2;}  
    
    public function setServerWeb($valor){$this->serverWeb = $valor;}
    public function getServerWeb(){return $this->serverWeb;}  
    
    public function setFtpUser($valor){$this->ftpUser = $valor;}
    public function getFtpUser(){return $this->ftpUser;}  
    
    public function setFtpPswd($valor){$this->ftpPswd = $valor;}
    public function getFtpPswd(){return $this->ftpPswd;}  
    
    public function setUploadFolder($valor){$this->uploadFolder = $valor;}
    public function getUploadFolder(){return $this->uploadFolder;}  
    
    public function setDownloadFolder($valor){$this->downloadFolder = $valor;}
    public function getDownloadFolder(){return $this->downloadFolder;}  
    
    public function setEmailSender($valor){$this->emailSender = $valor;}
    public function getEmailSender(){return $this->emailSender;}  
    
    public function setEmailPswd($valor){$this->emailPswd = $valor;}
    public function getEmailPswd(){return $this->emailPswd;}  
    
    public function setEmail1($valor){$this->email1 = $valor;}
    public function getEmail1(){return $this->email1;}  
    
    public function setEmail2($valor){$this->email2 = $valor;}
    public function getEmail2(){return $this->email2;}  
    
    public function setEmail3($valor){$this->email3 = $valor;}
    public function getEmail3(){return $this->email3;}  
    
    public function setConectionType($valor){$this->conectionType = $valor;}
    public function getConectionType(){return $this->conectionType;}
    
    public function setEmpresaCliente($valor){$this->empresaCliente = $valor;}
    public function getEmpresaCliente(){return $this->empresaCliente;}
}

class ConfiguradorHorarios
{
    public $inicioManha;
    public $finalManha;
    public $inicioTarde;
    public $finalTarde;
    public $tempoPedidos;
    public $tempoClientes;
    public $maximoItens;
    public $horaSistema;
    public $pedidos;
    public $clientes;
    public $atualizacao;
    public $dataAtualizacao;

    public function __construct(){}

    public function setInicioManha($valor){$this->inicioManha = $valor;}
    public function getInicioManha(){return $this->inicioManha;}

    public function setFinalManha($valor){$this->finalManha = $valor;}
    public function getFinalManha(){return $this->finalManha;}

    public function setInicioTarde($valor){$this->inicioTarde = $valor;}
    public function getInicioTarde(){return $this->inicioTarde;}
    
    public function setFinalTarde($valor){$this->finalTarde = $valor;}
    public function getFinalTarde(){return $this->finalTarde;}
    
    public function setTempoPedidos($valor){$this->tempoPedidos = $valor;}
    public function getTempoPedidos(){return $this->tempoPedidos;}
    
    public function setTempoClientes($valor){$this->tempoClientes = $valor;}
    public function getTempoClientes(){return $this->tempoClientes;}
    
    public function setMaximoItens($valor){$this->maximoItens = $valor;}
    public function getMaximoItens(){return $this->maximoItens;}
    
    public function setHoraSistema($valor){$this->horaSistema = $valor;}
    public function getHoraSistema(){return $this->horaSistema;}
    
    public function setPedidos($valor){$this->pedidos = $valor;}
    public function getPedidos(){return $this->pedidos;}
    
    public function setClientes($valor){$this->clientes = $valor;}
    public function getClientes(){return $this->clientes;}
    
    public function setAtualizacao($valor){$this->atualizacao = $valor;}
    public function getAtualizacao(){return $this->atualizacao;}
    
    public function setDataAtualizacao($valor){$this->dataAtualizacao = $valor;}
    public function getDataAtualizacao(){return $this->dataAtualizacao;}
}
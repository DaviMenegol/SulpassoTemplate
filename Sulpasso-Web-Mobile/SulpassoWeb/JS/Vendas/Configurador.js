function getConfigConexao() { return new ConfiguradorConexao(); }

function getConfigEmpresa() { return new ConfiguradorEmpresa(); }

function getConfigVendas() { return new ConfiguradorVendas(); }

function getConfigUsuario() { return new ConfiguradorUsuario(); }

function getConfigHorarios() { return new ConfiguradorHorarios(); }

function getConfigTelas() { return new ConfiguradorTelas(); }

function ConfiguradorConexao() {
    this.serverFtp = recuperarValorForm("#servidor1Configurar"),
        this.serverFtp2 = recuperarValorForm("#servidor2Configurar"),
        this.serverWeb = recuperarValorForm("#servidor3Configurar"),
        this.ftpUser = recuperarValorForm("#usuarioServidorConfigurar"),
        this.ftpPswd = recuperarValorForm("#senhaServidorConfigurar"),
        this.uploadFolder = recuperarValorForm("#enviarConfigurar"),
        this.downloadFolder = recuperarValorForm("#receberConfigurar"),
        this.emailSender = recuperarValorForm("#emailConfigurar"),
        this.emailPswd = recuperarValorForm("#emailSenhaConfigurar"),
        this.email1 = recuperarValorForm("#destinatario1Configurar"),
        this.email2 = recuperarValorForm("#destinatario2Configurar"),
        this.email3 = recuperarValorForm("#destinatario3Configurar"),
        this.conectionType = recuperarValorForm("#tipoConexaoConfigurar")
}

function ConfiguradorEmpresa() {
    this.codigo = recuperarValorForm("#nomeUsuarioCadastrar"),
        this.nome = recuperarValorForm("#nomeEmpresaConfigurar"),
        this.endereco = recuperarValorForm("#enderecoEmpresaConfigurar"),
        this.fone = recuperarValorForm("#telefoneEmpresaConfigurar"),
        this.cidade = recuperarValorForm("#cidadeEmpresaConfigurar"),
        this.email = recuperarValorForm("#emailEmpresaConfigurar"),
        this.site = recuperarValorForm("#siteEmpresaConfigurar"),
        this.login = recuperarValorForm("#controleAcessoConfigurar")
}

function ConfiguradorVendas() {
    this.gerenciarVisitas = recuperarValorFormRadio("visitasConfigurar"),
        this.venderDevedores = recuperarValorFormRadio("devedoresConfigurar"),
        this.alteraNaturezaInicio = recuperarValorFormCheck("#naturezaInicioConfigurar"),
        this.alteraNaturezaFim = recuperarValorFormCheck("#naturezaFimConfigurar"),
        this.alteraPrazoInicio = recuperarValorFormCheck("#prazoInicioConfigurar"),
        this.alteraPrazoFim = recuperarValorFormCheck("#prazoFimConfigurar"),
        this.recalcularPreco = recuperarValorFormRadio("recalcularConfigurar"),
        this.alteraPrecos = recuperarValorFormRadio("altPrecosConfigurar"),
        this.limiteCredito = recuperarValorFormRadio("limiteConfigurar"),
        this.tipoFlex = recuperarValorFormRadio("flexConfigurar"),
        this.flexVenda = recuperarValorFormCheck("#flexVendaConfigurar"),
        this.flexItem = recuperarValorFormCheck("#flexItemConfigurar"),
        this.controlaEstoque = recuperarValorFormRadio("estoqueConfigurar"),
        this.descontoGrupo = recuperarValorFormRadio("campanhasConfigurar"),
        this.frete = recuperarValorFormRadio("freteConfigurar"),
        this.solicitaSenha = recuperarValorFormRadio("senhaConfigurar"),
        //this.especialAlteraValor = recuperarValorFormRadio("especialConfigurar"),
        //this.especialAlteraValor = recuperarValorFormRadio("especialConfigurar"),
        this.especialAlteraValor = recuperarValorFormCheckMulti(),
        this.minimoPrazo = recuperarValorFormRadio("mpConfigurar"),
        this.controlaGps = recuperarValorFormRadio("gpsConfigurar"),
        this.descontoPecentual = recuperarValorFormRadio("percentualConfigurar"),
        this.itensDiferentes = recuperarValorForm("#itensDiferentesConfigurar"),
        this.validade = recuperarValorForm("#validadeConfigurar")
}

function ConfiguradorUsuario() {
    this.codigo = recuperarValorForm("#nomeUsuarioCadastrar"),
        this.nome = recuperarValorForm("#aliasUsuarioCadastrar"),
        this.senha = recuperarValorForm("#senhaUsuarioCadastrar"),
        this.tipoFlex = recuperarValorFormRadio("radioTipoFlexConfigurar"),
        this.valorFlex = recuperarValorForm("#valorFlexConfigurar"),
        this.pedidoMinimo = recuperarValorForm("#pedidoMinimoConfigurar"),
        this.descontoCliente = recuperarValorForm("#descontoItemConfigurar"),
        this.descontoItem = recuperarValorForm("#descontoItemConfigurar"),
        this.descontoPedido = recuperarValorForm("#descontoPedidoConfigurar"),
        this.contribuicaoIdeal = recuperarValorForm("#contribuicaoIdealConfigurar"),
        this.tabelaMinimo = recuperarValorForm("#tabelaMinimoConfigurar"),
        this.tabelaTroca = recuperarValorForm("#tabelaTrocaConfigurar"),
        this.roteiro = recuperarValorForm("#roteiroConfigurar"),
        this.tipoOredenacao = recuperarValorFormRadio("radioTipoOrdenacaoConfigurar"),
        this.tipoBusca = recuperarValorFormRadio("radioTipoBuscaConfigurar"),
        this.saldo = recuperarValorForm("#saldoConfigurar"),
        this.comissao = recuperarValorForm("#comissaoConfigurar"),
        this.contribuicao = recuperarValorForm("#contribuicaoConfigurar")
}

function ConfiguradorHorarios() {
    this.inicioManha = recuperarValorForm("#inicioManhaConfigurar"),
        this.finalManha = recuperarValorForm("#fimManhaConfigurar"),
        this.inicioTarde = recuperarValorForm("#inicioTardeConfigurar"),
        this.finalTarde = recuperarValorForm("#fimTardeConfigurar"),
        this.tempoPedidos = recuperarValorForm("#tempoPedidosConfigurar"),
        this.tempoClientes = recuperarValorForm("#tempoClientesConfigurar"),
        this.maximoItens = recuperarValorForm("#unidadesConfigurar"),
        this.horaSistema = recuperarValorForm("#senhaUsuarioCadastrar"),
        this.pedidos = recuperarValorForm("#pedidosConfigurar"),
        this.clientes = recuperarValorForm("#clientesConfigurar"),
        this.atualizacao = recuperarValorForm("#atualizacaoConfigurar"),
        this.dataAtualizacao = recuperarValorForm("#senhaUsuarioCadastrar")
}

function ConfiguradorTelas() {
    this.efetuaTroca = recuperarValorFormRadio("trocasConfigurar"),
        this.vendasDireta = recuperarValorFormRadio("diretasConfigurar"),
        this.mixIdeal = recuperarValorFormRadio("mixConfigurar"),
        this.mostraMeta = recuperarValorFormRadio("metaConfigurar"),
        this.cadastroCliente = recuperarValorFormRadio("cadastroConfigurar"),
        this.tipoFoco = recuperarValorFormRadio("focoConfigurar"),
        this.pesquisaPedidos = recuperarValorForm("#pesqPedConfigurar"),
        this.pesquisaItens = recuperarValorForm("#pesqItensConfigurar"),
        this.pesquisaClientes = recuperarValorForm("#pesqCliConfigurar"),
        this.pesquisaGeral = recuperarValorForm("#pesqGeralConfigurar"),
        this.telaInicial = recuperarValorForm("#telainicialConfigurar")
}
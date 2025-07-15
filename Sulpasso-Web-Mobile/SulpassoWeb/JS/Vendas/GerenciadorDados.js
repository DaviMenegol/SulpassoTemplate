var tipoConfiguracao = -1;

$(document).ready(function() {

    $('.ocultar').hide();
    exibirBoasVindas("Bem vindo!");
    $('#first li a, #second li a').on("click", function(event) {
        excluirBoasVindas(200);
        $("#lista-usuarios").empty();
        $("#lista-usuarios-venda").empty();
        $("#lista-usuarios-tela").empty();
        $("#lista-usuarios-horario").empty();
        $("#lista-usuarios-conexao").empty();

        $('.ocultar').fadeOut(200);

        switch (event.target.id) {
            case 'cadastroUsuarios':
                $('#cadastrar-usuarios').show(400);
                buscarCodigo();
                
                break;
            case 'configurarUsuario':
                tipoConfiguracao = 4;
                $('#configurar-usuarios').show(400);
                buscarUsuarios("#lista-usuarios");
                break;
            case 'configurarPerfil':
                exibirBoasVindas("Esses são os Dados do Usuário Logado!");
                $('#configurar-perfil').show(400);
                carregaDadosLogin('#configurar-perfil');
                break;
            case 'configurarEmpresa':
                $('#configurar-dados-empresa').show(400);
                tipoConfiguracao = 1;
                carregarConfiguracao();
                break;
            case 'configurarVendas':
                tipoConfiguracao = 5;
                buscarUsuarios("#lista-usuarios-venda");
                $('#configurar-venda').show(400);
                break;
            case 'configurarTelas':
                tipoConfiguracao = 3;
                buscarUsuarios("#lista-usuarios-tela");
                $('#configurar-telas').show(400);
                break;
            case 'configurarHorarios':
                tipoConfiguracao = 2;
                buscarUsuarios("#lista-usuarios-horario");
                $('#configurar-horarios').show(400);
                break;
            case 'configurarConexao':
                tipoConfiguracao = 0;
                buscarUsuarios("#lista-usuarios-conexao");
                $('#configurar-conexao').show(400);
                break;
            case 'disponibilizarConfiguracao':
                buscarUsuarios("#lista-usuarios-configuracao");
                $('#disponibilizar-configuracao').show(400);
                break;
            default:
                break;
        }
        
    });

    $('#usuarioCadastrar').bind('click',function(){ 
        excluirBoasVindas(200);
        salvarUsuario("Cadastro")});

$('#GerarChave').on("click", function(event) {
  window.open("../SulpassoWeb/GeradorChaveBanco");
// function cb(resultado) //QUANDO FOR DEIXAR EM MANUTENÇÃO
//     {

//         var dadosJSON;
//         try { dadosJSON = JSON.parse(resultado); } catch (e) {alert(e); };

//         if(dadosJSON["cod_user"] == 999 && dadosJSON["emp_user"] == 3){
//             window.open("../SulpassoWeb/GeradorChaveBanco");
//         }else{
//             alert("Em Manutenção! Em breve Disponível...");
//         }
//     }

//     $.ajax({
//         method: 'GET',
//         url: '../SulpassoWeb/GeradorChaveBanco/php/identificador.php',
//         statusCode: {
//             404: function() { alert("Página não encontrada"); },
//             500: function() { alert("Erro interno do servidor"); }
//         }
//     }).done(function(e) {cb(e); });
    
});

    $('#avisosSistema').on("click", function() {
        if($('#avisosSistema').innerHTML == ""){
            excluirBoasVindas();
        }
    });

    $('#DadosUser').on("click", function() {
        salvarUsuario("Usuario");
    });
    $('#DadosPerfil').on("click", function() {
        salvarUsuario("Perfil");
    });

    $('#usuarioConfigurar').on("click", function(event) {
        enviarConfiguracao("usuario");
    });

    $('#empresaConfigurar').on("click", function(event) {
        enviarConfiguracao("empresa");
    });

    $('#vendasConfigurar').on("click", function(event) {
        enviarConfiguracao("vendas");
    });

    $('#telasConfigurar').on("click", function(event) {
        enviarConfiguracao("telas");
    });

    $('#horariosConfigurar').on("click", function(event) {
        enviarConfiguracao("horario");
    });

    $('#conexaoConfigurar').on("click", function(event) {
        enviarConfiguracao("conexao");
    });


    $('#btnDisponibilizarConfiguracao').on("click", function(event) {
        disponibiliarConfiguracoes();
    });

    $("input:radio[name='altPrecosConfigurar']").on("change", function(event) {
        alert("Alterado valor de altera preços para \n" + $("input:radio[name='altPrecosConfigurar']:checked").val());
        let altera = $("input:radio[name='altPrecosConfigurar']:checked").val();
        if (altera == 0) {
            alert("Alterar seleção");
            $("input:radio[name='senhaConfigurar'][value='1']").prop("checked", false);
            $("input:radio[name='senhaConfigurar'][value='1']").parent().removeClass('active');
            $("input:radio[name='senhaConfigurar'][value='0']").prop("checked", true);
            $("input:radio[name='senhaConfigurar'][value='0']").parent().addClass('active');

        } else {
            alert("Inverter seleção");
            $("input:radio[name='senhaConfigurar'][value='0']").prop("checked", false);
            $("input:radio[name='senhaConfigurar'][value='0']").parent().removeClass('active');
            $("input:radio[name='senhaConfigurar'][value='1']").prop("checked", true);
            $("input:radio[name='senhaConfigurar'][value='1']").parent().addClass('active');
        }
    });
});
/*END OF $(document).ready*/


function excluirBoasVindas(timer,modoLento) {
    if(document.querySelector('#avisosSistema').innerHTML != ""){
        if(!modoLento)
        $('#page-inner div.row:first').hide(timer ? timer : 200);
        setTimeout(document.querySelector('#avisosSistema').innerHTML = "",timer ? timer : 200)
    }
    
    }

function exibirBoasVindas(texto) {

    if(document.querySelector('#avisosSistema').innerHTML != "")
        excluirBoasVindas(200,true);

    document.querySelector('#avisosSistema').innerHTML = `<div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <span id="wellcome">${texto}</span>
                                    </div>`;
    $('#page-inner div.row:first').show(200);
    setTimeout(function(){$("#page-inner, #page-inner *").removeClass("aguarde")},200);
    var elementoPosicao = document.getElementById("avisosSistema").getBoundingClientRect().top + window.screenY;
    $('#page-inner')[0].animate({ scrollTop: elementoPosicao }, 400, 'swing');
    
    
}


function buscarCodigo() {
    $.ajax({
            type: 'POST',
            url: 'Server/Vendas/ListarUsuarios.php?action=codigo',
            statusCode: {
                404: function() { $('#codigoUsuarioCadastrar').val('-1'); },
                500: function() { $('#codigoUsuarioCadastrar').val('-1'); }
            }
        })
        .done(function(e) { $('#codigoUsuarioCadastrar').val(e); });
}

function buscarUsuarios(local) {
    $.ajax({
        type: 'POST',
        url: 'Server/Vendas/ListarUsuarios.php?action=empresa',
        statusCode: {
            404: function() { /*Redirecionar pagina de erro*/ },
            500: function() { /*Redirecionar pagina de erro*/ }
        }
    }).done(function(e) {
        if (local == "#lista-usuarios-configuracao") { separarUsuariosMult(e, local); }
        else { separarUsuarios(e, local); }
    });
}

function verificarRepetido(cb,local){ //Barra o cadastro repetido
    $.ajax({
        type: 'POST',
        url: 'Server/Vendas/ListarUsuarios.php?action=funcionarios',
        statusCode: { 
            404: function() { /*Redirecionar pagina de erro*/ },
            500: function() { /*Redirecionar pagina de erro*/ }
        }
    }).done(function(e) {
    var dadosJSON;
    try { dadosJSON = JSON.parse(e); } catch (e) { eval("dadosJSON = (" + e + ");"); }
    var posicao = dadosJSON.length;

         if(local == "Cadastro")
         var formUser = getUsuario();
    else if(local == "Usuario")
            var formUser = getDadosLogin("User"); 
    else if(local == "Perfil")    
        var formUser = getDadosLogin("Perfil");
    while(posicao--){
        if ((formUser.codigoUsuario == dadosJSON[posicao].idUsuario) && (formUser.aliasUsuario.toUpperCase() == dadosJSON[posicao].nomeUsuario.toUpperCase()))
        {
            if(local == "Cadastro"){
                cb(3,local);
                return
                }
        }
        if(formUser.aliasUsuario.toUpperCase() == dadosJSON[posicao].nomeUsuario.toUpperCase())
            {
                if(local == "Cadastro"){
                    cb(2,local);
                    return
                    }else{
                    if(formUser.codigoUsuario != dadosJSON[posicao].idUsuario){
                    cb(2,local);
                    return
                    }
                }
            }   
        if(formUser.codigoUsuario == dadosJSON[posicao].idUsuario)
        {
            if(local == "Cadastro"){
            cb(1,local);
            return
            }
        }   
        
    }  
    cb(0,local);
    });
}
function separarUsuarios(resultado, local) {
    var select = $(local);
    select.html("");

    var dadosJSON;
    try { dadosJSON = JSON.parse(resultado); } catch (e) { eval("dadosJSON = (" + resultado + ");"); }

    var posicao = dadosJSON.length;

    select.append('<div class=\"btn-group\" data-toggle=\"buttons\">');

    while (posicao--) {
        select.append('<label class=\"btn btn-primary\" style=\"width: 150px;text-align: left;\"><input type=\"radio\" style=\"margin: 4px;\"name=\"radioUsuariosConfigurar\" value=\"' +
            +dadosJSON[posicao].idUsuario + '\" autocomplete=\"off\">' + dadosJSON[posicao].nomeUsuario + '</label>');
    }

    select.append('<label class=\"btn btn-success\" style=\"width: 150px;text-align: left;\"><input type=\"radio\" style=\"margin: 4px;\"name=\"radioUsuariosConfigurar\" value=\"0\" autocomplete=\"off\">Todos</label>');
    select.append('</div>');

    $(local).off('change', "input[name=radioUsuariosConfigurar]");
    $(local).on('change', "input[name=radioUsuariosConfigurar]", function() {
        carregarConfiguracao();
        if(local == "#lista-usuarios"){carregaDadosLogin(local);}
    });
}

function separarUsuariosMult(resultado, local) {
    var select = $(local);
    var nrUsauariosExibidos = 0;

    select.html("");

    var dadosJSON;
    try { dadosJSON = JSON.parse(resultado); } catch (e) { eval("dadosJSON = (" + resultado + ");"); }

    var posicao = dadosJSON.length;

    var strHTML = "";

    strHTML += '<div class=\"container\">';

    while (posicao--) {
        nrUsauariosExibidos++;

        strHTML += '<div class=\"btn-group\" data-toggle=\"buttons\">';
        strHTML += '<label class=\"btn btn-primary checkbox-inline\" style=\"width: 107px;\"><input data-js = \"usr\" class=\"checkConfig\" type=\"checkbox\" name=\"checkSendConfigUsr\" value=\"' +
            dadosJSON[posicao].idUsuario + '\" autocomplete=\"off\">' + dadosJSON[posicao].nomeUsuario + '</label>'
        strHTML += '</div>';

        if (nrUsauariosExibidos == 3) {
            strHTML += '<br />';
            nrUsauariosExibidos = 0;
        }
    }

    strHTML += '</div>';

    select.append(strHTML);

    $(".checkConfig").off("change")
    $(".checkConfig").change(function() {
        this.parentElement.classList.toggle("btn-primary");
        this.parentElement.classList.toggle("btn-success");
    });
}
function carregarConfiguracao() {
    var valorSelecionado = recuperarValorFormRadio("radioUsuariosConfigurar");
    limparRadioUsuarios();
    $.ajax({
            type: 'POST',
            url: 'Server/Vendas/CarregarConfiguracao.php?usuario=' + valorSelecionado + "&configuracao=" + tipoConfiguracao,
            data: JSON.stringify(getUsuario()),
            statusCode: {
                404: function() {
                    exibirBoasVindas("Página não encontrada.<br />Por favor entre com contato com o suporte.");
                },
                500: function() {
                    exibirBoasVindas("Erro no servidor do sistema.<br />Por favor entre com contato com o suporte.");
                }
            }
        })
        .done(function(e) {
            switch (tipoConfiguracao) {
                case 0:
                    carregarFormularioConexao(e);
                    break;
                case 1:
                    carregarFormularioEmpresas(e);
                    break;
                case 2:
                    carregarFormularioHorario(e);
                    break;
                case 3:
                    carregarFormularioTelas(e);
                    break;
                case 4:
                    carregarFormularioUsuario(e);
                    break;
                default:
                    carregarFormularioVendas(e);
                    break;
            }
        });
}
//MAGICA!
function carregaDadosLogin(local){
    if(local == "#lista-usuarios"){
    local = "User";
    var valorSelecionado = recuperarValorFormRadio("radioUsuariosConfigurar");
    }else{
        var valorSelecionado = 999;
        local = "Perfil";
    }

    $.ajax({
            type: 'POST',
            url: 'Server/Vendas/CarregarConfiguracao.php?usuario=' + valorSelecionado + "&configuracao=" + 6,
            data: JSON.stringify(getUsuario()),
            statusCode: {
                404: function() {
                    exibirBoasVindas("Página não encontrada.<br />Por favor entre com contato com o suporte.");
                },
                500: function() {
                    exibirBoasVindas("Erro no servidor do sistema.<br />Por favor entre com contato com o suporte.");
                }
            }
        })
        .done(function(e) {carregarFormularioDadosLogin(e,local)});
        
}

function salvarUsuario(local) {

    // console.log("SalvarUser",local)
    function tratar (result,local) {
        // console.log("Tratar",local)
        if(local == "Cadastro"){
            if(result == 0) {enviarUsuarioCadastrado()}
            if(result == 1) {exibirBoasVindas("Codigo já cadastrado! Tente novamente...")}
            if(result == 2) {exibirBoasVindas("Login já cadastrado! Tente novamente...")}
            if(result == 3) {exibirBoasVindas("Codigo & Login já cadastrados! Tente novamente...")}
        }
            
        if(local == "Perfil"){
            if(result == 0) {enviarConfiguracaoPerfil()}
            if(result == 2) {exibirBoasVindas("Login já cadastrado! Tente novamente...")}

        }

        if(local == "Usuario"){
            if(result == 0) {enviarConfiguracao("dadosLogin")}
            if(result == 2) {exibirBoasVindas("Login já cadastrado! Tente novamente...")}
        }
        $("#lista-usuarios").empty();
        buscarUsuarios("#lista-usuarios");
    }
    exibirBoasVindas("Consultando Servidor...")
    verificarRepetido(tratar,local);
    

    // $('#page-inner div.row:first').show();
    
    
}

function enviarUsuarioCadastrado() {
    $.ajax({
            type: 'POST',
            url: 'Server/Vendas/InserirUsuarios.php',
            data: JSON.stringify(getUsuario()),
            statusCode: {
                404: function() {
                    exibirBoasVindas("Página não encontrada.<br />Por favor entre com contato com o suporte.");
                },
                500: function() {
                    exibirBoasVindas("Erro no servidor do sistema.<br />Por favor entre com contato com o suporte.");
                }
            }
        })
        .done(function(e) {
            if (JSON.parse(e) == true) { exibirBoasVindas("Usuário cadastrado com sucesso.");} else { exibirBoasVindas("Não foi possível cadastrar o novo usuário."); }
        });
}

function enviarConfiguracao(tipo) {
    var usuario = recuperarValorFormRadio("radioUsuariosConfigurar");
    $.ajax({
            type: 'POST',
            url: 'Server/Vendas/InserirConfiguracao.php?action=' + tipo + "&usuario_a_configurar=" + usuario,
            data: JSON.stringify(recuperarConfiguracao(tipo)),
            statusCode: {
                404: function() {
                    exibirBoasVindas("Página não encontrada.<br />Por favor entre com contato com o suporte.");
                },
                500: function() {
                    exibirBoasVindas("Erro no servidor do sistema.<br />Por favor entre com contato com o suporte.");
                }
            }
        })
        .done(function(e) {
            if (JSON.parse(e) == true) {
                exibirBoasVindas("Configuração cadastrada com sucesso.");
            } else {
                exibirBoasVindas("Não foi possível cadastrar configuração.");
            }

        });
}
function enviarConfiguracaoPerfil() {
    var usuario = $("#CodigoPerfil").val();
    $.ajax({
            type: 'POST',
            url: 'Server/Vendas/InserirConfiguracao.php?action=dadosLogin&usuario_a_configurar=' + usuario,
            data: JSON.stringify(getDadosLogin("Perfil")),
            statusCode: {
                404: function() {
                    exibirBoasVindas("Página não encontrada.<br />Por favor entre com contato com o suporte.");
                },
                500: function() {
                    exibirBoasVindas("Erro no servidor do sistema.<br />Por favor entre com contato com o suporte.");
                }
            }
        })
        .done(function(e) {
            if (JSON.parse(e) == true) {
                exibirBoasVindas("Configuração cadastrada com sucesso.");
            } else {
                exibirBoasVindas("Não foi possível cadastrar configuração.");
            }

        });
}


function recuperarConfiguracao(tipo) {
    switch (tipo) {
        case "conexao":
            return getConfigConexao();
        case "empresa":
            return getConfigEmpresa();
        case "usuario":
            return getConfigUsuario();
        case "horario":
            return getConfigHorarios();
        case "vendas":
            return getConfigVendas();
        case "telas":
            return getConfigTelas();
        case "dadosLogin":
        return getDadosLogin("User");
    }
}

function getDadosLogin(local) { return new DadosLogin(local); }

function DadosLogin(local) {
        this.codigoUsuario = $("#Codigo"+local).val(),
        this.nomeUsuario = $("#Nome"+local).val(),
        this.aliasUsuario =  $("#Login"+local).val(),
        this.senhaUsuario =   $("#Senha"+local).val()     
}


function getUsuario() { return new Usuario(); }

function Usuario() {
    this.codigoUsuario = recuperarValorForm("#codigoUsuarioCadastrar"),
        this.nomeUsuario = recuperarValorForm("#nomeUsuarioCadastrar"),
        this.aliasUsuario = recuperarValorForm("#aliasUsuarioCadastrar"),
        this.senhaUsuario = recuperarValorForm("#senhaUsuarioCadastrar"),
        this.tipoUsuario = recuperarValorForm("#tipoUsuarioCadastrar")
}

function carregarFormularioUsuario(resposta) {
    var selectedRadioValue;
    var dadosJSON;

    try { dadosJSON = JSON.parse(resposta); } catch (e) { eval("dadosJSON = (" + resposta + ");"); }
    if (dadosJSON.valorFlex == null) { alert("Usuario não configurado"); } else {
        $("#valorFlexConfigurar").val(dadosJSON.valorFlex);
        $("#pedidoMinimoConfigurar").val(dadosJSON.pedidoMinimo);
        $("#descontoItemConfigurar").val(dadosJSON.descontoItem);
        $("#descontoPedidoConfigurar").val(dadosJSON.descontoPedido);
        $("#contribuicaoIdealConfigurar").val(dadosJSON.contribuicaoIdeal);
        $("#tabelaMinimoConfigurar").val(dadosJSON.tabelaMinimo);
        $("#tabelaTrocaConfigurar").val(dadosJSON.tabelaTroca);
        $("#roteiroConfigurar").val(dadosJSON.roteiro);
        $("#saldoConfigurar").val(dadosJSON.saldo);
        $("#comissaoConfigurar").val(dadosJSON.comissao);
        $("#contribuicaoConfigurar").val(dadosJSON.contribuicao);

        selectedRadioValue = dadosJSON.tipoFlex;
        $("input[name=radioTipoFlexConfigurar][value='" + selectedRadioValue + "']").prop('checked', true).parent().addClass("active");

        selectedRadioValue = dadosJSON.tipoOredenacao;
        $("input[name=radioTipoOrdenacaoConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");

        selectedRadioValue = dadosJSON.tipoBusca;
        $("input[name=radioTipoBuscaConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    }

    /*
        {
            "descontoCliente":10,
        }
    */

    
}
//MAGICA
function limparRadioUsuarios(){
    $("input[type='radio']:not([name=radioUsuariosConfigurar])").prop('checked', false).parent().removeClass("active");
    $("input[type='checkbox']").prop('checked', false).parent().removeClass("active");
    $("select").val(0);
}
//MAGICA
function carregarFormularioDadosLogin(resposta,local) {
    var dadosJSON;
    try { dadosJSON = JSON.parse(resposta); } catch (e) { eval("dadosJSON = (" + resposta + ");"); }

        $(" #Codigo"+local).val(dadosJSON[0]);
        $(" #Nome"+local).val(dadosJSON[1]);
        $(" #Login"+local).val(dadosJSON[2]);
        $(" #Senha"+local).val(dadosJSON[3]);
}

function carregarFormularioEmpresas(resposta) {
    //    exibirBoasVindas(resposta);

    var dadosJSON;

    try { dadosJSON = JSON.parse(resposta); } catch (e) { eval("dadosJSON = (" + resposta + ");"); }

    if (dadosJSON.codigo == null || dadosJSON.codigo == '') { alert("Empresa não configurada"); } else {
        $("#nomeEmpresaConfigurar").val(dadosJSON.nome);
        $("#enderecoEmpresaConfigurar").val(dadosJSON.endereco);

        $("#telefoneEmpresaConfigurar").val(dadosJSON.fone);
        $("#cidadeEmpresaConfigurar").val(dadosJSON.cidade);
        $("#emailEmpresaConfigurar").val(dadosJSON.email);
        $("#siteEmpresaConfigurar").val(dadosJSON.site);
        $("#controleAcessoConfigurar").val(dadosJSON.login);
    }
}

function carregarFormularioVendas(resposta) {

    var selectedRadioValue;
    var dadosJSON;

    try { dadosJSON = JSON.parse(resposta); } catch (e) { eval("dadosJSON = (" + resposta + ");"); }

    $("#valorFlexConfigurar").val(dadosJSON.valorFlex);

    $("#itensDiferentesConfigurar").val(dadosJSON.itensDiferentes);

    selectedRadioValue = dadosJSON.gerenciarVisitas;
    $("input[name=visitasConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    selectedRadioValue = dadosJSON.venderDevedores;
    $("input[name=devedoresConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    selectedRadioValue = dadosJSON.recalcularPreco;
    $("input[name=recalcularConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    selectedRadioValue = dadosJSON.alteraPrecos;
    $("input[name=altPrecosConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    selectedRadioValue = dadosJSON.limiteCredito;
    $("input[name=limiteConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    selectedRadioValue = dadosJSON.tipoFlex;
    $("input[name=flexConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    selectedRadioValue = dadosJSON.controlaEstoque;
    $("input[name=estoqueConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    selectedRadioValue = dadosJSON.descontoGrupo;
    $("input[name=campanhasConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    selectedRadioValue = dadosJSON.frete;
    $("input[name=freteConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    selectedRadioValue = dadosJSON.solicitaSenha;
    $("input[name=senhaConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    selectedRadioValue = dadosJSON.minimoPrazo;
    $("input[name=mpConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    selectedRadioValue = dadosJSON.controlaGps;
    $("input[name=gpsConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    selectedRadioValue = dadosJSON.descontoPecentual;
    $("input[name=percentualConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");

    var marcado;

    marcado = dadosJSON.alteraNaturezaInicio == 1 ? true : false;
    $("#naturezaInicioConfigurar").prop('checked', marcado);
    if (marcado)
        $("#naturezaInicioConfigurar").parent().addClass("active");

    marcado = dadosJSON.alteraNaturezaFim == 1 ? true : false;
    $("#naturezaFimConfigurar").prop('checked', marcado);
    if (marcado)
        $("#naturezaFimConfigurar").parent().addClass("active");

    marcado = dadosJSON.alteraPrazoInicio == 1 ? true : false;
    $("#prazoInicioConfigurar").prop('checked', marcado);
    if (marcado)
        $("#prazoInicioConfigurar").parent().addClass("active");

    marcado = dadosJSON.alteraPrazoFim == 1 ? true : false;
    $("#prazoFimConfigurar").prop('checked', marcado);
    if (marcado)
        $("#prazoFimConfigurar").parent().addClass("active");

    marcado = dadosJSON.flexVenda == 1 ? true : false;
    $("#flexVendaConfigurar").prop('checked', marcado);
    if (marcado)
        $("#flexVendaConfigurar").parent().addClass("active");

    marcado = dadosJSON.flexItem == 1 ? true : false;
    $("#flexItemConfigurar").prop('checked', marcado);
    if (marcado)
        $("#flexItemConfigurar").parent().addClass("active");


    selectedRadioValue = dadosJSON.especialAlteraValor;

    switch (selectedRadioValue) {
        case '0':
            $("#especialConfigurarH").prop('checked', false);
            $("#especialConfigurarH").parent().removeClass("active");

            $("#especialConfigurarL").prop('checked', false);
            $("#especialConfigurarL").parent().removeClass("active");
            break;
        case '1':
            $("#especialConfigurarH").prop('checked', true);
            $("#especialConfigurarH").parent().addClass("active");

            $("#especialConfigurarL").prop('checked', false);
            $("#especialConfigurarL").parent().removeClass("active");
            break;
        case '2':
            $("#especialConfigurarH").prop('checked', true);
            $("#especialConfigurarH").parent().addClass("active");

            $("#especialConfigurarL").prop('checked', true);
            $("#especialConfigurarL").parent().addClass("active");
            break;
        case '3':
            $("#especialConfigurarH").prop('checked', false);
            $("#especialConfigurarH").parent().removeClass("active");

            $("#especialConfigurarL").prop('checked', true);
            $("#especialConfigurarL").parent().addClass("active");
            break;
    }


    /*
            {
                "validade":"30\/12\/2017"
            }
     
        */
    //    }
}

function carregarFormularioHorario(resposta) {
    var dadosJSON;

    try { dadosJSON = JSON.parse(resposta); } catch (e) { eval("dadosJSON = (" + resposta + ");"); }

    if (dadosJSON.inicioManha == null) { alert("Usuário não configurado"); } else {
        $("#inicioManhaConfigurar").val(dadosJSON.inicioManha);
        $("#fimManhaConfigurar").val(dadosJSON.finalManha);
        $("#inicioTardeConfigurar").val(dadosJSON.inicioTarde);
        $("#fimTardeConfigurar").val(dadosJSON.finalTarde);
        $("#tempoPedidosConfigurar").val(dadosJSON.tempoPedidos);
        $("#tempoClientesConfigurar").val(dadosJSON.tempoClientes);
        $("#unidadesConfigurar").val(dadosJSON.maximoItens);
        $("#pedidosConfigurar").val(dadosJSON.pedidos);
        $("#clientesConfigurar").val(dadosJSON.clientes);
        $("#atualizacaoConfigurar").val(dadosJSON.atualizacao);
        /*
            {
                "horaSistema":null,
                "dataAtualizacao":""
            }
        */
    }
}

function carregarFormularioTelas(resposta) {
    var selectedRadioValue;
    var dadosJSON;

    try { dadosJSON = JSON.parse(resposta); } catch (e) { eval("dadosJSON = (" + resposta + ");"); }

    if (dadosJSON.pesquisaPedidos == null) { alert("Usuário não configurado"); } else {
        // // console.log("AAA",typeof dadosJSON.pesquisaPedidos)
        $("#pesqPedConfigurar").val(dadosJSON.pesquisaPedidos);
        $("#pesqItensConfigurar").val(dadosJSON.pesquisaItens);
        $("#pesqCliConfigurar").val(dadosJSON.pesquisaClientes);
        $("#pesqGeralConfigurar").val(dadosJSON.pesquisaGeral);
        $("#telainicialConfigurar").val(dadosJSON.telaInicial);


        selectedRadioValue = dadosJSON.efetuaTroca;
        $("input[name=trocasConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");

        selectedRadioValue = dadosJSON.vendasDireta;
        $("input[name=diretasConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");

        selectedRadioValue = dadosJSON.mixIdeal;
        $("input[name=mixConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");

        selectedRadioValue = dadosJSON.mostraMeta;
        $("input[name=metaConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");

        selectedRadioValue = dadosJSON.cadastroCliente;
        $("input[name=cadastroConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");

        selectedRadioValue = dadosJSON.tipoFoco;
        $("input[name=focoConfigurar][value=" + selectedRadioValue + "]").prop('checked', true).parent().addClass("active");
    }
}

function carregarFormularioConexao(resposta) {
    var dadosJSON;

    try { dadosJSON = JSON.parse(resposta); } catch (e) { eval("dadosJSON = (" + resposta + ");"); }

    if (dadosJSON.serverFtp == null) { alert("Usuário não configurado"); } else {
        $("#servidor1Configurar").val(dadosJSON.serverFtp);
        $("#servidor2Configurar").val(dadosJSON.serverFtp2);
        $("#servidor3Configurar").val(dadosJSON.serverWeb);
        $("#usuarioServidorConfigurar").val(dadosJSON.ftpUser);
        $("#senhaServidorConfigurar").val(dadosJSON.ftpPswd);
        $("#enviarConfigurar").val(dadosJSON.uploadFolder);
        $("#receberConfigurar").val(dadosJSON.downloadFolder);
        $("#emailConfigurar").val(dadosJSON.emailSender);
        $("#emailSenhaConfigurar").val(dadosJSON.emailPswd);
        $("#destinatario1Configurar").val(dadosJSON.email1);
        $("#destinatario2Configurar").val(dadosJSON.email2);
        $("#destinatario3Configurar").val(dadosJSON.email3);
        $("#tipoConexaoConfigurar").val(dadosJSON.conectionType);
    }
}

function disponibiliarConfiguracoes() {
    /*
        Alterar os retornos do dessa função
        Desmarcar as checkboxes selecionadas
    */
    var data_js = "";

    $(".checkConfig").each(function(index) {
        if (this.checked) {
            // // console.log($(this).attr("data-js") + " - " + $(this).val() + " - " + $(this).parent().text().trim());
            data_js += $(this).attr("data-js") + " - " + $(this).val() + "%";
        }
    });
    $.ajax({
            type: 'POST',
            url: 'Server/Vendas/DisponibilizarConfiguracoes.php',
            data: data_js,
            statusCode: {
                404: function() {
                    exibirBoasVindas("Página não encontrada.<br />Por favor entre com contato com o suporte.");
                },
                500: function() {
                    exibirBoasVindas("Erro no servidor do sistema.<br />Por favor entre com contato com o suporte.");
                }
            }
        })
        .done(function(e) {
            if (e == 'true') {
                exibirBoasVindas("Configurações disponíveis para o vendedor.");
            } else {
                exibirBoasVindas("Não foi possível disponibilizar as configurações.");
            }
        });
}

/*
    ESSAS FUNÇÕES DEVERIAM SER COLOCADAS EM UMA BIBLIOTECA DE REUTILIZAÇÃO...
*/
function recuperarValorForm(id) {
    var elemento = $(id);
    var valor = elemento[0].value;
    return valor;
}

function recuperarValorFormRadio(name) { return $("input[name=" + name + "]:checked").val() || 0; }

function recuperarValorFormCheck(id) { return $(id).prop("checked") ? 1 : 0; }

function recuperarValorFormCheckMulti() {
    let higth = $('#especialConfigurarH').prop("checked");
    let low = $('#especialConfigurarL').prop("checked");

    if (higth)
        if (low)
            return 2;
        else
            return 1;
    else if (low)
        return 3;
    else
        return 0;
}


function recuperarValorFormSelect(id) {
    var valor = elemento.val();
    return valor;
}

function recuperarValorTelefone() {
    var listaTelefones = new Array();
    $('#selEmpFrmTelefone option').each(function() { listaTelefones.push(this.value) });

    return listaTelefones;
}
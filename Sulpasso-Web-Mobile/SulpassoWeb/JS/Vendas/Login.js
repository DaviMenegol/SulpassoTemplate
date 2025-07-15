$(document).ready(function() 
{
    $.ajax({
        type: 'POST',
        url: 'Server/Vendas/ListarEmpresas.php',
        data: 
        {
            user: $('#user').val(),
            pswd: $('#pswd').val()
        },
        statusCode: 
        {
            404: function() { alert("Page not found"); },
            500: function() { alert("Server internal error"); }
        }
    }).
    done(function(e) { carregarCombo(e); });


    $("#form-signin").on('submit', function() 
    {
        $.ajax({
            type: 'POST',
            url: 'Server/Vendas/Login.php',
            data: 
            {
                user: $('#inputUser').val(),
                pswd: $('#inputPassword').val(),
                empresa: $('#inputEmpresa').val()
            },
            statusCode: 
            {
                404: function() { alert("Page not found"); },
                500: function() { alert("Server internal error"); }
            }
        }).
        done(function(e) { onSuccess(e); });

        return false;
    });
});

function onSuccess(resultado) 
{
    if (resultado == "true"){
        window.location = 'Server/Vendas/TipoUsuario.php';
        //---------------------------------------------------------------------------//
        funcaoLembrar();
        //---------------------------------------------------------------------------//
    }
    else
        alert("Dados incorretos!\nPor favor verifique");
}

function carregarCombo(resultado) 
{
    var dadosJSON;
    try { dadosJSON = JSON.parse(resultado); } catch (e) { eval("dadosJSON = (" + resultado + ");"); }

    var posicao = dadosJSON.length;
    while (posicao--) 
    {
        var select = $("#inputEmpresa");

        select.append('<option value = \"' +
            dadosJSON[posicao].idEmpresa + '\">' + dadosJSON[posicao].nomeEmpresa + '</option>');
    }
//----------------------------------------------------------------//
funcaoGetLembrar();
//----------------------------------------------------------------//
}

function funcaoLembrar(){
var username = document.getElementById("inputUser").value;
        var empresa = document.getElementById("inputEmpresa").value;
        
        // Verificar se a opção "lembrar-me" está marcada
        var salvarSenha = document.getElementById("salvarSenha");
        if (salvarSenha.checked) {
            localStorage.setItem("username", username);
            localStorage.setItem("empresa", empresa);
            localStorage.setItem("salvarCheck", salvarSenha.value);
        }else{
        localStorage.removeItem("username");
        localStorage.removeItem("empresa");
        localStorage.removeItem("salvarCheck"); 
        }
}

function funcaoGetLembrar() {
var savedUsername = localStorage.getItem("username");
var savedEmpresa = localStorage.getItem("empresa");

var salvarSenha = localStorage.getItem("salvarCheck");
if (savedUsername && savedEmpresa) {
    document.getElementById("inputUser").value = savedUsername;
    document.getElementById("inputEmpresa").value = savedEmpresa;
    document.getElementById("salvarSenha").checked = salvarSenha;
    document.getElementById("inputPassword").focus();
}
}
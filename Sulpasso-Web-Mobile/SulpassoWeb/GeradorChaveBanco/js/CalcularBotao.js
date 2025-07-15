//CalcularBotao//
(function(){
    function cb(resultado) 
        {
        var dadosJSON;
        try { dadosJSON = JSON.parse(resultado); } catch (e) { alert("Erro no gerador! Contate o suporte Sulpasso")}
        if(dadosJSON["error"]){
            alert( dadosJSON["error"] );
            window.location = '../Vendas/Login.htm';
            return;
        }
            if(dadosJSON.indexOf(",") == -1){
                $("#chaveSupervisor").val(dadosJSON);
            }else{
            var array = dadosJSON.split(",");
            $("#preco").val(array[0]);
            $("#qtd").val(array[1]);
            $("#chaveSupervisor").val(array[2]);
            }
            // $.getScript("js/SalvarRequisicoes.js");
            $.getScript("js/CarregaHistorico.js");
        }

        

    document.querySelector("#btn").addEventListener("click",function(e) {
        e.preventDefault(); 
        if(valido())
        {
            document.getElementById("chaveVendedor").placeholder = document.getElementById("chaveVendedor").value
            
            $.ajax({
                type: 'POST',
                url: 'php/gerador.php',
                data: 
                {
                    idEmpresa: $('#idEmpresa').val(),
                    chave1: $('#chaveVendedor').val(),
                    idSupervisor: $('#idSupervisor').val(),
                    vendedores: $('#inputVendedores').val(),
                    modo: document.querySelector("input[type='checkbox']").checked
                },
                statusCode: 
                {
                    404: function() { alert("Page not found"); },
                    500: function() { alert("Server internal error"); }
                }
            }).
            done(function(e) {cb(e); });
            limpaCampos();
        }
        
    })

    function limpaCampos(){
        $("#chaveVendedor").val("");
        $("#qtd").val("");
        $("#preco").val("");
        $("#chaveVendedor").removeClass("verde");
        $("#inputVendedores").removeClass("verde");
    }
    function valido(){

        var modo = document.querySelector("input[type='checkbox']").checked;
        var chave = parseInt(document.getElementById("chaveVendedor").value);
        console.log(chave.length)
        //modo False: configurador
        //modo True: preço
          
        if(document.getElementById("chaveVendedor").value == ""){
            alert("Sem chave!");
            return false;
        }

        if(temLetra(document.getElementById("chaveVendedor").value)){
            alert("A chave deve ser composta apenas por números!");
            return false;   
        }

        if(modo){
            if(chave.length < 15 || chave < 1071914241  || chave.length > 32){
                alert("Chave Errada T! Verifique novamente...");
                return false;
            }
        }else{
            if(chave.length < 2 ||chave.length > 4 || chave < 10 || chave > 1009){
                alert("Chave Errada! Verifique novamente...");
                return false;
            }
        }
        
        return true;
    }

    function temLetra(str) {
        for (var i = 0; i < str.length; i++) {
            if (isNaN(parseInt(str[i])))
                return true
        }
        return false;
    }
})();
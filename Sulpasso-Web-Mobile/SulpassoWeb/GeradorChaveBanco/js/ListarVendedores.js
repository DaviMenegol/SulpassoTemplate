(function(){

    $.ajax({
        type: 'POST',
        url: 'php/listarVendedores.php',
        data: 
        {
            idEmpresa: $('#idEmpresa').val()
        },
        statusCode: 
        {
            404: function() { alert("Page not found"); },
            500: function() { alert("Server internal error"); }
        }
    }).
    done(function(e) {cb(e); });

    function cb(resultado) 
    {
        //caso o nome fique muito grande no select
        function fazCaber(nome){
            if (nome.length > 20){
                return nome.slice(0,18) + "...";
            }
            return nome;
        }
        //----------------------------------------

        var dadosJSON;
        try { dadosJSON = JSON.parse(resultado); } catch (e) { alert("Erro na conexão!");window.close();}
        if(dadosJSON["error"]){
            alert(dadosJSON["error"]);
            window.close();
            return;
        }
        var posicao = dadosJSON.length;
        while (posicao--) 
        {
            var select = $("#inputVendedores");
            select.append('<option value = \"' +
                dadosJSON[posicao].idUsuario + '\">' + fazCaber(dadosJSON[posicao].nomeUsuario) + '</option>');
        }
        $.getScript("js/CarregaHistorico.js");
        $.getScript("js/CalcularBotao.js");
        
    }
})();
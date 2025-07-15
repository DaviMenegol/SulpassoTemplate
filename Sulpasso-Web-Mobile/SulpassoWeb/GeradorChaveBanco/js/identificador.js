(function(){
$(document).ready(function() {
    
    function cb(resultado) 
    {

        var dadosJSON;
        try { dadosJSON = JSON.parse(resultado); } catch (e) {alert(e); };

        if(dadosJSON["cod_user"]){
        $("#idSupervisor").val(dadosJSON["cod_user"]);
        $("#idEmpresa").val(dadosJSON["emp_user"]);
        $.getScript("js/ListarVendedores.js");
        
        }else{
        alert( dadosJSON["error"] );
        window.location = '../Vendas/Login.htm';
        }
        
    }

    $.ajax({
        method: 'GET',
        url: 'php/identificador.php',
        statusCode: {
            404: function() { alert("Página não encontrada"); },
            500: function() { alert("Erro interno do servidor"); }
        }
    }).done(function(e) {cb(e); });
    
});

})();


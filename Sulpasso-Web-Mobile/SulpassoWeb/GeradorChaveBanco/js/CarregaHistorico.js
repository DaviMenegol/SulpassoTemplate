//CarregaHistorico
(function(){
    $.ajax({
        type: 'POST',
        url: 'php/CarregaHistorico.php',
        data: 
        {
            idEmpresa: $('#idEmpresa').val(),
            idSupervisor: $('#idSupervisor').val()
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
    
    var dadosJSON;
    try { dadosJSON = JSON.parse(resultado); } catch (e) { eval("dadosJSON = (" + resultado + ");"); }

    if(dadosJSON["error"]){
        $(".requisicaoHistorico").append(`<tr><td colspan="7" class="aviso"style="text-align: center;"><b>${dadosJSON["error"]}</b></td></tr>`)
        return;
    }
    var posicao = dadosJSON.length;
    if(posicao > 4 && window.innerWidth > 768){
        document.querySelector(".container2").style.height = "300px";
        document.querySelector(".requisicaoHistorico").style.width = "688px";
    }
    var select = $(".requisicaoHistorico");
    select.empty();

    while (--posicao >= 0) 
    {
        
        var chave_recebida = dadosJSON[posicao].chave_recebida;
        var vendedor = formatVendedores(dadosJSON[posicao].vendedor);
        var chave_resultante = dadosJSON[posicao].chave_resultante;
        var quantidade = ((dadosJSON[posicao].quantidade) > 0) ? "" + dadosJSON[posicao].quantidade : "";
        var valor = ((dadosJSON[posicao].valor) > 0) ? "" + dadosJSON[posicao].valor : "";

        var row;
        if(valor == "" || quantidade == ""){
        row = `
        <tr id="config"><td rowspan="2" class="baseGray">${posicao+1}</td>
        <td colspan="3">C:${chave_recebida}</td>
        <td>V:${vendedor}</td>
        </tr><tr id="config">
        <td colspan="3"><ins>S:${chave_resultante}</ins></td>
        <td>${dadosJSON[posicao].data_hora.split(" ")[1]}</td></tr>
        <tr id="space"><td colspan="5"></td></tr>`
        }
        if(chave_resultante == "ERROR"){
            row = `
            <tr id="error"><td rowspan="2" class="baseRed">${posicao+1}</td>
            <td colspan="3">C:${chave_recebida}</td>
            <td>V:${vendedor}</td>
            </tr><tr id="error">
            <td colspan="3"><ins>Chave enviada incorreta!</ins></td>
            <td>${dadosJSON[posicao].data_hora.split(" ")[1]}</td></tr>
            <tr id="space"><td colspan="5"></td></tr>`
        }
        if((valor != "" && quantidade != "")){
        row = `
        <tr><td rowspan="2" class="baseBlue">${posicao+1}</td>
        <td colspan="3">C:${chave_recebida}</td>
        <td>V:${vendedor}</td>
        </tr><tr>
        <td><ins>S:${chave_resultante}</ins></td>
        <td>Q:${parseFloat(quantidade).toFixed(3)}</td>
        <td>P:${valor}</td>
        <td>${dadosJSON[posicao].data_hora.split(" ")[1]}   </td></tr>
        <tr id="space"><td colspan="5"></td></tr>`
        }
        
        select.append(row);
    }
    
    document.querySelector("#inputVendedores").value = 0;
}
    function formatVendedores(idVendedor){
        var vendedorSelect = document.querySelector("#inputVendedores");
        
        var vendedor = vendedorSelect.options[idVendedor].textContent;
        if(vendedor == "Vendedor"){vendedor = " ~ ";}
        return vendedor
    }

})();
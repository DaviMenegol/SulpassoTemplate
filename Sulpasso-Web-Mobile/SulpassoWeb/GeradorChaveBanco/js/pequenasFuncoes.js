(function(){
    document.getElementById("execCopy").addEventListener("click", function (e) {
        e.preventDefault();
        document.querySelector("#chaveSupervisor").select();
        document.execCommand("copy");
    });
    document.getElementById("chaveVendedor").addEventListener("input", function (e) {
    
        if(!document.querySelector("input[type = checkbox]").checked){
            if(e.target.value.length > 2 &&  e.target.value.length < 5){
            $("#chaveVendedor").addClass("verde");
            }else{
            if ($("#chaveVendedor").hasClass("verde")){
                $("#chaveVendedor").removeClass("verde");
            }
            }
        }else{
            if(e.target.value.length >= 15 && e.target.value.length <= 31){
            $("#chaveVendedor").addClass("verde");
            }else{
            if ($("#chaveVendedor").hasClass("verde")){
                $("#chaveVendedor").removeClass("verde");
            }
            }
        }
    });
    document.getElementById("inputVendedores").addEventListener("change", function (e) {
        if(e.target.value != 0){
            $("#inputVendedores").addClass("verde");
        }else{
            if ($("#inputVendedores").hasClass("verde")){
                $("#inputVendedores").removeClass("verde");
            }
        }
    });
    document.querySelector("input[type = checkbox]").addEventListener("change",function (e) {
        if(e.target.checked){
            document.querySelector("h2").textContent = "GERADOR SENHA PREÇOS";
            document.querySelector("h2").style.color = "rgb(51, 122, 183)";
        }else{
            document.querySelector("h2").textContent = "GERADOR SENHA CONFIGURADOR";
            document.querySelector("h2").style.color = "rgb(107, 107, 107)";
        }
        if ($("#chaveVendedor").hasClass("verde")){
                $("#chaveVendedor").removeClass("verde");
            }
        document.querySelector("#qtdpreco").classList.toggle("hide");
    })
})();
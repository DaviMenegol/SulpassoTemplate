
// (function(){
//     var qtd = $("#qtd").val();
//     var valor = $("#preco").val();
//     var chaveVendedor = $("#chaveVendedor").val();
//     var chaveResult = $("#chaveSupervisor").val();

//     // Salva "~" quando vendedor não fora selecionado//
//     var vendedorSelect = document.querySelector("#inputVendedores");
//     var vendedor = vendedorSelect.options[vendedorSelect.selectedIndex].textContent;
//     if(vendedor == "Vendedor"){vendedor = " ~ ";}
//     //---------------------------------------------//

//     function pegaUltimoIndice(){
//         if(document.querySelector("td").classList.contains("aviso")){
//             document.querySelector("td").parentElement.remove();
//             return 1;
//         }else{
//         return (parseInt(document.querySelector("td").textContent)+1);
//         }
//     }
// var indice = pegaUltimoIndice();
// if(indice > 11){
//     $(".requisicaoHistorico").removeClass("table1");
// }
// var currentDate = new Date();
// function formatar(fracaoData){
//     return fracaoData.toString().padStart(2, '0');
// }
// var formattedDate =`${formatar(currentDate.getHours())}:${formatar(currentDate.getMinutes())}:${formatar(currentDate.getSeconds())}`;
// var tabela = document.querySelector(".requisicaoHistorico");
// var filho = document.createElement("div")
// filho.id = `${indice}`

// if (!document.querySelector("input[type='checkbox']").checked){
//     filho.innerHTML = `
//         <tr id="config"><td rowspan="2" class="baseGray">${indice}</td>
//         <td colspan="3">C:${chaveVendedor}</td>
//         <td>V:${vendedor}</td>
//         </tr><tr id="config">
//         <td colspan="3"><ins>S:${chaveResult}</ins></td>
//         <td>${formattedDate}</td></tr>
//         <tr id="space"><td colspan="5"></td></tr>`
// }else{
//     filho.innerHTML = `
//         <tr><td rowspan="2" class="baseBlue">${indice}</td>
//         <td colspan="3">C:${chaveVendedor}</td>
//         <td>V:${vendedor}</td>
//         </tr><tr>
//         <td><ins>S:${chaveResult}</ins></td>
//         <td>Q:${qtd}</td>
//         <td>P:${valor}</td>
//         <td>${formattedDate}   </td></tr>
//         <tr id="space"><td colspan="5"></td></tr>`
// }
// console.log(filho.innerHTML);

// tabela.insertAdjacentElement(`afterbegin`,filho);

// $("#chaveVendedor").val("");
// $("#chaveVendedor").removeClass("verde");
// $("#inputVendedores").removeClass("verde");
// document.querySelector("#inputVendedores").value = 0;
// })();
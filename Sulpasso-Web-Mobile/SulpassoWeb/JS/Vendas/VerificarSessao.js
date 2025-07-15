$.ajax(
{
    type :'POST',
    url : 'Server/Vendas/VerificaSessao.php',
    statusCode :
    {
        404 : function()
        {
            alert("Pagina não encontrada");
            window.location = 'Vendas/Login.htm';
        },
        500 : function()
        {
            alert("Server internal error");
            window.location = 'Vendas/Login.htm';
        }
    }
}).done(function(e)
{
    if(e == "TRUE") { }
    else { window.location = 'Vendas/Login.htm';}
});
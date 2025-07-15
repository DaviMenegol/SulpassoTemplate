$(document).ready(function()
{

    
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });

    $('.ocultar').hide();
    // Add smooth scrolling to all links in navbar + footer link
    $(".navbar a, footer a[href='#myPage']").on('click', function(event) 
    {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") 
        {
            // Prevent default anchor click behavior
            event.preventDefault();
            
            // Store hash
            var hash = this.hash;
            
            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
                }, 900, function(){
                
                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });
    
    $(window).scroll(function() 
    {
        $(".slideanim").each(function()
        {
            var pos = $(this).offset().top;
            
            var winTop = $(window).scrollTop();

            if (pos < winTop + 600)  { $(this).addClass("slide"); }
        });
    });
    
    $('.avancado').hover(exibirDica, ocultarDica);
    
    $(function($){ $('[placeholder="00/00/0000"]').mask("99/99/9999",{placeholder:"00/00/00"}); }); 
    
    // Use a closure to keep vars out of global scope
    /*
    var ID = "tooltip"; // The ID of the styleable tooltip
    var CLS_ON = "tooltip_ON"; // Does not matter, make it somewhat unique
    var FOLLOW = true; // TRUE to enable mouse following, FALSE to have static tooltips
    var DATA = "_tooltip"; // Does not matter, make it somewhat unique
    var OFFSET_X = 20, OFFSET_Y = 10; // Tooltip's distance to the cursor
    */
    (function () 
    {
        var ID = "tooltip", CLS_ON = "tooltip_ON", FOLLOW = true,
        DATA = "_tooltip", OFFSET_X = 20, OFFSET_Y = 10,
        showAt = function (e) 
        {
            var ntop = e.pageY + OFFSET_Y, nleft = e.pageX + OFFSET_X;
            $("#" + ID).html($(e.target).data(DATA)).css({
                position: "absolute", top: ntop, left: nleft
            }).show();
        };
        $(document).on("mouseenter", "*[title]", function (e) 
        {
            $(this).data(DATA, $(this).attr("title"));
            $(this).removeAttr("title").addClass(CLS_ON);
            $("<div id='" + ID + "' />").appendTo("body");
            showAt(e);
        });
        $(document).on("mouseleave", "." + CLS_ON, function (e) 
        {
            $(this).attr("title", $(this).data(DATA)).removeClass(CLS_ON);
            $("#" + ID).remove();
        });
        if (FOLLOW) { $(document).on("mousemove", "." + CLS_ON, showAt); }
    }());

    function onsuccess(response,status)
    {
        $("#onsuccessmsg").html("<b>Status :</b>"+status+
            '<br><br><b>Resposta :</b><div id="msg" style="padding:15px;">'+response+'</div>');
    }
        
    // We can attach the `fileselect` event to all file inputs on the page
    $(document).on('change', ':file', function() 
    {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });
    
    $("#uploadform").on('submit',function()
    {
        var options=
        {
            url     : $(this).attr("action"),
            success : onsuccess
        };
        $(this).ajaxSubmit(options);
        return false;
    });
    
    $(':file').on('fileselect', function(event, numFiles, label) 
    {
        var input = $(this).parents('.input-group').find(':text'),
        log = numFiles > 1 ? numFiles + ' files selected' : label;
        
        if( input.length ) { input.val(log); } 
        else { if( log ) alert(log); }
    });
    
    $('#manager-executar-arquivos').bind('click', executarArquivos);

    $('a[href=""][value="sair"]').bind('click', function()
    { 
        location.href="server/controlers/logout.php"; 
    });
    //MAGICA!
    // $('#first li a, #second li a, #third li a, #fourth li a').on("click", function(event)
    // {
    //     excluirBoasVindas();

    //     switch(event.target.id)
    //     {
    //         case 'cadastroUsuarios' :
    //             $('#cadastrar-usuarios').slideDown(2000);
    //             break;
    //         default :
    //             $('.ocultar').fadeOut(1000);
    //             break;
    //     }
    // });
});
/*END OF $(document).ready*/

function exibirDica()
{
    $('.tollTipe').show();
}

function ocultarDica()
{
    $('.tollTipe').hide();
}

function executarArquivos()
{
    alert("Clicado em executar");
    $( "#load-bar" ).show();
    
    $.ajax(
    {
        type :'POST',
        url : '../server/controlers/txt_abrir.php',
        statusCode :
        {
            404 : function()
            {
                alert("Pagina n�o encontrada");
                $( "#load-bar" ).hide();
            },
            500 : function()
            {
                alert("Erro interno do servidor");
                $( "#load-bar" ).hide();
            }
        }
    }).done(function(e)
    {
        exibirResultado(e);
    });
}

function exibirResultado(e)
{
    $('#onsuccessexecutar').html('' + e);
    
    $( "#load-bar" ).hide();
}
function createAlert(text, classe)
{
    $('.dataReturn').
        html('<div class = "alert ' + classe + 
        '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + text + '</div>').show();
    
}
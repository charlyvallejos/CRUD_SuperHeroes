//Constantes
var READY_STATE_COMPLETE = 4;
var STATUS_OK = 200;

//Variables
var btnInsertar = document.querySelector("#insertar"),
    precarga = document.querySelector("#precarga"),
    respuesta = document.querySelector("#respuesta"),
    ajax = null;
    
//Funciones  
function objetoAJAX()
{
    if(window.XMLHttpRequest)
        return new XMLHttpRequest();
    else if (window.ActiveXObject)
        return new ActiveXObject('Microsoft.XMLHTTP');
}

function datosRecibidos()
{
    precarga.style.display = "block";
    precarga.innerHTML = "<img src='img/loader.gif' />";
    if (ajax.readyState == READY_STATE_COMPLETE)
    {
        if(ajax.status == STATUS_OK)
        {            
            precarga.style.display = 'none';
            respuesta.style.display = 'block';
            respuesta.innerHTML = ajax.responseText;
            
            if(ajax.responseText.indexOf('data-insertar') > -1)
                document.querySelector('#alta-heroe').addEventListener('submit', insertarHeroe);
            if(ajax.responseText.indexOf('data-recargar') > -1)
                setTimeout(window.location.reload(),5000);
        }
        else
        {
            alert('El servidor no contestó\nError '+ ajax.status + ': ' + ajax.statusText);
        }
    }
}

function ejecutarAJAX(datos)
{
    ajax = objetoAJAX();
    
    ajax.open('POST','controlador.php',true);
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send(datos);
    ajax.onreadystatechange = datosRecibidos;        
}

function insertarHeroe(evento)
{
    evento.preventDefault();
    
    var nombre = new Array(),
        valor = new Array(),
        datos = "";

    for($i=1; $i <= evento.target.length; $i++)
    {
        nombre[i] = evento.target[i].name;
        valor[i] = evento.target[i].value;
        
        datos += nombre[i] + '=' + valor[i] + '&'; 
    }
    
    ejecutarAJAX(datos);    
}

function altaHeroe(evento)
{
    evento.preventDefault();   
    var datos = "transaccion=alta";
    
    ejecutarAJAX(datos);
    
    //alert("alta usuario");
}

function alCargarDocumento()
{
    btnInsertar.addEventListener("click", altaHeroe);
}
window.addEventListener("load",alCargarDocumento);    


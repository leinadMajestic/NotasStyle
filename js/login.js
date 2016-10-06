var url="http://localhost/NotasStyle/";
/**FUNCIÓN PARA ACTIVAR AJAX NATIVO**/
function nuevoAjax(){
	var xmlhttp=false;
 	try {
 		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 	} catch (e) {
 		try {
 			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 		} catch (E) {
 			xmlhttp = false;
 		}
  	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
 		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
/**END FUNCIÓN PARA ACTIVAR AJAX NATIVO**/

$(document).ready(function(){
    $("#enviar").click(function(){
        var user = $("#username").val();
        var pass = $("#password").val();

        loguear(user, pass);
    });
});

function loguear(user, pass){		
	ajax=nuevoAjax();
	ajax.open("POST", url+"ajax/login.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState<4) {
		}
		else{
			console.log(ajax.responseText)
			if(ajax.responseText == 1){//logueado correctamente
				$(location).attr('href',url+"inicio.html")
			}
			else{//problemas para loguear
				location.reload();
			}
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("func=login&usuario="+user+"&clave="+pass)
}
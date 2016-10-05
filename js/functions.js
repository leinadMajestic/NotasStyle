var url="http://localhost/StyleNotas/";
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
function save(id){		
	var nota = $("#nota").val();
	var valor = $("#"+id).val();
	var res = id.split("_");
	var send = "&nota="+nota+"&valor="+valor+"&campo="+res[0]

	send += res[1] != undefined ? "&pos="+res[1]+"&func=item" : (id == "comentarios" ? "&func=comentarios" : "&func=cliente")
	ajax=nuevoAjax();
	ajax.open("POST", url+"ajax/save.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState<4) {
		}
		else{
			if(ajax.responseText == 1){
				
			}
			else{
				
			}
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send(send)
}
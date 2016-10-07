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

/**FUNCIÓN PARA ENVIAR POR AJAX, TODO LO NECESARIO PARA ALMACENAR LA INFORMACION DE LA NOTA**/
function save(id){		
	var nota = $("#nota").val();
	var valor = $("#"+id).val();
	var res = id.split("_");
	var send = "&nota="+nota+"&valor="+valor+"&campo="+res[0]

	send += res[1] != undefined ? "&pos="+res[1]+"&func=item" : (id == "comentarios" ? "&func=comentarios" : "&func=cliente");
	ajax=nuevoAjax();
	ajax.open("POST", url+"ajax/save.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState<4) {
		}
		else{
			showCostos(ajax.responseText);
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send(send)
}
/**END FUNCIÓN PARA ENVIAR POR AJAX, TODO LO NECESARIO PARA ALMACENAR LA INFORMACION DE LA NOTA**/

/**FUNCIÓN CREADA PARA ENVIAR POR AJAX SI LLEVA FACTURA O NO**/
function saveFactura(valor, nota){
	ajax=nuevoAjax();
	ajax.open("POST", url+"ajax/save.php", true);
	ajax.onreadystatechange=function(){}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("func=factura&valor="+valor+"&nota="+nota);
}
/**END FUNCIÓN CREADA PARA ENVIAR POR AJAX SI LLEVA FACTURA O NO**/

/**FUNCIÓN CREADA PARA ENVIAR POR AJAX EL ESTATUS QUE TIENE**/
function saveEstatus(valor, nota){
	ajax=nuevoAjax();
	ajax.open("POST", url+"ajax/save.php", true);
	ajax.onreadystatechange=function(){}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("func=estatus&valor="+valor+"&nota="+nota);
}
/**END FUNCIÓN CREADA PARA ENVIAR POR AJAX EL ESTATUS QUE TIENE**/

/**FUNCIÓN PARA IMPRIMIR EN PANTALLA EL TOTAL DE LOS COSTOS DE LA NOTA ACTIVA**/
function showCostos(numero){
	var numeros = (numero).split("::");
	
	$("#Subtotal").val("$"+numeros[1]);
	$("#IVA").val("$"+numeros[0]);
	$("#Total").val("$"+numeros[2]);
}
/**END FUNCIÓN PARA IMPRIMIR EN PANTALLA EL TOTAL DE LOS COSTOS DE LA NOTA ACTIVA**/

/**FUNCION PARA MOSTRAR EL VALOR CON FORMATO NUMERICO**/
function number_format(number, decimals, dec_point, thousands_sep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number, prec = !isFinite(+decimals) ? 0 : Math.abs(decimals), sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep, dec = (typeof dec_point === 'undefined') ? '.' : dec_point, s = '', toFixedFix = function(n, prec) {
			var k = Math.pow(10, prec);
			return '' + (Math.round(n * k) / k).toFixed(prec);
	};
	// Fix for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
}
/**END FUNCION PARA MOSTRAR EL VALOR CON FORMATO NUMERICO**/

/**FUNCION QUE DEVUELVE EL LINK DE LAS OPCIONES DEL MENÚ**/
function getLinks(id){
	var links = new Array();
	links['addNota'] 	= "crear-notas.html";
	links['buscar'] 	= "buscar-notas.html";
	links['vActivas'] 	= "ver-notas-activas.html";
	links['vEntregadas']= "ver-notas-entregadas.html";
	links['vPagadas'] 	= "ver-notas-pagadas.html";
	links['corte'] 		= "ver-notas-al-corte.html";
	links['cerrarSesion']= "cerrar-sesion.html";

	return links[id];

}
/**END FUNCION QUE DEVUELVE EL LINK DE LAS OPCIONES DEL MENÚ**/
$(document).ready(function(){
    $(".radiobutton").click(function(){
        var valor = $(this).val();
        var nota = $("#nota").val();
        saveFactura(valor, nota);
    });
    $("#estatus").change(function(){
    	var valor = $("#estatus").val();
    	var nota = $("#nota").val();
    	saveEstatus(valor, nota);
    });
    $(".submenu").click(function(){
    	var link = getLinks($(this).attr("id"));
    	$(location).attr('href',url+link);
    });
});
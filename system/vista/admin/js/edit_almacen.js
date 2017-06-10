// JavaScript Document


$(document).ready(function(){
$('#telefono').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');});
	$('#movil').keyup(function () { this.value = this.value.replace(/[^0-9]/g,'');});

});

function borrararch(){
	$("#delimg").val('1');
}

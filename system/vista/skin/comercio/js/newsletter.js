// JavaScript Document   
function enviarN() {
	if(jQuery("#nForm").valid())
	{
        jQuery.post('suscriptor-newsletter',jQuery('#nForm').serialize()
					  ,
      function(data){
		
		    jQuery('#nForm').css("display", "none") ;
			jQuery('#cancels').css("display", "none") ;
			 jQuery('#msjn').html(data);		
 	 }
	  );
	}

}

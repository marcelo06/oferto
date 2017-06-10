function validar_imagen(form, campo)
{
	dat = jQuery("#"+campo).val();
	jQuery('#errorimg').html('');
	dat = dat.toLowerCase();
	if(dat != '')
	{
		if ((dat.indexOf("jpg") == -1)  && (dat.indexOf("gif") == -1) && (dat.indexOf("png") == -1))	
		{
			$('#archivo').validationEngine('showAlert', 'Debe ser un archivo de imagen (jpg, gif, png)', 'load') ;
			return false;
		}
	}else
		return false;
	f = eval('document.'+form);
	f.submit();
}


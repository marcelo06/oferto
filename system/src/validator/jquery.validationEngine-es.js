
(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText": "* Este campo está requerido",
                    "alertTextCheckboxMultiple": "* Por favor selecciona una opción",
                    "alertTextCheckboxe": "* Este checkbox está requerido"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* Mínimo de ",
                    "alertText2": " caracteres autorizados"
                },
                "maxSize": {
                    "regex": "none",
                    "alertText": "* Máximo de ",
                    "alertText2": " caracteres autorizados"
                },
		        "min": {
                    "regex": "none",
                    "alertText": "* Valor mínimo es "
                },
                "max": {
                    "regex": "none",
                    "alertText": "* Valor máximo es "
                },
		        "past": {
                    "regex": "none",
                    "alertText": "* Fecha anterior a "
                },
                "future": {
                    "regex": "none",
                    "alertText": "* Fecha posterior a "
                },	
                "maxCheckbox": {
                    "regex": "none",
                    "alertText": "* Se ha excedido el número de opciones permitidas"
                },
                "minCheckbox": {
                    "regex": "none",
                    "alertText": "* Por favor seleccione ",
                    "alertText2": " opciones"
                },
                "equals": {
                    "regex": "none",
                    "alertText": "* Los campos no coinciden"
                },
                "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "alertText": "* Número de teléfono inválido"
                },
				"precios":{
						"regex":"/^[0-9\ \.]+$/",
						"alertText":"* Unicamente números"
				},
                "email": {
                    // Shamelessly lifted from Scott Gonzalez via the Bassistance Validation plugin http://projects.scottsplayground.com/email_address_validation/
                    "regex": /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/,
                    "alertText": "* Correo inválido"
                },
                "integer": {
                    "regex": /^[\-\+]?\d+$/,
                    "alertText": "* No es un valor entero válido"
                },
                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\-\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* No es un valor decimal válido"
                },
                "date": {
                    "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/,
                    "alertText": "* Fecha inválida, por favor utilize el formato AAAA-MM-DD"
                },
                "ipv4": {
                	"regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                    "alertText": "* Direccion IP inválida"
                },
                "url": {
                    "regex": /^http\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?$/,
                    "alertText": "* URL Inválida"
                },
				"dominio": {
                    "regex": /^([a-zA-Z0-9][-a-zA-Z0-9]*[a-zA-Z0-9]\.)+([a-zA-Z0-9]{3,5})$/,
                    "alertText": "* Dominio Inválido"
                },
                "onlyNumberSp": {
                    "regex": /^[0-9\ ]+$/,
                    "alertText": "* Sólo números"
                },
			    "onlyLetterSp": {
                    "regex": /^[a-zA-Z\ \']+$/,
                    "alertText": "* Sólo letras"
                },
                "onlyLetterNumber": {
                    "regex": /^[0-9a-zA-Z]+$/,
                    "alertText": "* No se permiten caracteres especiales"
                },
				"onlyImg": {
                    "regex": /(.*?)\.(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/,
                    "alertText": "* Solo se permiten imágenes jpg, gif, png"
                },
				"onlyDoc": {
                    "regex": /(.*?)\.(doc|docx|xls|xlsx|pdf|zip|tar|DOC|DOCX|XLS|XLSX|PDF|ZIP|TAR)$/,
                    "alertText": "* Solo se permiten archivos doc, docx, xls, xlsx, pdf, zip, tar"
                },
				// --- CUSTOM RULES -- Those are specific to the demos, they can be removed or changed to your likings
                "ajaxValEmail": {
                    "url":"usuario-validar",
					"extraData":"",
					"alertTextOk":"* Correo Electrónico Disponible ",	
					"alertTextLoad":"* Cargando, por favor espere",
					"alertText":"* Este e-mail ya está registrado"
				},	
				"ajaxValEmailConfig": {
                    "url":"usuario-validarxid",
					"extraData":"",
					"alertTextOk":"* Correo Electrónico Válido ",	
					"alertTextLoad":"* Cargando, por favor espere",
					"alertText":"* Este e-mail ya está registrado"
				},	
				"ajaxSubdominio": {
                    "url":"empresa-validar_subdominio",
					"extraData":"",
					"alertTextOk":"* Subdominio Válido ",	
					"alertTextLoad":"* Cargando, por favor espere",
					"alertText":"* Subdominio ya está registrado"
				},	
				"ajaxDominio": {
                    "url":"empresa-validar_dominio",
					"extraData":"",
					"alertTextOk":"* Dominio Válido ",	
					"alertTextLoad":"* Cargando, por favor espere",
					"alertText":"* Dominio ya está registrado"
				},	
                "ajaxNameCall": {
					// remote json service location
                    "url": "ajaxValidateFieldName",
					// error
                    "alertText": "* Este nombre ya se encuentra usado",
					// if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* Este nombre está disponible",
					// speaks by itself
                    "alertTextLoad": "* Cargando, espere por favor"
                },
                "validate2fields": {
                    "alertText": "* Por favor entrar HELLO"
                }
            };
            
        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);
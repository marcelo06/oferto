<?php

/**
 * Plugin Libreria

 * @package		plugin
 *
 *
 * @author		Julian Vega <julian@rhiss.net>
 * @since		14.05.11
 */


class  plugin
{
	/**
	 * Carga el plugin de grid
	 *
	 * @return	void
	 * @param	void
	 */
	public static function jqgrid()
	{
		return '
<link rel="stylesheet" type="text/css" media="screen" href="'.URLBASE.'system/src/jqgrid/themes/redmond/jquery-ui-1.7.1.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="'.URLBASE.'system/src/jqgrid/css/ui.jqgrid.css" />
<script src="'.URLBASE.'system/src/jqgrid/js/i18n/grid.locale-es.js" type="text/javascript"></script>
<script  src="'.URLBASE.'system/src/jqgrid/js/jquery.jqGrid.min.js"></script>';
    }

	/**
	 * Carga el plugin de validation
	 *
	 * @return	void
	 * @param	void
	 */
	public static function validation()
	{
		return '
<script src="'.URLBASE.'system/src/validator/jquery.validationEngine-es.js" type="text/javascript"></script>
<script src="'.URLBASE.'system/src/validator/jquery.validationEngine.js" type="text/javascript"></script>
<link href="'.URLBASE.'system/src/validator/validationEngine.jquery.css" rel="stylesheet" type="text/css" />';
    }

	/**
	 * Carga el plugin de Fancybox
	 *
	 * @return	void
	 * @param	void
	 */
	public static function fancybox()
	{
		return '
<script type="text/javascript" language="javascript" src="'.URLBASE.'system/src/fancybox/jquery.fancybox.js"> </script>
<link href="'.URLBASE.'system/src/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />';
    }

	/**
	 * Carga el plugin de Fancybox
	 *
	 * @return	void
	 * @param	void
	 */
	public static function fancybox_2_1()
	{
		return '

  <!-- Add mousewheel plugin (this is optional) -->
  <script type="text/javascript" src="'.URLSRC.'fancybox-2.1/lib/jquery.mousewheel-3.0.6.pack.js"></script>

  <!-- Add fancyBox main JS and CSS files -->
  <script type="text/javascript" src="'.URLSRC.'fancybox-2.1/source/jquery.fancybox.js?v=2.1.3"></script>
  <link rel="stylesheet" type="text/css" href="'.URLSRC.'fancybox-2.1/source/jquery.fancybox.css?v=2.1.2" media="screen" />

  <!-- Add Thumbnail helper (this is optional) -->
  <link rel="stylesheet" type="text/css" href="'.URLSRC.'fancybox-2.1/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
  <script type="text/javascript" src="'.URLSRC.'fancybox-2.1/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
';
    }

	/**
	 * Carga el plugin de formatear_precio
	 *
	 * @return	void
	 * @param	void
	 */
	public static function formatear_precio()
	{
		return '
<script language="javascript" type="text/javascript" src="'.URLBASE.'system/src/js/jquery.price_format.js" ></script>';
    }


	/**
	 * Carga el plugin de Jquery
	 *
	 * @return	void
	 * @param	void
	 */
	public static function jquery()
	{
		return '
<script language="javascript" type="text/javascript" src="'.URLSRC.'js/jquery.js" ></script>';
    }

	/**
	 * Carga el plugin de Localidades
	 *
	 * @return	void
	 * @param	void
	 */
	public static function localidades()
	{
		return '
<script type="text/javascript" language="javascript" src="'.URLBASE.'system/src/js/localidades.js"> </script>';
    }


	/**
	 * Carga el plugin de galeria
	 *
	 * @return	void
	 * @param	void
	 */
	public static function galeria()
	{
		return '
<link rel="stylesheet" href="'.URLBASE.'system/vista/skin/panorama/css/slid-Gallery.css" />
<script type="text/javascript" src="'.URLBASE.'system/vista/skin/panorama/js/jquery.aw-showcase.js"></script>
<script type="text/javascript" src="'.URLBASE.'system/vista/skin/panorama/js/show-script.js"></script>';
    }

	/**
	 * Carga el plugin del ckeditor
	 *
	 * @return	void
	 * @param	void
	 */
	public static function ckeditor()
	{
		return '
<script type="text/javascript" src="'.URLBASE.'system/src/ckeditor/ckeditor.js"></script>';
    }


	public static function uploadify()
	{
		return '
<link href="'.URLBASE.'system/src/uploadify/default.css" rel="stylesheet" type="text/css" />
<link href="'.URLBASE.'system/src/uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="'.URLBASE.'system/src/uploadify/jquery.uploadify-3.1.js?id=2344"></script>
<script type="text/javascript" src="'.URLBASE.'system/src/uploadify/main.js"></script>';
    }




	/**
	 * Carga el plugin del calendar
	 *
	 * @return	void
	 * @param	void
	 */
	public static function calendar()
	{
		return '
<link rel="stylesheet" type="text/css" media="all" href="'.URLBASE.'system/src/calendar/calendar-blue.css" title="win2k-cold-1" />
<script type="text/javascript" src="'.URLBASE.'system/src/calendar/calendar.js"></script>
<script type="text/javascript" src="'.URLBASE.'system/src/calendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="'.URLBASE.'system/src/calendar/calendar-setup.js"></script>';
    }


	/**
	 * Carga el plugin del datepicker (calendario)
	 *
	 * @return	void
	 * @param	void
	 */

	public static function datepicker()
	{
		return '
<link rel="stylesheet" href="'.URLBASE.'system/src/datepicker/themes/base/jquery.ui.all.css">
	<script src="'.URLBASE.'system/src/datepicker/ui/jquery.ui.core.js"></script>
	<script src="'.URLBASE.'system/src/datepicker/ui/i18n/jquery.ui.datepicker-es.js"></script>
	<script src="'.URLBASE.'system/src/datepicker/ui/jquery.ui.widget.js"></script>
	<script src="'.URLBASE.'system/src/datepicker/ui/jquery.ui.datepicker.js"></script>';
    }


	/**

	 * Carga el plugin de los mensajes de estado
	 *
	 * @return	void
	 * @param	void
	 */
	public static function message()
	{
		return '
<link rel="stylesheet" type="text/css" media="all" href="'.URLBASE.'system/src/message/css/jquery.toastmessage.css" title="win2k-cold-1" />
<script type="text/javascript" src="'.URLBASE.'system/src/message/jquery.toastmessage.js"></script>';
    }



}

?>
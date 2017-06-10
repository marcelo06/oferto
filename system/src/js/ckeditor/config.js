/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'es';
	// config.uiColor = '#AADC6E';

	config.toolbar = 'Basico';
	config.allowedContent = true;
	config.extraPlugins = 'youtube,mediaembed';






	config.toolbar_Full =
	[
		['Source','-','Save','NewPage','Preview','-','Templates'],
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
		'/',
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Link','Unlink','Anchor'],
		['Image','Flash','Youtube','MediaEmbed','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
		'/',
		['Styles','Format','Font','FontSize'],
		['TextColor','BGColor'],
		['Maximize', 'ShowBlocks','-','About']
	];

	config.toolbar_Basico =
	[
		['Source','-','Save','NewPage','Preview'],
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'Scayt'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		'/',
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Link','Unlink'],
		['Image','Flash','Youtube','MediaEmbed','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
		'/',
		['Styles','Format','Font','FontSize'],
		['TextColor','BGColor'],
		['Maximize']
	];

	config.toolbar_Minimo =
	[
		['Cut','Copy','Paste','PasteText','PasteFromWord'],
		['Bold','Italic','Underline'],['Link','Unlink'],
		['Image','Flash','Youtube','MediaEmbed','Table'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','FontSize']
	];

 config.filebrowserBrowseUrl = 'system/src/kcfinder/browse.php?type=files';
   config.filebrowserImageBrowseUrl = 'system/src/kcfinder/browse.php?type=images';
   config.filebrowserFlashBrowseUrl = 'system/src/kcfinder/browse.php?type=flash';
   config.filebrowserUploadUrl = 'system/src/kcfinder/upload.php?type=files';
   config.filebrowserImageUploadUrl = 'system/src/kcfinder/upload.php?type=images';
   config.filebrowserFlashUploadUrl = 'system/src/kcfinder/upload.php?type=flash';
};

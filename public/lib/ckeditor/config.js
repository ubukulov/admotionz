/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'ru';
	config.allowedContent = true;
	//config.uiColor = '#AADC6E';
	config.extraPlugins = 'youtube';
	config.toolbar = [
		{ name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
		{ name: 'editing', items: ['Scayt']},
		{ name: 'links', items: ['Link', 'Unlink', 'Anchor']},
		{ name: 'insert', items: ['Image', 'Youtube', 'Table', 'HorizontalRule', 'SpecialChar','Iframe','Flash','PageBreak']},
		{ name: 'tools', items: ['Maximize']},
		{ name: 'document', items: ['Source']},
		{ name: 'basicstyles', items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']},
		
		{ name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent','-', 'Blockquote']},
		{ name: 'styles', items: ['Styles', 'Format','Font', 'FontSize']},
		{ name: 'align', items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
	];
};

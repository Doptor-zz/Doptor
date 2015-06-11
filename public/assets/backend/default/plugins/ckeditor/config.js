/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// config.filebrowserBrowseUrl = window.base_url + '/assets/backend/default/plugins/ckeditor/kcfinder/browse.php?type=files';
	// config.filebrowserImageBrowseUrl = window.base_url + '/assets/backend/default/plugins/ckeditor/kcfinder/browse.php?type=images';
	// config.filebrowserFlashBrowseUrl = window.base_url + '/assets/backend/default/plugins/ckeditor/kcfinder/browse.php?type=flash';
	// config.filebrowserUploadUrl = window.base_url + '/assets/backend/default/plugins/ckeditor/kcfinder/upload.php?type=files';
	// config.filebrowserImageUploadUrl = window.base_url + '/assets/backend/default/plugins/ckeditor/kcfinder/upload.php?type=images';
	// config.filebrowserFlashUploadUrl = window.base_url + '/assets/backend/default/plugins/ckeditor/kcfinder/upload.php?type=flash';

	config.extraPlugins = 'wpmore';

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'styles' },
		{ name: 'colors' }
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Subscript,Superscript';

	config.removeDialogTabs = 'link:upload;image:Upload';
};

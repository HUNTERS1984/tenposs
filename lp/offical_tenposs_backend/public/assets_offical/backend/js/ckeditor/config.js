/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

var urlSite = '../../public/assets/backend/js';

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	// CONFIG KCFINDER
	/*
	config.filebrowserBrowseUrl = urlSite+'/kcfinder/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl = urlSite+'/kcfinder/browse.php?opener=ckeditor&type=images';
	config.filebrowserFlashBrowseUrl = urlSite+'/kcfinder/browse.php?opener=ckeditor&type=flash';
	config.filebrowserUploadUrl = urlSite+'/kcfinder/upload.php?opener=ckeditor&type=files';
	config.filebrowserImageUploadUrl = urlSite+'/kcfinder/upload.php?opener=ckeditor&type=images';
	config.filebrowserFlashUploadUrl = urlSite+'/kcfinder/upload.php?opener=ckeditor&type=flash';
	*/

	// CONFIG CKFINDER
	config.filebrowserBrowseUrl = urlSite+'/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = urlSite+'/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = urlSite+'/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl = urlSite+'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = urlSite+'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = urlSite+'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};

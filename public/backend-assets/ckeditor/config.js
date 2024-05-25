/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
//   config.extraPlugins = 'youtube';
  // let domainName=window.location.origin;
   let domainName=window.location.origin+'/vivara';
console.log(domainName);
  config.filebrowserBrowseUrl =domainName+'/public/backend-assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';

  config.filebrowserImageBrowseUrl = domainName+'/public/backend-assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images';

  config.filebrowserFlashBrowseUrl = domainName+'/public/backend-assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';

  config.filebrowserUploadUrl = domainName+'/public/backend-assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';

  config.filebrowserImageUploadUrl = domainName+'/public/backend-assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images';

  config.filebrowserFlashUploadUrl = domainName+'/public/backend-assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';

  config.filebrowserUploadMethod = 'form';
};


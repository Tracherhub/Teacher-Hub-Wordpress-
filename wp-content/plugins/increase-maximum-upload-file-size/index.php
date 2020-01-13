<?php
/*
 * Plugin Name: Increase Maximum Upload File Size
 * Plugin URI:  https://wordpress.org/plugins/increase-maximum-upload-file-size/
 * Description: Increase maximum upload file size from media in wordpress
 * Version: 1.0
 * Author: ViitorCloud 
 * Author URI: http://www.viitorcloud.com
 * Text Domain: increase-max-upload-file-size-media
 */

function mediaIncreaseMaxUploadFileSize() {
	$media_upload_size = 7850 * 10000;
	return $media_upload_size;
}
add_filter('upload_size_limit', 'mediaIncreaseMaxUploadFileSize');
?> 
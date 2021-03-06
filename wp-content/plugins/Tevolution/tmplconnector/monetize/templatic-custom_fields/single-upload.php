<?php
/*
 * ajax to upload file for single upload image.
 */
require("../../../../../../wp-load.php");
session_start();
$structure = TEMPLATEPATH."/images/";
if(!is_dir($structure."tmp"))
{
	if (!mkdir($structure."tmp", 0777, true)) 
	 {
		die('Failed to create folders...');
	 }
}
$uploaddir = TEMPLATEPATH."/images/tmp/";

/*save the images in tmp folder of parent theme directory*/
$files_allow = apply_filters('tmpl_allow_extra_file_upload',array('.jpg','.JPG','jpeg','JPEG','.png','.PNG','.gif','.GIF','.jpe','.JPE','.pdf','xlsx','.xls','docx','.doc','.odt','.ods','.odp','pptx','.ppt','pptm','.txt','.rtf','.mp3','.wma','.3gp','.flv','.avi','.mov','.wmv','.mp4','.csv','.xml','.zip'));

$image_allow=array('.jpg','.JPG','jpeg','JPEG','.png','.PNG','.gif','.GIF','.jpe','.JPE');

global $extension_file;

foreach($_FILES as $key=>$val)
{
	if(isset($_FILES[$key]))
	{
		$ret = array();

		$error =$_FILES[$key]["error"];
		/*You need to handle  both cases
		If Any browser does not support serializing of multiple files using FormData() */
		if(!is_array($_FILES[$key]["name"])) /*single file*/
		{
			$srch_arr = array(' ',"'",'"','?','*','!','@','#','$','%','^','&','(',')','+','=');
			$replace_arr = array('_','','','','','','','','','','','','','','','');
			
			$fileName = $name = str_replace($srch_arr,$replace_arr,$_FILES[$key]["name"]);
			
			$fileName = time().'_'.$fileName;
			
			$original_fileName = $fileName;
			
			/* copy the image from tmp folder to wordpress folder */
			$wp_upload_dir = wp_upload_dir();
			$path = $wp_upload_dir['path'];
			$url = $wp_upload_dir['url'];
			$destination_path = $wp_upload_dir['path'].'/';
			$target_path = $destination_path . str_replace(',','',$fileName);
			$file_ext= strtolower(substr($target_path, -4, 4));	
			
			if(in_array($file_ext,$files_allow))
			{
				if(in_array($file_ext,$image_allow))
				{
					$fileinfo = getimagesize($_FILES[$key]["tmp_name"]);
					if(!empty($fileinfo))
					{
						if(!move_uploaded_file($_FILES[$key]["tmp_name"],$uploaddir.$fileName))
						{
							$ret[]= 'error';
							echo json_encode($ret);exit;
						}
						if(extension_loaded('fileinfo'))
						{
							 $mime_image_types = array('image/bmp','image/bmp','image/x-windows-bmp','image/jpeg','image/pjpeg','image/jpeg','image/pjpeg','image/jpeg','image/pjpeg','image/png','image/gif','image/gif');
							 $mime_type = mime_content_type($uploaddir.$fileName);
							 if(!in_array($mime_type,$mime_image_types))
							 {
								$unlink_path=$uploaddir.$fileName;
								@unlink($unlink_path);
								$ret[]= 'Cheating huh..!!';
								echo json_encode($ret);exit;
							 }
						}
					}
					else{
						$ret[]= 'Cheating huh..!!';
						echo json_encode($ret);exit;
					}
				}
				else{
					if(!move_uploaded_file($_FILES[$key]["tmp_name"],$uploaddir.$fileName))
					{
						$ret[]= 'error';
						echo json_encode($ret);exit;
					}
					if(extension_loaded('fileinfo'))
					{
						
						$mime_allowd_types = array('application/x-troff-msvideo','video/avi','video/msvideo','video/x-msvideo','video/avs-video','image/bmp','image/bmp','image/x-windows-bmp','application/msword','application/msword','video/-flv','image/jpeg','image/pjpeg','image/jpeg','image/pjpeg','image/jpeg','image/pjpeg','video/mp4','application/vnd.oasis.opendocument.text','application/vnd.oasis.opendocument.spreadsheet','application/vnd.oasis.opendocument.presentation	','video/quicktime','audio/mpeg3','audio/x-mpeg-3','video/mpeg','video/x-mpeg','application/pdf','application/vnd.ms-excel','image/png','image/gif','image/gif','application/mspowerpoint','application/powerpoint','application/vnd.ms-powerpoint','application/x-mspowerpoint','application/mspowerpoint','application/powerpoint','application/vnd.ms-powerpoint','application/x-mspowerpoint','application/vnd.ms-powerpoint.presentation.macroenabled.12','application/rtf','audio/x-ms-wma','video/3gpp','video/x-ms-wmv','text/csv','application/xml','text/xml','application/x-compressed','application/x-zip-compressed','application/zip','text/plain','multipart/x-zip');
						$mime_type = mime_content_type($uploaddir.$fileName);
						if(!in_array($mime_type,$mime_allowd_types))
						{
							$unlink_path=$uploaddir.$fileName;
							@unlink($unlink_path);
							$ret[]= 'Cheating huh..!!';
							echo json_encode($ret);exit;
						}
					}
				}
			}
			else{
				$ret[]= 'error';
				echo json_encode($ret);exit;
			}
			
			$filename = $uploaddir.$fileName;

			/* Check the type of tile. We'll use this as the 'post_mime_type'.*/
			$filetype = wp_check_filetype( basename( $filename ), null );

			/* Get the path to the upload directory.*/
			$wp_upload_dir = wp_upload_dir();

			/* Prepare an array of post data for the attachment.*/
			$attachment = array(
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content'   => '',
				'post_status'    => 'inherit'
			);

			/* Insert the attachment.*/

			$img_attachment=substr($wp_upload_dir['subdir'].'/'.basename($filename),1);
			$attach_id = wp_insert_attachment( $attachment, $img_attachment);

			/* Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.*/
			require_once( ABSPATH . 'wp-admin/includes/image.php' );

			/* Generate the metadata for the attachment, and update the database record.*/
			$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
			wp_update_attachment_metadata( $attach_id, $attach_data );
			
			/* copy the image from tmp folder to wordpress folder */
			$wp_upload_dir = wp_upload_dir();
			$path = $wp_upload_dir['path'];
			$url = $wp_upload_dir['url'];
			$destination_path = $wp_upload_dir['path'].'/';
			
			$name = str_replace($srch_arr,$replace_arr,$_FILES[$key]['name']);
			$name = $original_fileName;
			$tmp_name = $_FILES[$key]['tmp_name'];
			$target_path = $destination_path . str_replace(',','',$name);
			$file_ext= strtolower(substr($target_path, -4, 4));	

			if(in_array($file_ext,$files_allow) && in_array($file_ext,$extension_file))
			{
				if(@copy($uploaddir.$fileName, $target_path))
				{
					$imagepath1 = $url."/".$name;
					$_SESSION['upload_file'][$key] = $imagepath1;/* save the image path in session */
				}
			}
			$ret[]= $fileName;
			
			/* regenerate image sizes */
			$file = get_attached_file( $attach_id );
			
			wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata( $attach_id, $file ) );
		}
		else  /*Multiple files, file[]*/
		{
		  $fileCount = count($_FILES[$key]["name"]);
		  for($i=0; $i < $fileCount; $i++)
		  {
			$srch_arr = array(' ',"'",'"','?','*','!','@','#','$','%','^','&','(',')','+','=');
			$replace_arr = array('_','','','','','','','','','','','','','','','');
			
			$fileName = $name = str_replace($srch_arr,$replace_arr,$_FILES[$key]["name"][$i]);
			
			$fileName = time().'_'.$fileName;

			/*save the images in tmp folder of parent theme directory*/
			$wp_upload_dir = wp_upload_dir();
			$path = $wp_upload_dir['path'];
			$url = $wp_upload_dir['url'];
			$destination_path = $wp_upload_dir['path'].'/';
			$srch_arr = array(' ',"'",'"','?','*','!','@','#','$','%','^','&','(',')','+','=');
			$replace_arr = array('_','','','','','','','','','','','','','','','');
			$name = str_replace($srch_arr,$replace_arr,$_FILES[$key]['name']);
			$tmp_name = $_FILES[$key]['tmp_name'];
			$target_path = $destination_path . str_replace(',','',$name);
			$files_not_allow = array('.php','.js','.exe');
			$file_ext= strtolower(substr($target_path, -4, 4));	
			
			if(!in_array($file_ext,$image_allow))
			{
				$fileinfo = getimagesize($_FILES[$key]["tmp_name"][$i]);
				if(!empty($fileinfo))
				{
					if(!move_uploaded_file($_FILES[$key]["tmp_name"][$i],$uploaddir.$fileName))
					{
						$ret[]= 'error';
						echo json_encode($ret);exit;
					}
					if(extension_loaded('fileinfo'))
					{
						 $mime_image_types = array('image/bmp','image/bmp','image/x-windows-bmp','image/jpeg','image/pjpeg','image/jpeg','image/pjpeg','image/jpeg','image/pjpeg','image/png','image/gif','image/gif');
						 $mime_type = mime_content_type($uploaddir.$fileName);
						 if(!in_array($mime_type,$mime_image_types))
						 {
							$unlink_path=$uploaddir.$fileName;
							@unlink($unlink_path);
							$ret[]= 'Cheating huh..!!';
							echo json_encode($ret);exit;
						 }
					}
				}
				else{
					$ret[]= 'Cheating huh..!!';
					echo json_encode($ret);exit;
				}
			}
			else{
				$ret[]= 'error';
				echo json_encode($ret);exit;
			}
			$filename = $uploaddir.$fileName;

			/* Check the type of tile. We'll use this as the 'post_mime_type'.*/
			$filetype = wp_check_filetype( basename( $filename ), null );

			/* Get the path to the upload directory.*/
			$wp_upload_dir = wp_upload_dir();

			/* Prepare an array of post data for the attachment.*/
			$attachment = array(
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content'   => '',
				'post_status'    => 'inherit'
			);

			/* Insert the attachment.*/
			$attach_id = wp_insert_attachment( $attachment, $filename);

			/* Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.*/
			require_once( ABSPATH . 'wp-admin/includes/image.php' );

			/* Generate the metadata for the attachment, and update the database record.*/
			$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
			wp_update_attachment_metadata( $attach_id, $attach_data );
			
			/* copy the image from tmp folder to wordpress folder */
			
			if(!in_array($file_ext,$files_not_allow) && in_array($file_ext,$extension_file))
			{
				if(@copy($uploaddir.$fileName, $target_path))
				{
					$imagepath1 = $url."/".$name;
					$_SESSION['upload_file'][$key] = $imagepath1;/* save the image path in session */
				}
			}
			
			$ret[]= $fileName;
		  }
		
		}
		echo json_encode($ret);exit;
	 }
}
?>
<?php
global $wpdb;
require_once(ABSPATH . "wp-admin/includes/upgrade.php");
$version = get_option("gallery-bank-pro-edition");
update_option("gallery-bank-updation-check-url","http://tech-banker.com/wp-admin/admin-ajax.php");
if($version == "")
{
	include_once (GALLERY_BK_PLUGIN_DIR . "/lib/class-tracking.php");
    if (count($wpdb->get_var("SHOW TABLES LIKE '" . gallery_bank_albums() . "'")) == 0)
    {
        create_table_albums();
    }
    else
    {
        $albums = $wpdb->get_results
        (
            "Select * FROM " . gallery_bank_albums()
        );

        $sql = "DROP TABLE " . gallery_bank_albums();
        $wpdb->query($sql);

        create_table_albums();

        if(count($albums) > 0)
        {
            for($flag = 0; $flag < count($albums); $flag++)
            {
                $wpdb->query
                (
                    $wpdb->prepare
                    (
                        "INSERT INTO " . gallery_bank_albums() . "(album_id, album_name, author, album_date,
                        description, album_order) VALUES(%d, %s, %s, %s, %s, %d)",
                        $albums[$flag]->album_id,
                        $albums[$flag]->album_name,
                        $albums[$flag]->author,
                        $albums[$flag]->album_date,
                        $albums[$flag]->description,
                        $albums[$flag]->album_id
                    )
                );
            }
        }
    }
    if (count($wpdb->get_var("SHOW TABLES LIKE '" . gallery_bank_pics() . "'")) == 0)
    {
        create_table_album_pics();
    }
    else
    {
        $album_pics = $wpdb->get_results
        (
            "Select * FROM " . gallery_bank_pics()
        );

        $sql = "DROP TABLE " . gallery_bank_pics();
        $wpdb->query($sql);

        create_table_album_pics();
        
        if(count($album_pics) > 0)
        {
            $album_id = 0;
            for($flag = 0; $flag < count($album_pics); $flag++)
            {
                if($album_pics[$flag]->video == 1)
                {
                    $wpdb->query
                    (
                        $wpdb->prepare
                        (
                            "INSERT INTO " . gallery_bank_pics() . "(pic_id, album_id, title, description, thumbnail_url,
                            sorting_order, date, url, video, tags, pic_name, album_cover) VALUES(%d, %d, %s, %s, %s, %d, %s,
                            %s, %d, %s, %s, %d)",
                            $album_pics[$flag]->pic_id,
                            $album_pics[$flag]->album_id,
                            $album_pics[$flag]->title,
                            $album_pics[$flag]->description,
                            $album_pics[$flag]->thumbnail_url,
                            $album_pics[$flag]->sorting_order,
                            $album_pics[$flag]->date,
                            $album_pics[$flag]->url,
                           isset($album_pics[$flag]->video) ? $album_pics[$flag]->video : 0,
                           isset($album_pics[$flag]->tags) ? $album_pics[$flag]->tags : "" ,
                           isset($album_pics[$flag]->pic_path) ?  $album_pics[$flag]->pic_path : "",
                           0
                        )
                    );
                }
                else
                {
                	$file_path = $album_pics[$flag]->pic_path;
					$file_name_exct = explode("/", $album_pics[$flag]->pic_path);
                    $file_name = $file_name_exct[count($file_name_exct) - 1];
					$src = str_replace(site_url("/"), "", $file_path);
                    $destination = GALLERY_MAIN_UPLOAD_DIR.$file_name;
					
                    if (PHP_VERSION > 5)
                    {
                        copy(ABSPATH.$src, $destination);
                    }
                    else
                    {
                        $content = file_get_contents(ABSPATH.$src);
                        $fp = fopen($destination, "w");
                        fwrite($fp, $content);
                        fclose($fp);
                    }
                    if(file_exists($destination))
                    {
                        process_image_upload($file_name, 160, 120);
                    }

                    $wpdb->query
                    (
                        $wpdb->prepare
                        (
                            "INSERT INTO " . gallery_bank_pics() . "(pic_id, album_id, title, description, thumbnail_url,
                    sorting_order, date, url, video, tags, pic_name, album_cover) VALUES(%d, %d, %s, %s, %s, %d, %s,
                    %s, %d, %s, %s, %d)",
                            $album_pics[$flag]->pic_id,
                            $album_pics[$flag]->album_id,
                            $album_pics[$flag]->title,
                            $album_pics[$flag]->description,
                            $file_name,
                            $album_pics[$flag]->sorting_order,
                            $album_pics[$flag]->date,
                            $album_pics[$flag]->url,
                            isset($album_pics[$flag]->video) ? $album_pics[$flag]->video : 0,
                            isset($album_pics[$flag]->tags) ? $album_pics[$flag]->tags : "" ,
                            $file_name,
                            $album_id == $album_pics[$flag]->album_id ? 0 : 1
                        )
                    );
                    if($album_id != $album_pics[$flag]->album_id)
                    {
                        process_album_upload($file_name, 160, 120);
                    }
                    $album_id = $album_pics[$flag]->album_id;
                }
            }
        }
    }
    if (count($wpdb->get_var("SHOW TABLES LIKE '" . gallery_bank_settings() . "'")) == 0)
    {
        create_table_album_settings();
    }
    else
    {
        $sql = "DROP TABLE " . gallery_bank_settings();
        $wpdb->query($sql);

        create_table_album_settings();
    }
    if (count($wpdb->get_var("SHOW TABLES LIKE '" . gallery_bank_licensing() . "'")) == 0)
    {
        create_table_licensing();
    }
}
else
{
	if (count($wpdb->get_var("SHOW TABLES LIKE '" . gallery_bank_licensing() . "'")) == 0)
    {
        create_table_licensing();
    }
	else
	{
		$wpdb->query
        (
            $wpdb->prepare
            (
                "UPDATE " . gallery_bank_licensing() . " SET version = %s ",
                "3.8.4"
            )
        );
	}
	$settings = $wpdb->get_results
	(
		"SELECT * FROM " . gallery_bank_settings()
	);
	if (count($settings) != 0)
	{
		$setting_keys = array();
		for ($flag = 0; $flag < count($settings); $flag++)
		{
			array_push($setting_keys, $settings[$flag]->setting_key);
		}
		$image_uploader = array_search("image_uploader", $setting_keys);
		$change_image_name = array_search("change_image_name", $setting_keys);
		$responsive_albums = array_search("responsive_albums", $setting_keys);
		$url_to_redirect = array_search("url_to_redirect", $setting_keys);
		
		if($image_uploader == "")
		{
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO " . gallery_bank_settings() . " (setting_key, setting_value) VALUES(%s, %s)",
					"image_uploader",
					"1"
				)
			);
		}
		if($change_image_name == "")
		{
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO " . gallery_bank_settings() . " (setting_key, setting_value) VALUES(%s, %s)",
					"change_image_name",
					"1"
				)
			);
		}
		if($responsive_albums == "")
		{
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO " . gallery_bank_settings() . " (setting_key, setting_value) VALUES(%s, %s)",
					"responsive_albums",
					"1"
				)
			);
		}
		if($url_to_redirect == "")
		{
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO " . gallery_bank_settings() . " (setting_key, setting_value) VALUES(%s, %s)",
					"url_to_redirect",
					"1"
				)
			);
		}
	}
}
update_option("gallery-bank-pro-edition", "3.8.4");
/******************************************Code for Thumbnails Creation**********************/
	function process_image_upload($image, $width, $height)
	{
	    $temp_image_path = GALLERY_MAIN_UPLOAD_DIR . $image;
	    $temp_image_name = $image;
	    list(, , $temp_image_type) = getimagesize($temp_image_path);
	    if ($temp_image_type === NULL) {
	        return false;
	    }
	    $uploaded_image_path = GALLERY_MAIN_UPLOAD_DIR . $temp_image_name;
	    move_uploaded_file($temp_image_path, $uploaded_image_path);
	    $type = explode(".", $image);
	    $thumbnail_image_path = GALLERY_MAIN_THUMB_DIR . preg_replace('{\\.[^\\.]+$}', '.'.$type[1], $temp_image_name);
	    
	    $result = generate_thumbnail($uploaded_image_path, $thumbnail_image_path, $width, $height);
	    return $result ? array($uploaded_image_path, $thumbnail_image_path) : false;
    }
    function process_album_upload($album_image, $width, $height)
    {
        $temp_image_path = GALLERY_MAIN_UPLOAD_DIR . $album_image;
        $temp_image_name = $album_image;
        list(, , $temp_image_type) = getimagesize($temp_image_path);
        if ($temp_image_type === NULL) {
            return false;
        }
        $uploaded_image_path = GALLERY_MAIN_UPLOAD_DIR . $temp_image_name;
        move_uploaded_file($temp_image_path, $uploaded_image_path);
        $type = explode(".", $album_image);
        $thumbnail_image_path = GALLERY_MAIN_ALB_THUMB_DIR . preg_replace("{\\.[^\\.]+$}", ".".$type[1], $temp_image_name);
					
        $result = generate_thumbnail($uploaded_image_path, $thumbnail_image_path, $width, $height);
        return $result ? array($uploaded_image_path, $thumbnail_image_path) : false;
    }
/****************************** COMMON FUNCTION TO GENERATE THUMBNAILS********************************/
	function generate_thumbnail($source_image_path, $thumbnail_image_path, $imageWidth, $imageHeight)
	{
	    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
	    $source_gd_image = false;
	    switch ($source_image_type) {
	
	        case IMAGETYPE_GIF:
	            $source_gd_image = imagecreatefromgif($source_image_path);
	            break;
	        case IMAGETYPE_JPEG:
	            $source_gd_image = imagecreatefromjpeg($source_image_path);
	            break;
	        case IMAGETYPE_PNG:
	            $source_gd_image = imagecreatefrompng($source_image_path);
	            break;
	    }
	    if ($source_gd_image === false) {
	        return false;
	    }
	    $source_aspect_ratio = $source_image_width / $source_image_height;
	    if ($source_image_width > $source_image_height) {
	        (int)$real_height = $imageHeight;
	        (int)$real_width = $imageHeight * $source_aspect_ratio;
	    } else if ($source_image_height > $source_image_width) {
	        (int)$real_height = $imageWidth / $source_aspect_ratio;
	        (int)$real_width = $imageWidth;

	    } else {

	        (int)$real_height = $imageHeight > $imageWidth ? $imageHeight : $imageWidth;
	        (int)$real_width = $imageWidth > $imageHeight ? $imageWidth : $imageHeight;
	    }
        $thumbnail_gd_image = imagecreatetruecolor($real_width, $real_height);
		if(($source_image_type == 1) || ($source_image_type==3))
		{
			imagealphablending($thumbnail_gd_image, false);
			imagesavealpha($thumbnail_gd_image, true);
			$transparent = imagecolorallocatealpha($thumbnail_gd_image, 255, 255, 255, 127);
			imagecolortransparent($thumbnail_gd_image, $transparent);
			imagefilledrectangle($thumbnail_gd_image, 0, 0, $real_width, $real_height, $transparent);
	 	}
		else
		{
			$bg_color = imagecolorallocate($thumbnail_gd_image, 255, 255, 255);
			imagefilledrectangle($thumbnail_gd_image, 0, 0, $real_width, $real_height, $bg_color);
		}
		
	    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $real_width, $real_height, $source_image_width, $source_image_height);

	    switch ($source_image_type)
		{
			case IMAGETYPE_GIF:
				imagepng($thumbnail_gd_image, $thumbnail_image_path, 9 );
			break;
			case IMAGETYPE_JPEG:
				imagejpeg($thumbnail_gd_image, $thumbnail_image_path, 100);
			break;
			case IMAGETYPE_PNG:
				imagepng($thumbnail_gd_image, $thumbnail_image_path, 9 );
			break;
		}
	    imagedestroy($source_gd_image);
	    imagedestroy($thumbnail_gd_image);
	    return true;
    }
    function create_table_albums()
    {
        $sql = "CREATE TABLE " . gallery_bank_albums() . "(
            album_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            album_name VARCHAR(100),
            author VARCHAR(100),
            album_date DATE,
            description TEXT,
            album_order INTEGER(10),
            PRIMARY KEY (album_id)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci";
        dbDelta($sql);
    }
    function create_table_album_pics()
    {
        $sql = "CREATE TABLE " . gallery_bank_pics() . "(
            pic_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            album_id INTEGER(10) UNSIGNED NOT NULL,
            title TEXT,
            description TEXT,
            thumbnail_url TEXT NOT NULL,
            sorting_order INTEGER(20),
            date DATE,
            url VARCHAR(250),
            video INTEGER(10) NOT NULL,
            tags TEXT,
            pic_name TEXT NOT NULL,
            album_cover INTEGER(1),
            PRIMARY KEY(pic_id)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci";
        dbDelta($sql);
    }
    function create_table_album_settings()
    {
        global $wpdb;
        $sql = "CREATE TABLE " . gallery_bank_settings() . "(
            setting_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            setting_key VARCHAR(100) NOT NULL,
            setting_value TEXT NOT NULL,
            PRIMARY KEY (setting_id)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci";
        dbDelta($sql);

        include_once (GALLERY_BK_PLUGIN_DIR . "/lib/include_settings.php");

    }
    function create_table_licensing()
    {
        global $wpdb;
        $sql = "CREATE TABLE " . gallery_bank_licensing() . "(
            licensing_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            version VARCHAR(10) NOT NULL,
            type VARCHAR(100) NOT NULL,
            url TEXT NOT NULL,
            api_key TEXT,
            order_id VARCHAR(100),
            PRIMARY KEY (licensing_id)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci";
        dbDelta($sql);

        $wpdb->query
        (
            $wpdb->prepare
            (
                "INSERT INTO " . gallery_bank_licensing() . "(version, type, url) VALUES(%s, %s, %s)",
                "3.8.4",
                "Gallery Bank Pro Edition",
                "" . site_url() . ""
            )
        );
    }
?>
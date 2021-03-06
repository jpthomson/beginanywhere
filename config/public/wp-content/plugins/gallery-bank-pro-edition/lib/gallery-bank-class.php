<?php
//--------------------------------------------------------------------------------------------------------------//
// CODE FOR CREATING MENUS
//---------------------------------------------------------------------------------------------------------------//

function create_global_menus_for_gallery_bank()
{
    global $current_user, $wpdb;
    $role = $wpdb->prefix . "capabilities";
    $current_user->role = array_keys($current_user->$role);
    $role = $current_user->role[0];
	
    include GALLERY_BK_PLUGIN_DIR . "/lib/include_roles_settings.php";

    switch ($role) {
        case "administrator":
            if ($admin_full_control == "0" && $admin_read_control == "1" && $admin_write_control == "0") {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
                //add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
            } elseif ($admin_full_control == "0" && ($admin_read_control == "1" || $admin_write_control == "1")) {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Album Sorting", __("Album Sorting", gallery_bank), "read", "gallery_album_sorting", $activation_status == $api_key ? "gallery_album_sorting" : "gallery_licensing");
                //add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "view_album", $activation_status == $api_key ? "view_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "save_album", $activation_status == $api_key ? "save_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "images_sorting", $activation_status == $api_key ? "images_sorting" : "gallery_licensing");
            } else {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Album Sorting", __("Album Sorting", gallery_bank), "read", "gallery_album_sorting", $activation_status == $api_key ? "gallery_album_sorting" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Gallery Bank", __("Global Settings", gallery_bank), "read", "global_settings", $activation_status == $api_key ? "global_settings" : "gallery_licensing");
                add_submenu_page("gallery_bank", "System Status", __("System Status", gallery_bank), "read", "gallery_bank_system_status", $activation_status == $api_key ? "gallery_bank_system_status" : "gallery_licensing");
               // add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Licensing", __("Licensing", gallery_bank), "read", "gallery_licensing", "gallery_licensing");
                add_submenu_page("", "", "", "read", "view_album", $activation_status == $api_key ? "view_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "save_album", $activation_status == $api_key ? "save_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "images_sorting", $activation_status == $api_key ? "images_sorting" : "gallery_licensing");
            }
            break;
        case "editor":
            if ($editor_full_control == "0" && $editor_read_control == "1" && $editor_write_control == "0") {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
                //add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
            } elseif ($editor_full_control == "0" && ($editor_read_control == "1" || $editor_write_control == "1")) {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Album Sorting", __("Album Sorting", gallery_bank), "read", "gallery_album_sorting", $activation_status == $api_key ? "gallery_album_sorting" : "gallery_licensing");
                //add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "view_album", $activation_status == $api_key ? "view_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "save_album", $activation_status == $api_key ? "save_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "images_sorting", $activation_status == $api_key ? "images_sorting" : "gallery_licensing");
            } else {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Album Sorting", __("Album Sorting", gallery_bank), "read", "gallery_album_sorting", $activation_status == $api_key ? "gallery_album_sorting" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Gallery Bank", __("Global Settings", gallery_bank), "read", "global_settings", $activation_status == $api_key ? "global_settings" : "gallery_licensing");
                add_submenu_page("gallery_bank", "System Status", __("System Status", gallery_bank), "read", "gallery_bank_system_status", $activation_status == $api_key ? "gallery_bank_system_status" : "gallery_licensing");
               // add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Licensing", __("Licensing", gallery_bank), "read", "gallery_licensing", "gallery_licensing");
                add_submenu_page("", "", "", "read", "view_album", $activation_status == $api_key ? "view_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "save_album", $activation_status == $api_key ? "save_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "images_sorting", $activation_status == $api_key ? "images_sorting" : "gallery_licensing");
            }
            break;
        case "author":
            if ($author_full_control == "0" && $author_read_control == "1" && $author_write_control == "0") {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
               // add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
            } elseif ($author_full_control == "0" && ($author_read_control == "1" || $author_write_control == "1")) {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Album Sorting", __("Album Sorting", gallery_bank), "read", "gallery_album_sorting", $activation_status == $api_key ? "gallery_album_sorting" : "gallery_licensing");
               // add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "view_album", $activation_status == $api_key ? "view_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "save_album", $activation_status == $api_key ? "save_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "images_sorting", $activation_status == $api_key ? "images_sorting" : "gallery_licensing");
            } else {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Album Sorting", __("Album Sorting", gallery_bank), "read", "gallery_album_sorting", $activation_status == $api_key ? "gallery_album_sorting" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Gallery Bank", __("Global Settings", gallery_bank), "read", "global_settings", $activation_status == $api_key ? "global_settings" : "gallery_licensing");
                add_submenu_page("gallery_bank", "System Status", __("System Status", gallery_bank), "read", "gallery_bank_system_status", $activation_status == $api_key ? "gallery_bank_system_status" : "gallery_licensing");
              //  add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Licensing", __("Licensing", gallery_bank), "read", "gallery_licensing", "gallery_licensing");
                add_submenu_page("", "", "", "read", "view_album", $activation_status == $api_key ? "view_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "save_album", $activation_status == $api_key ? "save_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "images_sorting", $activation_status == $api_key ? "images_sorting" : "gallery_licensing");
            }
            break;
        case "contributor":
            if ($contributor_full_control == "0" && $contributor_read_control == "1" && $contributor_write_control == "0") {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
              //  add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
            } elseif ($contributor_full_control == "0" && ($contributor_read_control == "1" || $contributor_write_control == "1")) {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Album Sorting", __("Album Sorting", gallery_bank), "read", "gallery_album_sorting", $activation_status == $api_key ? "gallery_album_sorting" : "gallery_licensing");
              //  add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "view_album", $activation_status == $api_key ? "view_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "save_album", $activation_status == $api_key ? "save_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "images_sorting", $activation_status == $api_key ? "images_sorting" : "gallery_licensing");
            } else {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Album Sorting", __("Album Sorting", gallery_bank), "read", "gallery_album_sorting", $activation_status == $api_key ? "gallery_album_sorting" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Gallery Bank", __("Global Settings", gallery_bank), "read", "global_settings", $activation_status == $api_key ? "global_settings" : "gallery_licensing");
                add_submenu_page("gallery_bank", "System Status", __("System Status", gallery_bank), "read", "gallery_bank_system_status", $activation_status == $api_key ? "gallery_bank_system_status" : "gallery_licensing");
              //  add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Licensing", __("Licensing", gallery_bank), "read", "gallery_licensing", "gallery_licensing");
                add_submenu_page("", "", "", "read", "view_album", $activation_status == $api_key ? "view_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "save_album", $activation_status == $api_key ? "save_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "images_sorting", $activation_status == $api_key ? "images_sorting" : "gallery_licensing");
            }
            break;
        case "subscriber":
            if ($subscriber_full_control == "0" && $subscriber_read_control == "1" && $subscriber_write_control == "0") {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
              // add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
            } elseif ($subscriber_full_control == "0" && ($subscriber_read_control == "1" || $subscriber_write_control == "1")) {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Album Sorting", __("Album Sorting", gallery_bank), "read", "gallery_album_sorting", $activation_status == $api_key ? "gallery_album_sorting" : "gallery_licensing");
              //  add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "view_album", $activation_status == $api_key ? "view_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "save_album", $activation_status == $api_key ? "save_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "images_sorting", $activation_status == $api_key ? "images_sorting" : "gallery_licensing");
            } else {
                add_menu_page("Gallery Bank", __("Gallery Bank", gallery_bank), "read", "gallery_bank", "", GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png");
                add_submenu_page("gallery_bank", "Dashboard", __("Dashboard", gallery_bank), "read", "gallery_bank", $activation_status == $api_key ? "gallery_bank" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Album Sorting", __("Album Sorting", gallery_bank), "read", "gallery_album_sorting", $activation_status == $api_key ? "gallery_album_sorting" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Gallery Bank", __("Global Settings", gallery_bank), "read", "global_settings", $activation_status == $api_key ? "global_settings" : "gallery_licensing");
                add_submenu_page("gallery_bank", "System Status", __("System Status", gallery_bank), "read", "gallery_bank_system_status", $activation_status == $api_key ? "gallery_bank_system_status" : "gallery_licensing");
               // add_submenu_page("gallery_bank", "Documentation", __("Documentation", gallery_bank), "read", "gallery_bank_documentation", $activation_status == $api_key ? "gallery_bank_documentation" : "gallery_licensing");
                add_submenu_page("gallery_bank", "Licensing", __("Licensing", gallery_bank), "read", "gallery_licensing", "gallery_licensing");
                add_submenu_page("", "", "", "read", "view_album", $activation_status == $api_key ? "view_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "album_preview", $activation_status == $api_key ? "album_preview" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "save_album", $activation_status == $api_key ? "save_album" : "gallery_licensing");
                add_submenu_page("", "", "", "read", "images_sorting", $activation_status == $api_key ? "images_sorting" : "gallery_licensing");
            }
            break;
    }
}
//--------------------------------------------------------------------------------------------------------------//
// FUNCTIONS FOR REPLACING TABLE NAMES
//--------------------------------------------------------------------------------------------------------------//

function gallery_bank_albums()
{
    global $wpdb;
    return $wpdb->prefix . "gallery_albums";
}

function gallery_bank_pics()
{
    global $wpdb;
    return $wpdb->prefix . "gallery_pics";
}

function gallery_bank_settings()
{
    global $wpdb;
    return $wpdb->prefix . "gallery_settings";
}

function gallery_bank_licensing()
{
    global $wpdb;
    return $wpdb->prefix . "gallery_licensing";
}

//--------------------------------------------------------------------------------------------------------------//
// CODE FOR CREATING PAGES
//---------------------------------------------------------------------------------------------------------------//
function gallery_bank()
{
    include_once GALLERY_BK_PLUGIN_DIR . "/views/header.php";
    include_once GALLERY_BK_PLUGIN_DIR . "/views/dashboard.php";
}

function save_album()
{
    include_once GALLERY_BK_PLUGIN_DIR . "/views/header.php";
    include_once GALLERY_BK_PLUGIN_DIR . "/views/edit-album.php";
}

function global_settings()
{
    include_once GALLERY_BK_PLUGIN_DIR . "/views/header.php";
    include_once GALLERY_BK_PLUGIN_DIR . "/views/settings.php";
}

function gallery_album_sorting()
{
    include_once GALLERY_BK_PLUGIN_DIR . "/views/header.php";
    include_once GALLERY_BK_PLUGIN_DIR . "/views/album-sorting.php";
}

function images_sorting()
{
    include_once GALLERY_BK_PLUGIN_DIR . "/views/header.php";
    include_once GALLERY_BK_PLUGIN_DIR . "/views/images-sorting.php";
}

function album_preview()
{
    include_once GALLERY_BK_PLUGIN_DIR . "/views/header.php";
    include_once GALLERY_BK_PLUGIN_DIR . "/views/album-preview.php";
}

function gallery_licensing()
{
    include_once GALLERY_BK_PLUGIN_DIR . "/views/header.php";
    include_once GALLERY_BK_PLUGIN_DIR . "/views/licensing.php";
}

function gallery_bank_system_status()
{
    include_once GALLERY_BK_PLUGIN_DIR . "/views/header.php";
    include_once GALLERY_BK_PLUGIN_DIR . "/views/gallery-bank-system-report.php";
}

// function gallery_bank_documentation()
// {
    // include_once GALLERY_BK_PLUGIN_DIR . "/views/header.php";
    // include_once GALLERY_BK_PLUGIN_DIR . "/views/gallery_bank_documentation.php";
// }

//--------------------------------------------------------------------------------------------------------------//
//CODE FOR CALLING JAVASCRIPT FUNCTIONS
//--------------------------------------------------------------------------------------------------------------//
function backend_scripts_calls()
{
	global $wpdb;
	$album_css = $wpdb->get_results
    (
        "SELECT * FROM " . gallery_bank_settings()
    );
	if (count($album_css) != 0) {
	    $setting_keys = array();
	    for ($flag = 0; $flag < count($album_css); $flag++) {
	        array_push($setting_keys, $album_css[$flag]->setting_key);
	    }
		$index = array_search("lightbox_type", $setting_keys);
	    $lightbox_type = $album_css[$index]->setting_value;
	}
    wp_enqueue_script("jquery");
    wp_enqueue_script("jquery-ui-draggable");
    wp_enqueue_script("jquery-ui-sortable");
    wp_enqueue_script("farbtastic");
    wp_enqueue_script("imgLiquid.js", GALLERY_BK_PLUGIN_URL . "/assets/js/imgLiquid.js");
    wp_enqueue_script("jquery.dataTables.min.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.dataTables.min.js");
    wp_enqueue_script("jquery.validate.min.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.validate.min.js");
    wp_enqueue_script("plupload.full.min.js", GALLERY_BK_PLUGIN_URL . "/assets/js/plupload.full.min.js");
    wp_enqueue_script("jquery.plupload.queue.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.plupload.queue.js");
	wp_enqueue_script("jPages.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jPages.js");
    wp_enqueue_script("jquery.Tooltip.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.Tooltip.js");
    wp_enqueue_script("bootstrap.js", GALLERY_BK_PLUGIN_URL . "/assets/js/bootstrap.js");
	switch($lightbox_type)
	{
		case "pretty_photo":
			wp_enqueue_script("jquery.prettyPhoto.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.prettyPhoto.js");
		break;
		case "color_box":
			wp_enqueue_script("jquery.colorbox.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.colorbox.js");
		break;
		case "photo_swipe":
			wp_enqueue_script("simple-inheritance.min.js", GALLERY_BK_PLUGIN_URL . "/assets/js/simple-inheritance.min.js");
			wp_enqueue_script("code-photoswipe-1.0.11.min.js", GALLERY_BK_PLUGIN_URL . "/assets/js/code-photoswipe-1.0.11.min.js");
		break;
		case "fancy_box":
			wp_enqueue_script("jquery.fancybox.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.fancybox.js");
			wp_enqueue_script("jquery.fancybox-buttons.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.fancybox-buttons.js");
			wp_enqueue_script("jquery.fancybox-media.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.fancybox-media.js");
		break;
		case "lightbox2":
			wp_enqueue_script("lightbox-2.6.min.js", GALLERY_BK_PLUGIN_URL . "/assets/js/lightbox-2.6.min.js");
		break;
		case "GB_lightbox":
			wp_enqueue_script("gallery_bank.js", GALLERY_BK_PLUGIN_URL . "/assets/js/gallery_bank.js");
		break;
	}
}

function frontend_plugin_js_scripts_gallery_bank()
{
	global $wpdb;
	$album_css = $wpdb->get_results
    (
        "SELECT * FROM " . gallery_bank_settings()
    );
	if (count($album_css) != 0) {
	    $setting_keys = array();
	    for ($flag = 0; $flag < count($album_css); $flag++) {
	        array_push($setting_keys, $album_css[$flag]->setting_key);
	    }
		$index = array_search("lightbox_type", $setting_keys);
	    $lightbox_type = $album_css[$index]->setting_value;
	}
    wp_enqueue_script("jquery");
    wp_enqueue_script("jquery.masonry.min.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.masonry.min.js");
    wp_enqueue_script("isotope.pkgd.js", GALLERY_BK_PLUGIN_URL . "/assets/js/isotope.pkgd.js");
    wp_enqueue_script("imgLiquid.js", GALLERY_BK_PLUGIN_URL . "/assets/js/imgLiquid.js");
    wp_enqueue_script("jPages.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jPages.js");
	switch($lightbox_type)
	{
		case "pretty_photo":
			 wp_enqueue_script("jquery.prettyPhoto.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.prettyPhoto.js");
		break;
		case "color_box":
			wp_enqueue_script("jquery.colorbox.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.colorbox.js");
		break;
		case "photo_swipe":
			wp_enqueue_script("simple-inheritance.min.js", GALLERY_BK_PLUGIN_URL . "/assets/js/simple-inheritance.min.js");
			wp_enqueue_script("code-photoswipe-1.0.11.min.js", GALLERY_BK_PLUGIN_URL . "/assets/js/code-photoswipe-1.0.11.min.js");
		break;
		case "fancy_box":
			wp_enqueue_script("jquery.fancybox.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.fancybox.js");
			wp_enqueue_script("jquery.fancybox-buttons.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.fancybox-buttons.js");
			wp_enqueue_script("jquery.fancybox-media.js", GALLERY_BK_PLUGIN_URL . "/assets/js/jquery.fancybox-media.js");
		break;
		case "lightbox2":
			wp_enqueue_script("lightbox-2.6.min.js", GALLERY_BK_PLUGIN_URL . "/assets/js/lightbox-2.6.min.js");
		break;
		case "GB_lightbox":
			wp_enqueue_script("gallery_bank.js", GALLERY_BK_PLUGIN_URL . "/assets/js/gallery_bank.js");
		break;
	}
}

//--------------------------------------------------------------------------------------------------------------//
// CODE FOR CALLING STYLE SHEETS
function backend_css_calls()
{
	global $wpdb;
	$album_css = $wpdb->get_results
    (
        "SELECT * FROM " . gallery_bank_settings()
    );
	if (count($album_css) != 0) {
	    $setting_keys = array();
	    for ($flag = 0; $flag < count($album_css); $flag++) {
	        array_push($setting_keys, $album_css[$flag]->setting_key);
	    }
		$index = array_search("lightbox_type", $setting_keys);
	    $lightbox_type = $album_css[$index]->setting_value;
	}
    wp_enqueue_style("farbtastic");
    wp_enqueue_style("jquery.plupload.queue.css", GALLERY_BK_PLUGIN_URL . "/assets/css/jquery.plupload.queue.css");
    wp_enqueue_style("stylesheet.css", GALLERY_BK_PLUGIN_URL . "/assets/css/stylesheet.css");
    wp_enqueue_style("font-awesome.css", GALLERY_BK_PLUGIN_URL . "/assets/css/font-awesome/css/font-awesome.css");
    wp_enqueue_style("system-message.css", GALLERY_BK_PLUGIN_URL . "/assets/css/system-message.css");
    wp_enqueue_style("gallery-bank.css", GALLERY_BK_PLUGIN_URL . "/assets/css/gallery-bank.css");
	wp_enqueue_style("jPages.css", GALLERY_BK_PLUGIN_URL . "/assets/css/jPages.css");
	switch($lightbox_type)
	{
		case "pretty_photo":
			 wp_enqueue_style("prettyPhoto.css", GALLERY_BK_PLUGIN_URL . "/assets/css/prettyPhoto.css");
		break;
		case "color_box":
			wp_enqueue_style("colorbox.css", GALLERY_BK_PLUGIN_URL . "/assets/css/colorbox.css");
		break;
		case "photo_swipe":
			wp_enqueue_style("photoswipe.css", GALLERY_BK_PLUGIN_URL . "/assets/css/photoswipe.css");
		break;
		case "fancy_box":
			wp_enqueue_style("jquery.fancybox.css", GALLERY_BK_PLUGIN_URL . "/assets/css/jquery.fancybox.css");
			wp_enqueue_style("jquery.fancybox-buttons.css", GALLERY_BK_PLUGIN_URL . "/assets/css/jquery.fancybox-buttons.css");
		break;
		case "lightbox2":
			wp_enqueue_style("lightbox.css", GALLERY_BK_PLUGIN_URL . "/assets/css/lightbox.css");
		break;
	}
}

function frontend_plugin_css_scripts_gallery_bank()
{
	global $wpdb;
	$album_css = $wpdb->get_results
    (
        "SELECT * FROM " . gallery_bank_settings()
    );
	if (count($album_css) != 0) {
	    $setting_keys = array();
	    for ($flag = 0; $flag < count($album_css); $flag++) {
	        array_push($setting_keys, $album_css[$flag]->setting_key);
	    }
		$index = array_search("lightbox_type", $setting_keys);
	    $lightbox_type = $album_css[$index]->setting_value;
	}
    wp_enqueue_style("gallery-bank.css", GALLERY_BK_PLUGIN_URL . "/assets/css/gallery-bank.css");
    wp_enqueue_style("jPages.css", GALLERY_BK_PLUGIN_URL . "/assets/css/jPages.css");
    wp_enqueue_style("animate.css", GALLERY_BK_PLUGIN_URL . "/assets/css/animate.css");
    wp_enqueue_style("hover_effects.css", GALLERY_BK_PLUGIN_URL . "/assets/css/hover_effects.css");
	switch($lightbox_type)
	{
		case "pretty_photo":
			 wp_enqueue_style("prettyPhoto.css", GALLERY_BK_PLUGIN_URL . "/assets/css/prettyPhoto.css");
		break;
		case "color_box":
			wp_enqueue_style("colorbox.css", GALLERY_BK_PLUGIN_URL . "/assets/css/colorbox.css");
		break;
		case "photo_swipe":
			wp_enqueue_style("photoswipe.css", GALLERY_BK_PLUGIN_URL . "/assets/css/photoswipe.css");
		break;
		case "fancy_box":
			wp_enqueue_style("jquery.fancybox.css", GALLERY_BK_PLUGIN_URL . "/assets/css/jquery.fancybox.css");
			wp_enqueue_style("jquery.fancybox-buttons.css", GALLERY_BK_PLUGIN_URL . "/assets/css/jquery.fancybox-buttons.css");
		break;
		case "lightbox2":
			wp_enqueue_style("lightbox.css", GALLERY_BK_PLUGIN_URL . "/assets/css/lightbox.css");
		break;
	}
}

//--------------------------------------------------------------------------------------------------------------//
// REGISTER AJAX BASED FUNCTIONS TO BE CALLED ON ACTION TYPE AS PER WORDPRESS GUIDELINES
//--------------------------------------------------------------------------------------------------------------//
if (isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case "add_new_album_library":
            add_action("admin_init", "album_gallery_library");
            function album_gallery_library()
            {
                include_once GALLERY_BK_PLUGIN_DIR . "/lib/add-new-album-class.php";
            }
            break;
        case "settings_gallery_library":

            add_action("admin_init", "settings_gallery_library");
            function settings_gallery_library()
            {
                include_once GALLERY_BK_PLUGIN_DIR . "/lib/gallery-bank-settings-class.php";
            }
            break;
        case "front_view_all_albums_library":
            add_action("admin_init", "front_view_all_albums_library");
            function front_view_all_albums_library()
            {
                include_once GALLERY_BK_PLUGIN_DIR . "/lib/front-view-all-albums-class.php";
            }
            break;
    }
}

/*****************************************************************************************************************/
function gallery_bank_enqueue_pointer_script_style()
{
    $enqueue_pointer_script_style = false;

    // Get array list of dismissed pointers for current user and convert it to array

    $dismissed_pointers = explode(",", get_user_meta(get_current_user_id(), "dismissed_wp_pointers", true));

    // Check if our pointer is not among dismissed ones
    if (!in_array("gallery_bank_pointer", $dismissed_pointers)) {
        $enqueue_pointer_script_style = true;

        // Add footer scripts using callback function
        add_action("admin_print_footer_scripts", "gallery_bank_pointer_print_scripts");
    }

    // Enqueue pointer CSS and JS files, if needed
    if ($enqueue_pointer_script_style) {
        wp_enqueue_style("wp-pointer");
        wp_enqueue_script("wp-pointer");
    }
}

add_action("admin_enqueue_scripts", "gallery_bank_enqueue_pointer_script_style");

function gallery_bank_pointer_print_scripts()
{

    $pointer_content = "<h3>Gallery Bank</h3>";
    $pointer_content .= "<p>If you are using Gallery Bank for the first time, you can view this <a href='' target='_blank'>video</a> to setup the Plugin.</p>";
    ?>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $("#toplevel_page_gallery_bank").pointer({
                content: "<?php echo $pointer_content; ?>",
                position: {
                    edge: "left", // arrow direction
                    align: "center" // vertical alignment
                },
                pointerWidth: 350,
                close: function () {
                    $.post(ajaxurl, {
                        pointer: "gallery_bank_pointer", // pointer ID
                        action: "dismiss-wp-pointer"
                    });
                }
            }).pointer("open");
        });
    </script>

<?php
}

/**************************************************************************************************/
add_action("media_buttons_context", "add_gallery_shortcode_button", 1);
function add_gallery_shortcode_button($context)
{
    add_thickbox();
    $context .= "<a href=\"#TB_inline?width=500&height=600&inlineId=my-gallery-content-id\"  class=\"button thickbox\"
     title=\"" . __("Add Gallery using Gallery Bank", gallery_bank) . "\"><span class=\"gallery_icon\"></span> Gallery Bank</a>";
    return $context;
}

add_action("admin_footer", "add_gallery_bank_popup");

function add_gallery_bank_popup()
{
    add_thickbox();
    require_once GALLERY_BK_PLUGIN_DIR . "/front_views/gallery-bank-shortcode.php";
}

function gallery_bank_short_code($atts)
{
    extract(shortcode_atts(array(
        "album_id" => "",
        "type" => "",
        "format" => "",
        "title" => "",
        "desc" => "",
        "img_in_row" => "",
        "responsive" => "",
        "albums_in_row" => "",
        "special_effect" => "",
        "animation_effect" => "",
        "image_width" => "",
        "album_title" => "",
        "thumb_width" => "",
        "thumb_height" => "",
        "widget" => "",
    ), $atts));
    return extract_short_code_for_gallery_images($album_id, $type, $format, $title, $desc, $img_in_row, $responsive, $albums_in_row, $special_effect, $animation_effect, $image_width, $album_title, $thumb_width, $thumb_height, $widget);
}

if (!wp_next_scheduled("GalleryBankUpdation"))
{
	wp_schedule_event(time(), "daily", "GalleryBankUpdation");
}
add_action("GalleryBankUpdation", "gallery_bank_updation_check");
function gallery_bank_updation_check()
{
	global $wpdb;
	$updation_keys = $wpdb->get_row
	(
	    "SELECT * FROM " . gallery_bank_licensing()
	);
	$url = get_option("gallery-bank-updation-check-url");
	$response = wp_remote_post($url, array
		(
			"method" => "POST",
			"timeout" => 45,
			"redirection" => 5,
			"httpversion" => "1.0",
			"blocking" => true,
			"headers" => array(),
			"body" => array( "ux_product_key" => "17130", "ux_domain" => $updation_keys->url, "ux_order_id" => $updation_keys->order_id, "ux_api_key"=>$updation_keys->api_key,"param"=>"check_license","action"=>"license_validator")
		)
	);

	if ( is_wp_error( $response ) )
	{
		delete_option("gallery-bank-activation");
	}
	else
	{
		$response["body"] == "" ? update_option("gallery-bank-activation",$updation_keys->api_key) : delete_option("gallery-bank-activation");
	}
}
function extract_short_code_for_gallery_images($album_id, $album_type, $gallery_type, $img_title, $img_desc, $img_in_row, $responsive, $albums_in_row, $special_effect, $animation_effect, $image_width, $album_title, $thumb_width, $thumb_height, $widget)
{
    ob_start();
    global $wpdb;
    include GALLERY_BK_PLUGIN_DIR . "/front_views/includes_common_before.php";

    switch ($album_type) {
        case "images":
            switch ($gallery_type) {
                case "masonry":
                    include GALLERY_BK_PLUGIN_DIR . "/front_views/masonry-gallery.php";
                    break;
                case "filmstrip":
                    include GALLERY_BK_PLUGIN_DIR . "/front_views/filmstrip-slides.php";
                    break;
                case "blog":
                    include GALLERY_BK_PLUGIN_DIR . "/front_views/blog-gallery.php";
                    break;
                case "slideshow":
                    include GALLERY_BK_PLUGIN_DIR . "/front_views/slideShow_view.php";
                    break;
                case "thumbnail":
                    include GALLERY_BK_PLUGIN_DIR . "/front_views/thumbnail-gallery.php";
                    break;
            }
            break;
        case "grid":
            include GALLERY_BK_PLUGIN_DIR . "/front_views/grid-albums.php";
            break;
        case "list":
            include GALLERY_BK_PLUGIN_DIR . "/front_views/listed-album.php";
            break;
        case "individual":
            include GALLERY_BK_PLUGIN_DIR . "/front_views/single-album.php";
            break;
    }
    include GALLERY_BK_PLUGIN_DIR . "/front_views/includes_common_after.php";
    $gallery_bank_output_album = ob_get_clean();
    wp_reset_query();
    return $gallery_bank_output_album;
}

function array_iunique($array)
{
    return array_intersect_key(
        $array,
        array_unique(array_map("StrToUpper", $array))
    );
}


/*****************************************************************************************************************/
add_shortcode("gallery_bank", "gallery_bank_short_code");
add_action("admin_init", "backend_scripts_calls");
add_action("admin_init", "backend_css_calls");
add_action("init", "frontend_plugin_js_scripts_gallery_bank");
add_action("init", "frontend_plugin_css_scripts_gallery_bank");
add_action("admin_menu", "create_global_menus_for_gallery_bank");
add_filter("widget_text", "do_shortcode");
add_action("widgets_init", create_function("", "return register_widget(\"GalleryAllAlbumsWidget\");"));
include GALLERY_BK_PLUGIN_DIR . "/lib/include_widget.php";
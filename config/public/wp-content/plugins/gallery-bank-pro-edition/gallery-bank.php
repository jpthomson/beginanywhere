<?php
/*
 Plugin Name: Gallery Bank Pro Edition
 Plugin URI: http://tech-banker.com
 Description: Gallery Bank is an interactive WordPress photo gallery plugin, best fit for creative and corporate portfolio websites.
 Author: Tech Banker
 Version: 3.8.4
 Author URI: http://tech-banker.com
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Define   Constants  ///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (!defined("GALLERY_DEBUG_MODE")) define("GALLERY_DEBUG_MODE", false);
if (!defined("GALLERY_BK_FILE")) define("GALLERY_BK_FILE", __FILE__);
if (!defined("GALLERY_CONTENT_DIR")) define("GALLERY_CONTENT_DIR", ABSPATH . "wp-content");

if (!defined("GALLERY_MAIN_DIR")) define("GALLERY_MAIN_DIR", ABSPATH . "wp-content/gallery-bank");
if (!defined("GALLERY_MAIN_UPLOAD_DIR")) define("GALLERY_MAIN_UPLOAD_DIR", ABSPATH . "wp-content/gallery-bank/gallery-uploads/");
if (!defined("GALLERY_MAIN_THUMB_DIR")) define("GALLERY_MAIN_THUMB_DIR", ABSPATH . "wp-content/gallery-bank/thumbs/");
if (!defined("GALLERY_MAIN_ALB_THUMB_DIR")) define("GALLERY_MAIN_ALB_THUMB_DIR", ABSPATH . "wp-content/gallery-bank/album-thumbs/");
if (!defined("GALLERY_CONTENT_URL")) define("GALLERY_CONTENT_URL", site_url() . "/wp-content");
if (!defined("GALLERY_PLUGIN_DIR")) define("GALLERY_PLUGIN_DIR", GALLERY_CONTENT_DIR . "/plugins");
if (!defined("GALLERY_PLUGIN_URL")) define("GALLERY_PLUGIN_URL", GALLERY_CONTENT_URL . "/plugins");
if (!defined("GALLERY_BK_PLUGIN_FILENAME")) define("GALLERY_BK_PLUGIN_FILENAME", basename(__FILE__));
if (!defined("GALLERY_BK_PLUGIN_DIRNAME")) define("GALLERY_BK_PLUGIN_DIRNAME", plugin_basename(dirname(__FILE__)));
if (!defined("GALLERY_BK_PLUGIN_DIR")) define("GALLERY_BK_PLUGIN_DIR", GALLERY_PLUGIN_DIR . "/" . GALLERY_BK_PLUGIN_DIRNAME);
if (!defined("GALLERY_BK_PLUGIN_URL")) define("GALLERY_BK_PLUGIN_URL", site_url() . "/wp-content/plugins/" . GALLERY_BK_PLUGIN_DIRNAME);
if (!defined("GALLERY_BK_THUMB_URL")) define("GALLERY_BK_THUMB_URL", site_url() . "/wp-content/gallery-bank/gallery-uploads/");
if (!defined("GALLERY_BK_THUMB_SMALL_URL")) define("GALLERY_BK_THUMB_SMALL_URL", site_url() . "/wp-content/gallery-bank/thumbs/");
if (!defined("GALLERY_BK_ALBUM_THUMB_URL")) define("GALLERY_BK_ALBUM_THUMB_URL", site_url() . "/wp-content/gallery-bank/album-thumbs/");
if (!defined("GALLERY_BK_THUMB_WP_UPLOADS_URL")) define("GALLERY_BK_THUMB_WP_UPLOADS_URL", site_url() . "/wp-content");
if (!defined("gallery_bank")) define("gallery_bank", "gallery-bank");

if (!is_dir(GALLERY_MAIN_DIR))
{
	wp_mkdir_p(GALLERY_MAIN_DIR);
}
if (!is_dir(GALLERY_MAIN_UPLOAD_DIR))
{
	wp_mkdir_p(GALLERY_MAIN_UPLOAD_DIR);
}
if (!is_dir(GALLERY_MAIN_THUMB_DIR))
{
	wp_mkdir_p(GALLERY_MAIN_THUMB_DIR);
}
if (!is_dir(GALLERY_MAIN_ALB_THUMB_DIR))
{
	wp_mkdir_p(GALLERY_MAIN_ALB_THUMB_DIR);
}
require_once(GALLERY_BK_PLUGIN_DIR."/plugin-updates/plugin-update-checker.php");
$MyUpdateChecker = new PluginUpdateChecker(
    'http://tech-banker.com/wp-content/plugins/gallery-bank-pro-edition-3.1/lib/update-pro-edition.json',
    __FILE__,
    'gallery-bank-pro-edition'
);
/*************************************************************************************/
if (file_exists(GALLERY_BK_PLUGIN_DIR . "/lib/gallery-bank-class.php")) {
    require_once(GALLERY_BK_PLUGIN_DIR . "/lib/gallery-bank-class.php");
}
/*************************************************************************************/
function plugin_install_script_for_gallery_bank()
{
    include_once GALLERY_BK_PLUGIN_DIR . "/lib/install-script.php";
}

/*************************************************************************************/
function plugin_uninstall_script_for_gallery_bank()
{
}

/*************************************************************************************/
function gallery_bank_plugin_load_text_domain()
{
    if (function_exists("load_plugin_textdomain")) {
        load_plugin_textdomain(gallery_bank, false, GALLERY_BK_PLUGIN_DIRNAME . "/lang");
    }
}

/*************************************************************************************/
function add_gallery_bank_icon($meta = TRUE)
{
    global $wp_admin_bar;
    global $current_user, $wpdb;
    $role = $wpdb->prefix . "capabilities";
    $current_user->role = array_keys($current_user->$role);
    $role = $current_user->role[0];
    if (!is_user_logged_in()) {
        return;
    }

    include GALLERY_BK_PLUGIN_DIR . "/lib/include_roles_settings.php";
	$last_album_id = $wpdb->get_var
	(
		"SELECT album_id FROM " .gallery_bank_albums(). " order by album_id desc limit 1"
	);
	$id = count($last_album_id) == 0 ? 1 : $last_album_id + 1;
    switch ($role) {
        case "administrator":
            if ($admin_full_control == "0" && $admin_read_control == "1" && $admin_write_control == "0") {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );
            } elseif ($admin_full_control == "0" && ($admin_read_control == "1" || $admin_write_control == "1")) {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "add_new_album_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=save_album&album_id=".$id,
                    "title" => __("Add New Album", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "sorting_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_album_sorting",
                    "title" => __("Album Sorting", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );
            } else {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "add_new_album_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=save_album&album_id=".$id,
                    "title" => __("Add New Album", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "sorting_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_album_sorting",
                    "title" => __("Album Sorting", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "global_settings_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=global_settings",
                    "title" => __("Global Settings", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "system_status_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_system_status",
                    "title" => __("System Status", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "Licensing_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_licensing",
                    "title" => __("Licensing", gallery_bank))
                );

            }
            break;
        case "editor":
            if ($editor_full_control == "0" && $editor_read_control == "1" && $editor_write_control == "0") {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );
            } elseif ($editor_full_control == "0" && ($editor_read_control == "1" || $editor_write_control == "1")) {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "add_new_album_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=save_album&album_id=".$id,
                    "title" => __("Add New Album", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "sorting_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_album_sorting",
                    "title" => __("Album Sorting", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );
            } else {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "add_new_album_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=save_album&album_id=".$id,
                    "title" => __("Add New Album", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "sorting_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_album_sorting",
                    "title" => __("Album Sorting", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "global_settings_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=global_settings",
                    "title" => __("Global Settings", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "system_status_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_system_status",
                    "title" => __("System Status", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "Licensing_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_licensing",
                    "title" => __("Licensing", gallery_bank))
                );
            }
            break;
        case "author":
            if ($author_full_control == "0" && $author_read_control == "1" && $author_write_control == "0") {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );
            } elseif ($author_full_control == "0" && ($author_read_control == "1" || $author_write_control == "1")) {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "add_new_album_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=save_album&album_id=".$id,
                    "title" => __("Add New Album", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "sorting_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_album_sorting",
                    "title" => __("Album Sorting", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );
            } else {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "add_new_album_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=save_album&album_id=".$id,
                    "title" => __("Add New Album", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "sorting_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_album_sorting",
                    "title" => __("Album Sorting", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "global_settings_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=global_settings",
                    "title" => __("Global Settings", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "system_status_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_system_status",
                    "title" => __("System Status", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "Licensing_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_licensing",
                    "title" => __("Licensing", gallery_bank))
                );
            }
            break;
        case "contributor":
            if ($contributor_full_control == "0" && $contributor_read_control == "1" && $contributor_write_control == "0") {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );
            } elseif ($contributor_full_control == "0" && ($contributor_read_control == "1" || $contributor_write_control == "1")) {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "add_new_album_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=save_album&album_id=".$id,
                    "title" => __("Add New Album", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "sorting_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_album_sorting",
                    "title" => __("Album Sorting", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );
            } else {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "add_new_album_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=save_album&album_id=".$id,
                    "title" => __("Add New Album", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "sorting_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_album_sorting",
                    "title" => __("Album Sorting", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "global_settings_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=global_settings",
                    "title" => __("Global Settings", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "system_status_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_system_status",
                    "title" => __("System Status", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "Licensing_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_licensing",
                    "title" => __("Licensing", gallery_bank))
                );
            }
            break;
        case "subscriber":
            if ($subscriber_full_control == "0" && $subscriber_read_control == "1" && $subscriber_write_control == "0") {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );
            } elseif ($subscriber_full_control == "0" && ($subscriber_read_control == "1" || $subscriber_write_control == "1")) {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "add_new_album_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=save_album&album_id=".$id,
                    "title" => __("Add New Album", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "sorting_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_album_sorting",
                    "title" => __("Album Sorting", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );
            } else {
                $wp_admin_bar->add_menu(array(
                    "id" => "gallery_bank_links",
                    "title" => __("<img src=\"" . GALLERY_BK_PLUGIN_URL . "/assets/images/icon.png\" width=\"25\"
                    height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />Gallery Bank"),
                    "href" => __(site_url() . "/wp-admin/admin.php?page=gallery_bank"),
                ));

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "dashboard_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank",
                    "title" => __("Dashboard", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "add_new_album_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=save_album&album_id=".$id,
                    "title" => __("Add New Album", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "sorting_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_album_sorting",
                    "title" => __("Album Sorting", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "global_settings_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=global_settings",
                    "title" => __("Global Settings", gallery_bank))
                );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "system_status_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_system_status",
                    "title" => __("System Status", gallery_bank))
                );

                // $wp_admin_bar->add_menu(array(
                    // "parent" => "gallery_bank_links",
                    // "id" => "documentation_links",
                    // "href" => site_url() . "/wp-admin/admin.php?page=gallery_bank_documentation",
                    // "title" => __("Documentation", gallery_bank))
                // );

                $wp_admin_bar->add_menu(array(
                    "parent" => "gallery_bank_links",
                    "id" => "Licensing_links",
                    "href" => site_url() . "/wp-admin/admin.php?page=gallery_licensing",
                    "title" => __("Licensing", gallery_bank))
                );
            }
        break;
    }
}
/*************************************************************************************/
$version = get_option("gallery-bank-pro-edition");
if($version == "" || $version != "")
{
	add_action("admin_init", "plugin_install_script_for_gallery_bank");
} 
add_action("admin_bar_menu", "add_gallery_bank_icon", 100);
add_action("plugins_loaded", "gallery_bank_plugin_load_text_domain");
register_activation_hook(__FILE__, "plugin_install_script_for_gallery_bank");
register_uninstall_hook(__FILE__, "plugin_uninstall_script_for_gallery_bank");
/*************************************************************************************/
?>
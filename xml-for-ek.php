<?php
/*
Plugin Name: XML для E-katalog 
Description: Плагин генерирует XML для E-katalog (ek.ua). Подключите свой WooCommerce-магазин к Ek.ua и увеличьте продажи!
Version: 1.0.0
Author: Ruslan Heorhiiev, nadavitradesystems
Text Domain: ekatxml
Domain Path: /assets/languages/
*/


if (!ABSPATH OR !is_admin() OR !class_exists('WooCommerce')) {
    return;
}


define('EKATWOO', __FILE__);
define('EKATWOO_DIR', plugin_dir_path(EKATWOO));
define('EKATWOO_INC', EKATWOO_DIR . 'inc/');
define('EKATWOO_TEMPLATES', EKATWOO_DIR . 'templates/');
define('EKATWOO_ASSETS_DIR', EKATWOO_DIR . 'assets/');
define('EKATWOO_ASSETS_URL', plugin_dir_url(EKATWOO) . 'assets/');
define('EKATWOO_DOMAIN', 'ekatxml');
define('EKATWOO_V', '1.0.0');


include EKATWOO_INC . 'classes/load.php';
include EKATWOO_INC . 'hooks.php';
include EKATWOO_INC . 'admin.php';    

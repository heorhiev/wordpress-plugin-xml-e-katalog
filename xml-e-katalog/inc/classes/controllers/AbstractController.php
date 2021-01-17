<?php
/**
 * Класс создания страниц в админке.
 *
 * @package EKatWoo
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace EKatWoo\Controllers;

use EKatWoo\Services\Request;
use EKatWoo\Services\Render;
use EKatWoo\Repositories\Settings;

abstract class AbstractController {
   
    // Slug страницы
    protected static $pageSlug = '';

    // Шаблон страницы
    protected static $pageTemplate = '';

    // Title страницы
    protected static $pageTitle = '';

    // Иконка в меню
    protected static $pageIcon = '';

    // стили
    protected static $pageEnqueues = [];
    
    
    /**
     * События
     */      
    //abstract protected static function beforeAction();


	// class constructor
	public function __construct() {       
		add_filter('set-screen-option', [$this, 'setScreen'], 10, 3);
        add_action('admin_menu', [$this, 'pluginMenu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);     
	}
    

	public static function setScreen($status, $option, $value) {
		return $value;
    }
    

    /**
     * Добавляет пункт меню
     */    
	public function pluginMenu() {	 
               
        $hook = add_menu_page( 
            static::$pageTitle, 
            static::$pageTitle, 
            'manage_options', 
            static::$pageSlug, 
            [$this, 'render'],
            static::$pageIcon,
            55
        );

        if (static::isCurrentPage()) {
            $action = Request::get('action') . 'Action';

            if (method_exists($this, $action)) {
                $this->$action();
            }
        }
    }    
    
    
	/**
	 * Страница
	 */
	public function render() {
        Render::template(static::$pageTemplate, [
            '_this'        => $this,
            'fields_key'   => static::$pageSlug,
            'notification' => static::formatedData(Request::get(static::$pageSlug)),
        ]);
    }          
         
    
    /**
     * Возращает url
     */
    public static function getUrl($args = []) {
        $args = array_merge([
            'page' => static::$pageSlug,
        ], $args);                
        
        return add_query_arg($args, '/wp-admin/admin.php');
    }   

    
    /**
     * Подключение скриптов и стилей
     */    
    public static function enqueueScripts($path = '') {
        //if ($path != 'toplevel_page_' . static::$pageSlug) {
        if (!self::isCurrentPage()) {
            return;
        }       
        
        // Стили
        if (isset(static::$pageEnqueues['css']) && static::$pageEnqueues['css']) {
            foreach (static::$pageEnqueues['css'] as $name) {
                wp_enqueue_style(
                    $name,
                     EKATWOO_ASSETS_URL . 'css/' . $name . '.css',
                     [],
                     EKATWOO_V
                 );
            }
        }
    } 
    
    
    /**
     * Текущая ли страница
     */      
    protected static function isCurrentPage() {
        return static::$pageSlug === Request::get('page');
    }
    
    
    /**
     * Данные
     */      
    protected static function formatedData() {
        return [];
    }
}
<?php
/**
 * Файл класса настроек
 *
 * @package EKatWoo
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */


namespace EKatWoo\Repositories;


class Settings {

    // структура полей опции
    private static $struct = [
        'name'         => '',
        'currency'     => '',
        'desc_param'   => '',
        'exclude_cats' => [],
    ];

    // значения опции
    private static $options = [];


    /**
     * Возвращает название
     */
    public static function getName() {
        return self::getOption(
            'name', 
            get_bloginfo('name')
        );
    }


    /**
     * Возвращает url сайта
     */
    public static function getUrl() {
        return get_bloginfo('url');
    }


    /**
     * Возвращает url сайта
     */
    public static function getExcludeCategories() {
        return self::getOption('exclude_cats');
    }


    /**
     * Возвращает параметр товара
     */
    public static function getDescParam() {
        return self::getOption('desc_param');
    }


    /**
     * Возвращает валюту
     */
    public static function getCurrency() {
        return self::getOption(
            'currency', 
            get_woocommerce_currency()
        );
    }
    

    /**
     * Возвращает имя XML файла
     */
    public static function getXmlFileName() {
        $salt = mb_strimwidth(md5(md5(NONCE_SALT)), 5, 10);

        return 'e-katalog-' . $salt . '.xml';
    }


    /**
     * Возвращает путь к XML файлу
     */
    public static function getXmlFileDir() {
        $uploadDir = wp_upload_dir();        
        return $uploadDir['basedir'] . '/' . self::getXmlFileName();
    }


    /**
     * Возвращает url к XML файлу
     */
    public static function getXmlFileUrl() {
        $uploadDir = wp_upload_dir();        
        return $uploadDir['baseurl'] . '/' . self::getXmlFileName();
    }


    /**
     * Сохранение настроек
     */
    public static function save($settings) {
        update_option('ekatwoo', self::sanitize($settings), 'no');
    }


    /**
     * Возвращает опцию
     */
    public static function getOption($key, $default = '') {
        if (!self::$options) {
            self::$options = get_option('ekatwoo');
        }

        return isset(self::$options[$key]) ? self::$options[$key] : $default;
    }


    /**
     * Очищает переданный массив
     */
    private static function sanitize($settings) {
        // валидация структуры
        $settings = shortcode_atts(self::$struct, $settings);

        foreach ($settings as $key => &$value) {
            if (is_array($value)) {
                $value = array_map('intval', $value);
            } elseif ($value) {
                $value = sanitize_text_field($value);
            }
        }        

        return $settings;
    }
}
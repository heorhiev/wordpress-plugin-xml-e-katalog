<?php
/**
 * Класс запросов.
 *
 * @package Intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace EKatWoo\Services;  

class Request {

    // разрешенные параметры
    private static $approved = [
        'settings',
        'action',
        'name',
        'currency',
        'desc_param',
        'exclude_cats',
        'page',
    ];

    /**
     * Получение Request значения
    **/
    public static function get($key, $default = null) {
        $_request = self::sanitizeArray($_REQUEST);        
        $_request = self::valid($_request);        

        if (isset($_request[$key])) {
            return $_request[$key];
        }

        return $default;
    }


    /**
     * Очищает переданный массив
     * рекурсивный метод
     */
    private static function sanitizeArray($array) {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value = self::sanitizeArray($value);
            } else {
                $value = stripslashes_deep($value);
                $value = sanitize_text_field($value);                
                $value = esc_html($value);                
            }
        }

        return $array;
    }


    /**
     * Валидация входящих данных
     */
    private static function valid($array) {
        foreach ($array as $key => &$value) {
            if (!in_array($key, self::$approved)) {
                unset($array[$key]);
            }
        }

        return $array;
    }
}
<?php
/**
 * Файл класса рендирования
 *
 * @package EKatWoo
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace EKatWoo\Services; 
 
class Render {
    
    /**
     * Отобразить шаблон 
    **/
    public static function template(string $filename, array $attributes = []) {
        if ($attributes) {
            extract($attributes);    
        }       

        include(EKATWOO_TEMPLATES . $filename . '.php');         
    }  
    
    /**
     * Получить шаблон 
    **/    
    public static function get(string $filename, array $attributes = []) {  
        ob_start();
        
        self::template($filename, $attributes); 
        
        return trim(ob_get_clean());   
    }
}    
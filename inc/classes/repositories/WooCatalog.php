<?php
/**
 * Файл класса калатога
 *
 * @package EKatWoo
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */


namespace EKatWoo\Repositories;


class WooCatalog {

    /**
     * Возвращает продукты
     */
    public static function getProducts($args = []) {
        $args = shortcode_atts([
            'exclude_category' => [],
        ], $args);

        return wc_get_products($args);
    }


    /**
     * Возвращает категории
     */
    public static function getTerms($args = []) {
        $args = shortcode_atts([
            'exclude'  => [],
            'taxonomy' => 'product_cat',
        ], $args);

        return get_terms($args);
    }
}
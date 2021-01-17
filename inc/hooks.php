<?php
/**
 * Хуки.
 *
 * @package EKatWoo
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 

/**
 * Функция инициализации
 * Применяется к событию plugins_loaded
 */
function ekatxml_init() {
	load_plugin_textdomain( 
        EKATWOO_DOMAIN, 
        false, 
        EKATWOO_ASSETS_DIR . 'languages/' 
    );
}

add_action('plugins_loaded', 'ekatxml_init' , 20);


/**
 * Функция установки multiple для wp_dropdown_categories
 * Применяется к фильтру wp_dropdown_cats
 */
function ekatwoo_filter_wp_dropdown_cats_multiple($output, $r) {

    if (isset($r['multiple']) && $r['multiple']) {

        $output = preg_replace( '/^<select/i', '<select multiple', $output );

        foreach (array_map('trim', explode(',', $r['selected'])) as $value) {
            $output = str_replace(                
                'value="' . $value . '"',
                'value="' . $value . '" selected',
                $output
            );
        }        
    }

    return $output;
}

add_filter('wp_dropdown_cats', 'ekatwoo_filter_wp_dropdown_cats_multiple', 10, 2);


/**
 * Функция исключения записей из указанных категорий
 * Применяется к фильтру woocommerce_product_data_store_cpt_get_products_query
 */
function ekatwoo_filer_exclude_category_woo_query($query, $query_vars) {
    if (!empty($query_vars['exclude_category'])) {
        $query['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'ID',
            'terms'    => $query_vars['exclude_category'],
            'operator' => 'NOT IN',
        );
    }

    return $query;
}

add_filter('woocommerce_product_data_store_cpt_get_products_query', 'ekatwoo_filer_exclude_category_woo_query', 10, 2);
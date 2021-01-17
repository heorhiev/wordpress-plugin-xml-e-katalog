<?php
/**
 * Файл вывода шаблона страницы отправки сообщений подписчикам
 *
 * @package EKatWoo
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
$settings = new EKatWoo\Repositories\Settings(); 
?>

<div id="e-kat-woo" class="wrap">
	
    <h2><?php _e('XML для E-Katalog', EKATWOO_DOMAIN); ?></h2>
    
    <?php settings_errors(); ?>
    
    <?php settings_fields('ekatwoo'); ?>
           
    <form 
        method="post" 
        action="<?= $_this::getUrl(); ?>" 
        class="form"
    >           
        <div class="group">        
            <div class="item">
                <h3><?php _e('Параметры', EKATWOO_DOMAIN); ?></h3>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <label for="settings_name"><?php _e('Название магазина', EKATWOO_DOMAIN); ?></label>
                        </th>
                        <td>  
                            <input 
                                id="settings_name"
                                type="text" 
                                name="settings[name]" 
                                value="<?= esc_attr($settings->getName()); ?>" 
                            />
                            <small class="desc"><?php _e('Короткое название магазина.', EKATWOO_DOMAIN); ?></small>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="settings_currency"><?php _e('Валюта', EKATWOO_DOMAIN); ?></label>
                        </th>
                        <td>  
                            <input 
                                id="settings_currency"
                                type="text" 
                                name="settings[currency]" 
                                value="<?= esc_attr($settings->getCurrency()); ?>" 
                            />
                            <small class="desc"><?php _e('Используемая валюта.', EKATWOO_DOMAIN); ?></small>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="settings_offer_param_desc_param"><?php _e('Описание товара', EKATWOO_DOMAIN); ?></label>
                        </th>
                        <td>
                            <select id="settings_offer_param_desc_param" name="settings[desc_param]">
                                <option value=""><?php _e('Краткое или полное описание', EKATWOO_DOMAIN); ?></option>
                                <option 
                                    value="short" 
                                    <?php selected('short', $settings->getDescParam()) ?>
                                ><?php _e('Краткое описание', EKATWOO_DOMAIN); ?></option>
                                <option 
                                    value="full"
                                    <?php selected('full', $settings->getDescParam()) ?>
                                ><?php _e('Полное описание', EKATWOO_DOMAIN); ?></option>
                            </select>
                            <small class="desc"><?php _e('Источник описания товара.', EKATWOO_DOMAIN); ?></small>
                        </td>
                    </tr> 
                    <tr valign="top">
                        <th scope="row">
                            <label for="settings_exclude_cats"><?php _e('Иключить категории', EKATWOO_DOMAIN); ?></label>
                        </th>
                        <td>  
                            <?php
                                wp_dropdown_categories([                                    
                                    'show_option_none'   => __('Ничего не выбрано', EKATWOO_DOMAIN),
                                    'option_none_value'  => -1,
                                    'orderby'            => 'name',
                                    'order'              => 'ASC',
                                    'selected'           => implode(',', (array)$settings->getExcludeCategories()),
                                    'hierarchical'       => true,
                                    'name'               => 'settings[exclude_cats][]',
                                    'id'                 => 'settings_exclude_cats',
                                    'taxonomy'           => 'product_cat',
                                    'hide_if_empty'      => true,
                                    'multiple'           => true
                                ]);
                            ?>
                            <small class="desc"><?php _e('Исключить товары из указанных категорий.', EKATWOO_DOMAIN); ?></small>
                        </td>
                    </tr>          
                </table>  
            </div>

            <div class="item">
                <h3><?php _e('Фид', EKATWOO_DOMAIN); ?></h3>
                <table class="form-table">
                    <?php
                        $fileManager = new EKatWoo\Services\FileManager();

                        $lastModified = $fileManager->getFileEditDateTime(
                            $settings->getXmlFileDir()
                        );
                    ?>
                    <tr valign="top">
                        <th scope="row">
                            <label for="text"><?php _e('Дата генерирования', EKATWOO_DOMAIN); ?></label>
                        </th>
                        <td>
                            <?= $lastModified ? $lastModified : '-'; ?>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="text"><?php _e('Ссылка на XML', EKATWOO_DOMAIN); ?></label>
                        </th>
                        <td>
                            <?php if ($lastModified) : ?>
                                <a 
                                    href="<?= $settings->getXmlFileUrl(); ?>"
                                    target="_blank"
                                ><?= $settings->getXmlFileUrl(); ?></a>
                            <?php else : ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>  
            </div>
        </div>                                      
        
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Сгенерировать XML', EKATWOO_DOMAIN); ?>" />
            <input type="hidden" name="action" value="generateXML" />
        </p>    
    </form>
</div>
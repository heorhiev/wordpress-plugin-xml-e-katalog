<?php
/**
 * Класс создания страницы в админке.
 *
 * @package EKatWoo
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace EKatWoo\Controllers;

use EKatWoo\Services\Render;
use EKatWoo\Services\Request;
use EKatWoo\Services\WooGeneratorXML;
use EKatWoo\Repositories\Settings;

class GenerateXMLController extends AbstractController {
       
    // Slug страницы
    protected static $pageSlug = 'ekatwoo-generate-xml';

    // Шаблон страницы
    protected static $pageTemplate = 'pages/generate-xml';

    // Title страницы
    protected static $pageTitle = 'Экспорт на E-Katalog';

    // Иконка в меню
    protected static $pageIcon = 'dashicons-redo';

    // стили
    protected static $pageEnqueues = [
        'css' => [
            'generate-xml',
        ],
    ];


    /**
     * Событие генерирования XML
     */
    public function generateXMLAction() {  

        try {
            // сохранение настроек
            Settings::save(Request::get('settings'));

            // генерирования XML
            new WooGeneratorXML();

            // успешное выполнение
            add_action('admin_notices', [__CLASS__, 'successfully']);

        } catch (Exception $e) {
            add_action('admin_notices', [__CLASS__, 'fail']);
        }
    }

    
    /**
     * Уведомление об успешном выполнении
     */
    public static function successfully() {
        $message = sprintf(
            __('XML-файл успешно сгенерирован. <a href="%s" target="_blank">Перейти</a>.', EKATWOO_DOMAIN),
            Settings::getXmlFileUrl()
        );
        
        return print Render::template('notice', [
            'message' => $message,
        ]);
    }
    

    /**
     * Уведомление об ошибке выполнения
     */
    public static function fail() {
        return print Render::template('notice', [
            'message' => __('Ошибка генерирования XML. Пожалуйста, обратитесь в тех. поддержку плагина', EKATWOO_DOMAIN),
            'status'  => 'error',
        ]);
    }
}
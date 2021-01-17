<?php
/**
 * Файл класса файлового менеджера
 *
 * @package EKatWoo
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */


namespace EKatWoo\Services;


class FileManager {

    /**
     * Возвращает время редактирования файла
     */
    public static function getFileEditDateTime($filePath, $format = 'd.m.Y в H:i') {
        if (!file_exists($filePath)) {
            return;
        }

        $timeZone = get_option('gmt_offset') * 60 * 60;
                            
        return date(
            $format, 
            filemtime($filePath) + $timeZone
        );
    }

}
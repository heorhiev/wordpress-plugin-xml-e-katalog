<?php
/**
 * Файл вывода шаблона уведомления
 *
 * @package EKatWoo
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
$settings = new EKatWoo\Repositories\Settings();

if (!isset($status)) {
    $status = 'success';
}
?>

<div class="notice notice-<?= $status; ?> is-dismissible">
    <p><?= $message; ?></p>
</div>
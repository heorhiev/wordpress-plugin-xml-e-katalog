<?php
/**
 * Загрузчик классов
 *
 * @package EKatWoo
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */

include EKATWOO_INC . 'classes/services/Render.php';
include EKATWOO_INC . 'classes/services/GeneratorXML.php';
include EKATWOO_INC . 'classes/services/WooGeneratorXML.php';
include EKATWOO_INC . 'classes/services/FileManager.php';
include EKATWOO_INC . 'classes/services/Request.php';

include EKATWOO_INC . 'classes/repositories/Settings.php';
include EKATWOO_INC . 'classes/repositories/WooCatalog.php';

include EKATWOO_INC . 'classes/controllers/AbstractController.php';
include EKATWOO_INC . 'classes/controllers/GenerateXMLController.php';
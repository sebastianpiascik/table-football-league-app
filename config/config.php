<?php
/*
 * Config file
 */

defined("__ROOT__")
or define('__ROOT__', dirname(dirname(__FILE__)));

defined("TEMPLATES_PATH")
or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/../views'));

defined("ASSETS_PATH")
or define("ASSETS_PATH", realpath(dirname(__FILE__) . '/../assets'));

/*
 * Include Classes
 */
require_once(__ROOT__ . '/config/Database.php');
require_once(__ROOT__ . '/src/Participant.php');
require_once(__ROOT__ . '/src/Team.php');
require_once(__ROOT__ . '/src/Game.php');

$db = new Database('localhost', 'table_football_league', 'root', '');
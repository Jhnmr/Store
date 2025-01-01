<?php
require_once 'App/autoload.php';
require_once 'Config/Config.php';

$ruta = !empty($_GET['url']) ? $_GET['url'] : "home/index";
$array = explode("/", $ruta);
$controller = ucfirst($array[0]);
$metodo = "index";
$parametro = "";

if (!empty($array[1])) {
    if (!empty($array[1] != "")) {
        $metodo = $array[1];
    }
}

if (!empty($array[2])) {
    if (!empty($array[2] != "")) {
        for ($i=2; $i < count($array); $i++) {
            $parametro .= $array[$i]. ",";
        }
        $parametro = trim($parametro, ",");
    }
}

require_once "Config/App.php";
$dirControllers = "Controllers/".$controller.".php";
if (file_exists($dirControllers)) {
    require_once $dirControllers;
    $controller = "Controllers\\".$controller;
    $objController = new $controller();
    if (method_exists($objController, $metodo)) {
        $objController->$metodo($parametro);
    }
} else {
    require_once "Controllers/Errors.php";
    $controller = new Controllers\Errors();
}
?>
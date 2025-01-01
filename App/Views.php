<?php
namespace App;

class Views
{
    public function getView($controller, $view, $data = "")
    {
        if (is_object($controller)) {
            $controller = get_class($controller);
            $controller = str_replace('Controllers\\', '', $controller);
        }
        
        $viewPath = "Views/" . strtolower($controller) . "/" . $view . ".php";
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            require_once "Views/errors/404.php";
        }
    }
} 
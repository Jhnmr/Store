<?php
namespace Config;

class App
{
    private $url;
    private $controller;
    private $method;
    private $params = [];
    
    public function __construct()
    {
        $url = $this->getUrl();
        
        if (empty($url[0])) {
            $this->controller = 'Principal';
        } else {
            $this->controller = ucfirst($url[0]);
        }
        
        $controllerFile = "Controllers/" . $this->controller . ".php";
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $this->controller = new $this->controller();
            
            if (isset($url[1])) {
                if (method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]);
                } else {
                    header('Location: ' . BASE_URL . 'errors');
                    exit;
                }
            } else {
                $this->method = 'index';
            }
            
            if (isset($url[2])) {
                $this->params = array_slice($url, 2);
            }
            
            call_user_func_array([$this->controller, $this->method], $this->params);
            
        } else {
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
    }
    
    private function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
} 
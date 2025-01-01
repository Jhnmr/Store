<?php
namespace App;
use Config\Query;
use App\Views;

class Controller
{
    protected $views;
    protected $model;
    protected $query;

    public function __construct()
    {
        $this->views = new Views();
        $this->query = new Query();
        $this->loadModel();
    }

    public function loadModel()
    {
        $modelName = str_replace('Controllers\\', '', get_class($this)) . 'Model';
        $modelClass = 'Models\\' . $modelName;
        $modelPath = 'Models/' . $modelName . '.php';
        
        if (file_exists($modelPath)) {
            require_once $modelPath;
            if (class_exists($modelClass)) {
                $this->model = new $modelClass();
            }
        }
    }
} 
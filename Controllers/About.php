<?php
namespace Controllers;

use App\Controller;
use App\Views;

class About extends Controller
{
    protected $views;
    
    public function __construct()
    {
        parent::__construct();
        $this->views = new Views();
    }
    
    public function index()
    {
        $data['title'] = 'Sobre Nosotros';
        $this->views->getView('principal', "about", $data);
    }
} 
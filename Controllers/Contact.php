<?php
namespace Controllers;

use App\Controller;
use App\Views;

class Contact extends Controller
{
    protected $views;
    
    public function __construct()
    {
        parent::__construct();
        $this->views = new Views();
    }
    
    public function index()
    {
        $data['title'] = 'Contacto';
        $this->views->getView('principal', "contact", $data);
    }
} 
<?php
namespace Controllers;
use App\Controller;

class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        header('Location: ' . BASE_URL . 'principal');
        exit;
    }
}








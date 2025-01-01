<?php
namespace App;

class Session
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function destroy()
    {
        session_destroy();
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['id_usuario']);
    }
} 
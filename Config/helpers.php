<?php
namespace Config;

class Helpers
{
    public function getModal(string $nameModal, string $tituloModal)
    {
        $view = "Views/template/modals/{$nameModal}.php";
        require_once $view;
    }

    public function generateToken()
    {
        return bin2hex(random_bytes(32));
    }

    public function strClean($strCadena)
    {
        $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
        $string = trim($string);
        $string = stripslashes($string);
        $string = str_ireplace("<script>", "", $string);
        $string = str_ireplace("</script>", "", $string);
        $string = str_ireplace("<script src>", "", $string);
        $string = str_ireplace("<script type=>", "", $string);
        $string = str_ireplace("SELECT * FROM", "", $string);
        $string = str_ireplace("DELETE FROM", "", $string);
        $string = str_ireplace("INSERT INTO", "", $string);
        $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
        $string = str_ireplace("DROP TABLE", "", $string);
        $string = str_ireplace("OR '1'='1", "", $string);
        $string = str_ireplace('OR "1"="1"', "", $string);
        $string = str_ireplace('OR ´1´=´1´', "", $string);
        $string = str_ireplace("is NULL; --", "", $string);
        $string = str_ireplace("LIKE '", "", $string);
        $string = str_ireplace('LIKE "', "", $string);
        $string = str_ireplace("LIKE ´", "", $string);
        $string = str_ireplace("OR 'a'='a", "", $string);
        $string = str_ireplace('OR "a"="a', "", $string);
        $string = str_ireplace("OR ´a´=´a", "", $string);
        $string = str_ireplace("--", "", $string);
        $string = str_ireplace("^", "", $string);
        $string = str_ireplace("[", "", $string);
        $string = str_ireplace("]", "", $string);
        $string = str_ireplace("==", "", $string);
        return $string;
    }

    public function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function formatMoney($amount)
    {
        return number_format($amount, 2, '.', ',');
    }

    public function now()
    {
        return date('Y-m-d H:i:s');
    }

    public function uploadImage($file, $name, $folder = "products/")
    {
        $url_temp = $file['tmp_name'];
        $destino = 'assets/images/' . $folder . $name;
        
        if (move_uploaded_file($url_temp, $destino)) {
            return $destino;
        }
        return false;
    }

    public function deleteImage($name, $folder = "products/")
    {
        unlink('assets/images/' . $folder . $name);
    }
}

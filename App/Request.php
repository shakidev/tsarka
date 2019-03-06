<?php
/**
 * Created by PhpStorm.
 * User: shakidevcom
 * Date: 3/6/19
 * Time: 1:51 PM
 */

namespace App;


class Request
{
    public $get = array();
    public $post = array();
    public $cookie = array();
    public $files = array();
    public $request = array();
    public $server = array();
    public $route;

    public function __construct()
    {
        $this->route = $this->clean($_SERVER['REQUEST_URI']);
        $this->get = $this->clean($_GET);
        $this->post = $this->clean($_POST);
        $this->request = $this->clean($_REQUEST);
        $this->cookie = $this->clean($_COOKIE);
        $this->files = $this->clean($_FILES);
        $this->server = $this->clean($_SERVER);
    }

    public function clean($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset($data[$key]);
                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }
        return str_replace("/public/","",$data);
    }

    public function redirect($url){
        header("Location: ".$url);
        exit;
    }

    public function withError($error){
        $_SESSION['error'] = $error;
        return $this;
    }

}
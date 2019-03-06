<?php
/**
 * Created by PhpStorm.
 * User: shakidevcom
 * Date: 3/6/19
 * Time: 1:37 PM
 */

namespace App;


class Template
{
    public static $template;
    public static $view = array();
    public static $variables;
    protected static $instance;

    protected function __construct()
    {
    }

    protected static function getSelf()
    {
        if (static::$instance === null) {
            static::$instance = new Template;
        }
        return static::$instance;
    }

    public static function render()
    {
        global $view;
        ob_start();
        $view = (array)self::$view;
        require_once DIR_TEMPLATE . self::$template;
        $htmlfile = ob_get_clean();
        if (!is_null(self::$variables)) {
            foreach (self::$variables as $key => $value) {
                $htmlfile = str_replace("{{" . $key . "}}", $value, $htmlfile);
            }
        }
        echo $htmlfile;
        unset($_SESSION);
        exit;
    }

    public static function view($filename, $variables = null)
    {
        self::$variables = $variables;
        self::$template = $filename;
        return static::getSelf();
    }

    public function with($array)
    {
        self::$view = $array;
        return static::getSelf();
    }

}
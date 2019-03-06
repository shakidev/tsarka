<?php
/**
 * Created by PhpStorm.
 * User: shakidevcom
 * Date: 3/6/19
 * Time: 1:22 PM
 */

namespace App;


use App\Database\Database;
use App\Models\Models;
use App\Request;
use App\ActionRoute;

class App
{
    public function run(){
        header("Content-type: text/html; charset=utf-8");
        $request = new Request();
        $route = new ActionRoute($request);
        $route->main();
    }
}
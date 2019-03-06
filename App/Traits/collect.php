<?php namespace App\Traits;
/**
 * Created by PhpStorm.
 * User: shakidevcom
 * Date: 3/7/19
 * Time: 2:50 AM
 */

trait collect
{


    public static function groupBy($data,$column)
    {
        $group = [];
        foreach ($data as $_data) {
            $group[$_data->{$column}][] = $_data;
        }
        return (object) $group;
    }

}
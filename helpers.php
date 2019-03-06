<?php
/**
 * Created by PhpStorm.
 * User: shakidevcom
 * Date: 3/6/19
 * Time: 1:03 PM
 */


function dd($dd){
    echo '<pre>';
    print_r($dd);
    echo '</pre>';
    die();
}


function append($array){
    return implode(",",$array);
}

function validate_phone_number($phone)
{
    $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
    $phone_to_check = str_replace("-", "", $filtered_phone_number);
    if (strlen($phone_to_check) === 12 && $filtered_phone_number[0] == "+") {
        return true;
    } else {
        return false;
    }
}
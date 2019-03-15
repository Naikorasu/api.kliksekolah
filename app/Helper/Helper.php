<?php
/**
 * Created by PhpStorm.
 * User: naikorasu
 * Date: 15/03/19
 * Time: 13.29
 */


use Carbon\Carbon;

/**
 * @param $data
 */

function generate_unique_key($data)
{
    $micro = Carbon::now()->microseconds();
    $milli = Carbon::now()->milliseconds();
    $date = Carbon::now()->toDateTimeString();
    return sha1($data . $micro.";" . $milli.";" . $date.";");
}
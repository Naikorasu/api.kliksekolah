<?php
/**
 * Created by PhpStorm.
 * User: naikorasu
 * Date: 15/03/19
 * Time: 13.29
 */

namespace App\Classes;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class FunctionHelper
{
    /**
     * @param $data
     */

    public static function generate_unique_key($data)
    {
        try {

            $uuid = Uuid::uuid1()->toString();
            $md5 = Uuid::uuid3(Uuid::NAMESPACE_DNS,env("APP_NAME"));
            $sha = Uuid::uuid5(Uuid::NAMESPACE_DNS,env("APP_NAME"));
            $time = Uuid::uuid4()->toString();

            $result = sha1($data . $uuid . $time . $md5 . $sha);

        } catch (UnsatisfiedDependencyException $e) {

            $result = "ERROR " . __FUNCTION__;
        }

        return $result;
    }

}

<?php
namespace pedacode\dao;

class DaoUtil {

    public static function convertCode($code) : int { 
        $code = 8000;
        if (isset($code))   $code = (int)$code;
        return $code;
    }

    public static function stringToDateTimeImmutable(string $date) : \DateTimeImmutable{
        return \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", $date);
    }
}
<?php
namespace Third_party\Token;
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT as PHPJWT;

class JWT {
    private static $key = "%D44b0n...n0b44D%";

    static function encode($payload, $key = false) {
        return PHPJWT::encode($payload, $key ?: self::$key);
    }

    static function decode($token, $key = false) {
        return PHPJWT::decode($token, $key ?: self::$key, ['HS256']);
    }

    static function session_encode() {
        $model = new \Model();
        return $model->db->exec("

            SELECT
                HEX(AES_ENCRYPT(:payload, :pass)) AS token;

        ", [
            ":payload" => PHPJWT::encode([
                "username"  => $_SESSION['username'],
                "time"      => time(),
                "browser"   => $_SERVER['HTTP_USER_AGENT']
            ],self::$key),
            ":pass" => self::$key
        ])[0]['token'];
    }


    static function session_decode($token) {
        $model = new \Model();
        $token = $model->db->exec("
        
            SELECT
                AES_DECRYPT(UNHEX(:token), :pass) AS token;

        ", [
            ":token" => $token,
            ":pass" => self::$key
        ])[0]['token'];

        if ($token)
            return PHPJWT::decode(
                $token,
                self::$key,
                ['HS256']
            );
    }

}
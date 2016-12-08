<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 9/6/16
 * Time: 1:00 PM
 */

namespace App\Utils;


use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ConvertUtils
{
    public static function convert_p12_to_pem($path_file, $pass_file, $dest_folder = '')
    {
//        $is_valid = false;
        try {
            $p12worked = openssl_pkcs12_read(file_get_contents($path_file), $p12, $pass_file);
            if ($p12worked) {
                $p12data = openssl_x509_parse($p12['cert']);
                $filename = $p12data['subject']['UID'] . (strpos($p12data['subject']['CN'], 'Production') > -1 ? '.prod' : '.dev') . '.pem';
                $h = fopen($filename, 'w');
                fwrite($h, $p12['cert'] . $p12['pkey']);
                fclose($h);

                if (file_exists($filename) && !empty($dest_folder)) {
                    rename($filename, base_path() . $dest_folder . $filename);
                }
//            echo sprintf('The certificate <b>%s</b> you uploaded has been exported successfully.<br><b>%s</b> is valid until %s.<hr>', $file, $filename, date('d\/m\/Y', $p12data['validTo_time_t']));
                $is_valid = true;
            }
//        else {
//            echo openssl_error_string(), '<hr>';
//        }
        } catch (FileException $e) {
            Log::error("convert_p12_to_pem: " . $e->getMessage());
        } catch (\RuntimeException $e) {
            Log::error("convert_p12_to_pem: " . $e->getMessage());
        }
        return $filename;
    }

    public static function generate_invite_code($length)
    {
        $conso = array("b", "c", "d", "f", "g", "h", "j", "k", "l",
            "m", "n", "p", "r", "s", "t", "v", "w", "x", "y", "z");
        $vocal = array("a", "e", "i", "o", "u", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $code = "";
        srand((double)microtime() * 1000000);
        $max = $length / 2;
        for ($i = 1; $i <= $max; $i++) {
            $code .= $conso[rand(0, 19)];
            $code .= $vocal[rand(0, 4)];
        }
        return strtoupper($code);
    }
}
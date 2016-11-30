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
    public static function convert_p12_to_pem($path_file, $pass_file, $dest_folder = '', $app_id = '')
    {
//        $is_valid = false;
        $filename = '';
        try {
            $p12worked = openssl_pkcs12_read(file_get_contents($path_file), $p12, $pass_file);

            if ($p12worked) {
                $p12data = openssl_x509_parse($p12['cert']);
                $filename = $app_id . '_' . $p12data['subject']['UID'] . (strpos($p12data['subject']['CN'], 'Production') > -1 ? '.prod' : '.dev') . '.pem';
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
}
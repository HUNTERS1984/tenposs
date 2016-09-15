<?php
/*
 * jQuery File Upload Plugin PHP Class
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
namespace App\Utils;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class UrlHelper
{
    public static function convertRelativeToAbsoluteURL($baseAbsoluteURL, $relativeURL)  
    {  

       $relativeURL = trim($relativeURL);  
       if (substr($relativeURL, 0, 7) !== 'http://' && substr($relativeURL, 0, 8) !== 'https://')  
       {  
            while (strpos($relativeURL, '/./') !== false)  
            {  
               $relativeURL=str_replace('/./','/',$relativeURL);  
            }  
            if (substr($relativeURL, 0, 2) === './') $relativeURL = substr($relativeURL, 2);  
            $urlInfo = parse_url($baseAbsoluteURL);  
            if ($urlInfo == false) return false;  
            if (!isset($urlInfo['path'])) 
                $urlInfo['path'] = '';
            $urlBasePath = substr($urlInfo['path'], 0, strrpos($urlInfo['path'],"/"));  
            $dirDepth = substr_count($urlInfo['path'], '/')-1;  
          
            $dirDepthRel = substr_count(preg_filter('\'^((\\.\\./)+)(.*)\'', '$1', $relativeURL), '../');  
            $relativeURL = preg_replace('\'^((\\.\\./)+)(.*)\'', '$3', $relativeURL);      
          
            for ($i=0; $i<$dirDepthRel; $i++)  
            {  
               $urlBasePath = substr($urlBasePath, 0, strrpos($urlBasePath,"/"));  
            }  
            if (isset($urlInfo['port']))
                $urlBase = $urlInfo['scheme'].'://'.$urlInfo['host'].':'.$urlInfo['port'].$urlBasePath;  
            else 
                $urlBase = $urlInfo['scheme'].'://'.$urlInfo['host'].$urlBasePath;

            do  
            {  
               $tempContent = $relativeURL;  
               $relativeURL = preg_replace('\'^(.*?)(([^/]*)/\\.\\./)(.*?)$\'', '$1$4', $relativeURL);  
            }  
            while ($tempContent != $relativeURL);  
          
            if(substr($relativeURL, 0, 2) === "//")  
            {  
               $relativeURL=$urlInfo['scheme'].':'.$relativeURL;  
            }  
            else if(substr($relativeURL, 0, 1) === "/")  
            {  
               $relativeURL=$urlInfo['scheme'].'://'.$urlInfo['host'].$relativeURL;  
            }  
            else  
            {  
               $relativeURL=$urlBase.'/'.$relativeURL;  
            }  
       }  
       return $relativeURL;  
    }
}

<?php
/**
 * Created by JetBrains PhpStorm;
 * Programmer: Vaulin Alexandr;
 * Date: 11.07.13;
 * Experience: 1.5 years.
 */
require_once('config.php');

$way = "app/system/";
$dir = opendir($way);
while($item = readdir($dir)){
    if(is_dir($way.$item)){
        $file = $way.$item.'/'.$item.'.php';
        if(file_exists($file)){
            require_once($file);

        }   //echo $file;

    }
}
closedir($dir);
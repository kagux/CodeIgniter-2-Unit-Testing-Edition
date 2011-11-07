<?php

class CoreClassesAutoLoader {

    public static function hook(){
        spl_autoload_register("CoreClassesAutoLoader::autoload");
    }

    public static function autoload($className){
        $filename = APPPATH."/core/classes/$className.php";
        if (file_exists($filename)) include $filename;
    }
}
?>
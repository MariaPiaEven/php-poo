<?php

class Autoloader{

    static function start(){ 
                                //nom de la classe et nom de la function
        spl_autoload_register(["Autoloader","autoload"]);
        // spl_autoload_register([__CLASS__,"autoload"]);
    }

    static function autoload($nomClasse) {

        if(file_exists($nomClasse . ".php")){
            include($nomClasse.".php");
        }   
    }

}

?>
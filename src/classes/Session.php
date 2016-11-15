<?php

namespace BuildMyCV\classes;

/**
 * Reprensent a session to check if user is logged in or not to access at the admin interface
 */
class Session {
    
    private static $instance ;
    private $password ;
    
    /**
    * Singleton class
    * @return an instance of Session
    */
    public static function get_instance():Session{
        if(is_null(self::$instance)){
            self::$instance = new Session();
        }
        return self::$instance ;

    }

	
    private function __construct() {
        $data_config = json_decode(file_get_contents(ROOT."/config.json"), true);
        $this->password = $data_config['admin']['password'];
    }
    
    /**
     * Return true if user is already logged
     * @return bool
     */
    public function is_logged():bool{
        // TODO: check session variable here
        return false;
    }
    
    /**
     * 
     * @param string $password
     */
    public function login(string $password):bool{
        if($this->password == $password){
            // TODO: set session variable here
            return true;
        }else{
            return false;
        }
        
    }
}

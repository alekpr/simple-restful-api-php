<?php
namespace Libs\MyClass;
/**
 * Description of Authen class
 * - Sample authentication class
 *
 * @author Alek
 */
class Authen extends Base {
    protected $_token = "";
    public function __construct($class = __CLASS__) {
        //nothing
        parent::__construct();
    }

    /**
     *
     * Function Login
     * Description - Sample function login 
     * @param   string $username 
     *          string $password
     * @return  boolean login status (true / false)
     */
    public function Login($username,$password){
        //check username is exist
        if ($username != 'demo') {
            $this->error = "Username not found !";
            return false;
        }
        //check password is correct
        if ($password != 'demo') {
            $this->error = "Password incorrect !";
            return false;
        }
        return true;
    }
	
    public function __destruct(){
    	//nothing
        parent::__destruct();
    }
}

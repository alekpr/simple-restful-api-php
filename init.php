<?php
/* init.php */
/* Load the composer autoloader into your application. */
require_once 'libs/const/const.php';
$classloader = require_once "vendor/autoload.php";
$classloader->addPsr4('Libs\\MyClass\\', __DIR__."/libs/classes");
use Slim\Slim;
use \JsonApiView;
use \JsonApiMiddleware;


define("BASE_DIR", __DIR__."/");

/* Create Slim instance */
$app = new Slim();

/* Add json view */
$app->view(new JsonApiView());
$app->add(new JsonApiMiddleware());


use Libs\MyClass\Authen;
use Slim\Middleware;
use \RuntimeException;

class MyAuthentication extends \Slim\Middleware
{
	public function __construct(Authen $auth)
    {
        $this->auth = $auth;
    }
    public function call()
    {
        $app = $this->app;
        $auth = $this->auth;
        $username = (strlen( $app->request()->headers('PHP-AUTH-USER')) > 0) ? $app->request()->headers('PHP-AUTH-USER') : "";
		$password = (strlen( $app->request()->headers('PHP-AUTH-PW')) > 0) ? $app->request()->headers('PHP-AUTH-PW') : "" ;
		
		$isAuthorized = function () use ($app, $auth, $username, $password) {
            if(!$auth->Login($username,$password)){
				throw new RuntimeException("Permission denied");
			}
        };
		
       	$app->hook('slim.before.dispatch', $isAuthorized);
       	$this->next->call();
    }
}

// Add Authentication Middleware to Aplication
$app->add(new MyAuthentication(new Authen()));

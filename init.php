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
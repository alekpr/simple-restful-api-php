<?php
require_once "init.php";
use slim\slim;
use Libs\MyClass\Coffee;

/**
 * Route GET /coffee
 * Description - Retrieves a list of coffee
 */
$app->get("/coffee",function() use ($app) {
	$coffee = new Coffee();
	$allcoffee = $coffee->AllCoffee();
	$app->render(200,array("data"=>$allcoffee));
});
/**
 * Route POST /coffee
 * Description - Creates a new coffee
 */
$app->post("/coffee",function() use ($app){
	$data =  $app->request->params();
	$coffee = new Coffee();
	$insert_id = $coffee->save($data);
	if($insert_id > 0){
		$app->render(200,array("data"=>$coffee->get_byId($insert_id)));
	}else{
		$app->render(200,array("error"=>true,"msg"=>"save fail"));
	}
});
/**
 * Route GET /coffee/id
 * Description - Retrieves a specific coffee
 */
$app->get("/coffee/:id",function($id) use ($app){
	$coffee = new Coffee();
	$app->render(200,array("data"=>$coffee->get_byId($id)));
});
/**
 * Route PUT /coffee/id
 * Description - Updates coffee #id
 */
$app->put("/coffee/:id",function($id) use ($app) {
	$coffee = new Coffee();
	$data = $app->request->params();
	if($coffee->UpdateCoffee($id,$data)){
		$app->render(200,array("data"=>$coffee->get_byId($id)));
	}else{
		$app->render(200,array("error"=>true,"msg"=>"update fail"));
	}
});
/**
 * Route DELETE /coffee/id
 * Description - Deletes coffee #id
 */
$app->delete("/coffee/:id",function($id) use ($app) {
	$coffee = new Coffee();
	if($coffee->delete($id)){
		$app->render(200,array("msg"=>"delete successful"));
	}else{
		$app->render(200,array("error"=>true,"msg"=>"delete fail"));
	}
});
$app->run();
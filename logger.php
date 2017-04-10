<?php

require_once 'conf.php';

class Logger{
	
public $path;
public $product;

	
	public function __construct(Conf $conf,  $product){
	
	$this->path = new Conf;
	$this->product = $product;


}

public function getPath(){
	
	foreach($this->path->pathArray as $key =>$value){
		
		if($key == __CLASS__) return $value;
	}
}

 function __call($method_name, $args) {
       $method =  date('m-d-Y H:i').' Method: '.$method_name;
	   $file = $this->getPath().'/'.time().'.txt';
	   file_put_contents($file, $method);
	   return call_user_func_array(array($this->product, $method_name), $args);
 }

 
}



?>
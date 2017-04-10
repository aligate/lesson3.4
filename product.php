<?php 
header('Content-Type: text/html; charset=utf-8');
require_once 'logger.php';
require_once 'cache.php';

abstract class Product{

protected $price;
protected $weight;
protected $delivery = 250;
protected $discount = null;


public function __construct($price, $weight){
	
	$this->price = $price;
	if($price ==0){
		throw new Exception("Цена должна быть больше нуля");
	}
	
	$this->weight = $weight;
	}

}
// Создаем Класс сумок
class Handbag extends Product
{
	use Delivery;
	
	private $cache;
	
	public function getPrice($discount = null)
	{
		
		if(isset($discount))
		{
			$this->discount = $discount;
			$this->price = round($this->price -($this->price * $this->discount /100));
		}
		return $this->price;
	}
	
	public function priceInCache($filename,$discount)
	{
		
		$endprice = $this->getPrice($discount);
		
		$this->cache = new Cache(new Conf, $endprice);
	
		if(!$this->cache->getCache($filename))
		{
		 $this->cache->setCache($filename);
		}
		return $this->cache->getCache($filename);
	}
	
	
	public function getSummary($filename, $discount)
	{
		
		echo 'Цена за сумку: '.$this->priceInCache($filename, $discount).' Доставка: '.$this->getDelivery();
	
	}
}


// Трейт
trait Delivery{
	
	public function getDelivery(){
		if(isset($this->discount)) $this->delivery = 300;
		return $this->delivery;
	}
}

// Создаем объекты


try{
	$logger = new Logger(new Conf, new Handbag(100, 1));
}
catch (Exception $e)
{
	echo 'Ошибка: '.$e->getMessage();
}


echo $logger ->getSummary('new',10);



?>
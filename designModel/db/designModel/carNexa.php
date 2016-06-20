<?php
	class NexaOrder{

		$model = array();

		// Called each time the order is placed
		public function placeOrder(){

			$car = new ManufactureCar(this->getModel());
		} 
		funtion getModel(){
			return $model;
		}

	}
	class ManufactureCar{

		function __construct($model){
			
		}

	}

?>
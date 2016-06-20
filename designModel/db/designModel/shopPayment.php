<?php

	class PayCC{
		function __construct(){
			echo 'paythrough credit card';
		}
	}

	class PayPP{
		function __construct(){
			echo 'pay through pay pal';
		}
	}
	class ShoppingCart {
		public $amt;
		function __construct($a){
			$this-> amt = $a;
		}

		public function checkAmount(){
			if (1000 > $amt) {
				$objPayment = new PayPP;
			}
			else {
				$objPayment = new PayCC;
			}
		}
	}
	$objShop = new ShoppingCart($amount);
?>
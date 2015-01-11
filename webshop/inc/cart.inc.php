<?php
include_once('product.inc.php');
class Cart { 
		private $items = array();

		public function addItem($art, $num, $option) {
			$this->items[$art][$option] += $num;
		}

		public function removeItem($art, $num, $option) { 
			if (isset($this->items[$art][$option]) && $this->items[$art] >= $num) { 
				$this->items[$art][$option] -= $num;
				if ($this->items[$art][$option] == 0) {
					unset($this->items[$art][$option]);
				}
				return true;
			} 
			else {
				return false;
			}
		}

		public function emptyCart() { 
			unset($items);
		}

		public function calcCart() { 
			
		}
		
		public function getItems(){
			return $this->items;
		}
} 
?>

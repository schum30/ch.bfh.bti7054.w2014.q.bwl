<?php
    include_once('product.inc.php');
    class Cart { 
        private $items = array();

        public function addItem($art, $num) { 
            if (!isset($this->items[$art])) {
                $this->items[$art] = 0; 
            }
            $this->items[$art] += $num;
        } 

        public function removeItem($art, $num) { 
            if (isset($this->items[$art]) && $this->items[$art] >= $num) { 
                $this->items[$art] -= $num; 
                if ($this->items[$art] == 0) {
                    unset($this->items[$art]);
                }
                return true;  
            } 
            else {
                return false;
            }
        }

          
        public function emptyCart($art, $num) { 

        } 

        public function calcCart($art, $num) { 

        }

		public function display() { 
			$ret = '<table border=\"1\">'; 
			$ret .= '<tr><th>Article</th><th>Items</th></tr>'; 
			foreach ($this->items as $art=>$num){
				$ret .= '<tr><td>' . $art . '</td><td>' . $num . '</td></tr>';
			}
			$ret .= '</table>';
			return $ret;
		} 
    } 
?>

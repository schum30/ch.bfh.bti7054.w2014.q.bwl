<?php
    include("product.inc.php");
    class Cart { 
        private $items = array(); 

        public function addItem($art, $num) { 
            if (!isset($this->items[$art])) {
                $this->items[$art] = 0; 
            }
            $this->items[$art] += $num;
        } 
/*
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

          
        public function emtyCart($art, $num) { 

        } 

        public function calcCart($art, $num) { 

        } 


          */

        public function display() { 
            echo "<table border=\"1\">"; 
            echo "<tr><th>Article</th><th>Items</th></tr>"; 
            foreach ($this->items as $art=>$num) 
                echo "<tr><td>$art</td><td>$num</td></tr>"; 
            echo "</table>"; 
        } 
    } 
?>
<?php
include_once('product.inc.php');

class ProductDB extends mysqli{
	public function getAllProducts() {
		$products = array();
		$res = $this->query("SELECT * FROM products");
		while($product = $res->fetch_object()){
			array_push($products,new Product($product->name,$product->price,$product->id));
		}
		return $products;
	}
	public function getProduct($id){
		$res = $this->query("SELECT * FROM products WHERE ID = $id");
		$obj = $res->fetch_object();
		return new Product($obj->name,$obj->price,$obj->id);
	}
	public function deleteProduct($product) {
		$id = $product->get(id);
		$this->query("DELETE FROM products WHERE ID = $id");
	}
	public function insertProduct($product) {
		$name = $product->get(name);
		$price = $product->get(price);
		$this->query("INSERT products (Name, Price) VALUES ('$name','$price')");
	}
	public function updateProduct($product) {
		$name = $product->get(name);
		$price = $product->get(price);
		$id = $product->get(id);
		$this->query("UPDATE products SET Name='$name',
			Price='$price' WHERE ID=$id");
	}
	function __construct() {
		parent::__construct("localhost", "root", "");
		parent::select_db("bwl");
	}
}
?>

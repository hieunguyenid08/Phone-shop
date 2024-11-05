<?php

class Cart
{
  private $products;

  public function __construct($products)
  {
    if (!isset($products)) $products = [];
    $this->products = $products;
  }

  public function addProduct($product, $quantity)
  {
    if (!isset($this->products[$product["id"]])) {
      $product["quantity"] = $quantity;
      $this->products[$product["id"]] = $product;
    } else {
      $this->products[$product["id"]]["quantity"] += 1;
    }
  }

  public function removeProduct($id)
  {
    unset($this->products[$id]);
  }

  public function getTotal()
  {
    $total = 0;
    foreach ($this->products as $product) {
      $total += $product["quantity"] * $product["price"];
    }

    return $total;
  }

  public function getCart()
  {
    return $this->products;
  }

  public function getNumProducts()
  {
    $count = 0;
    foreach ($this->products as $product) {
      $count += $product["quantity"];
    }

    return $count;
  }
}

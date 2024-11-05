<?php

session_start();


if (!isset($_SESSION["userId"])) {
  Header("Location: /login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include_once "../class/Database.php";
  include_once "../class/Product.php";
  include_once "../class/Cart.php";

  $database = new Database();
  $db = $database->getConnection();

  $productObj = new Product($db);
  $cart = new Cart($_SESSION["cart"] ?? []);

  $buy_products = $cart->getCart();

  foreach ($buy_products as $product) {
    $productObj->title = $product["title"];
    $productObj->price = $product["price"];
    $productObj->thumbnail = $product["thumbnail"];
    $productObj->description = $product["description"];
    $productObj->quantity = $product["available"] - $product["quantity"];
    $productObj->updateProductById($product["id"]);

    if ($productObj->quantity <= 0) {
      $productObj->deleteProductById($product["id"]);
    }
  }

  unset($_SESSION["cart"]);

  Header("Location: ./index.php");
}


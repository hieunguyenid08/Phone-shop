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

  $product_id = $_POST["id"];

  $cart = new Cart($_SESSION["cart"] ?? []);

  $cart->removeProduct($product_id);

  $_SESSION["cart"] = ($cart)->getCart();
  $_SESSION["total"] = $cart->getTotal();

  Header("Location: ./index.php");
}


<?php
require_once "../includes/header.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST" || $_SESSION["role"] != "Admin") {
  Header("Location: ../index.php");
}

include_once "../class/Database.php";
include_once "../class/Product.php";
$database = new Database();
$db = $database->getConnection();

$productObj = new Product($db);

$id = $_POST["id"];
$product = $productObj->getProductById($id);


if (isset($_POST["confirm"])) {
  $id = $_POST["id"];
  if ($productObj->deleteProductById($id)) {
    Header("Location: ./index.php");
  } else {
    Header("Location: ./index.php");
  }
}
?>

<body>
  <div class="container pt-4">
    <div class="card">
      <h5 class="card-header">Delete Product</h5>
      <div class="card-body">
        <h5 class="card-title">
          Are you sure to delete product
          <span class="text-primary"><?= $product["title"], $id ?></span>,
          price=<span class="text-primary"><?= $product["price"] ?></span>
        </h5>

        <div class="pt-2">
          <a class="btn btn-outline-primary" href="./index.php">Cancel</a>
          <form class="d-inline-block" action="./delete.php" method="POST">
            <input name="id" class="visually-hidden" type="text" value="<?= $id ?>">
            <input name="confirm" class="visually-hidden" type="text" value=1>
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </div>
      </div>
    </div>
    </d

<?php include_once "../includes/header.php" ?>

<?php

session_start();
if (!isset($_SESSION["userId"]) || !isset($_SESSION["role"]) || $_SESSION["role"] != "Admin") {
  Header("Location: ../index.php");
}
include_once "../class/Database.php";
include_once "../class/Product.php";
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$keyword = $_GET["q"] ?? "";
$where_sql = $keyword ? " WHERE title LIKE '%$keyword%' " : "";

$products = $product->readAll($where_sql, 5);
?>

<body>
  <?php include_once "../includes/navbar.php" ?>
  <div class="container mt-3">
    <h3 class="mb-3">PRODUCT DASHBOARD</h3>

    <div class="d-flex justify-content-between gap-3">
      <a href="./add.php" class="btn btn-success">Add New Product</a>
      <div class="d-flex gap-2">
        <form class="" style="max-width: 500px;" action="./index.php" method="GET">
          <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" class="form-control" name="q" id="keyword">
            <button class="btn btn-outline-primary">Search</button>
          </div>
        </form>

        <form action="index.php" method="GET">
          <div class="input-group">
            <span class="input-group-text visually-hidden">Search:</span>
            <input type="text" class="form-control visually-hidden" name="q" id="keyword" value="">
            <button class="btn btn-outline-dark">Clear Filter</button>
          </div>
        </form>
      </div>
    </div>

    <table class="table mt-4">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Product Name</th>
          <th scope="col">Price</th>
          <th style="width: 200px" scope="col">Description</th>
          <th scope="col">Thumbnail</th>
          <th scope="col">Quantity</th>
          <th style="text-align: center; width: 150px" scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $index => $p) : ?>
          <tr>
            <th scope="row"> <?= $index + 1 ?></th>
            <th scope="row"> <?= $p["title"] ?></th>
            <td scope="row"> <?= $p["price"] ?></td>
            <td style="width: 200px" scope="row"> <?= $p["description"] ?></td>
            <td scope="row"> <?= $p["thumbnail"] ?></td>
            <td scope="row"> <?= $p["available"] ?></td>
            <td style="width: 150px;" scope="row">
              <form class="d-inline-block" action="./delete.php" method="POST">
                <input name="id" class="visually-hidden" type="text" value="<?= $p["id"] ?>">
                <button type="submit" class="btn btn-outline-danger">Delete</button>
              </form>
              <a href="./edit.php?id=<?= $p['id'] ?>" class="btn btn-outline-primary">Edit</a>
            </td>
          </tr>

        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>

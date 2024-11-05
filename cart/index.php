<?php
session_start();

include_once "../includes/header.php";

$products = ($_SESSION["cart"]) ?? [];
?>

<body>
  <?php include_once "../includes/navbar.php" ?>
  <div class="container">
    <?php if (count($products ?? []) != 0) : ?>
      <table class="table mt-4">
        <thead>
          <tr>
            <th scope="col">Product Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Total</th>
            <th style="text-align: center; width: 30px" scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $index => $product) : ?>
            <tr>
              <td scope="row"> <?= $product["title"] ?></td>
              <td scope="row"> <?= $product["quantity"] ?></td>
              <td scope="row"> $<?= $product["price"] ?></td>
              <td scope="row"> $<?= $product["price"] * $product["quantity"] ?></td>
              <td scope="row">
                <form class="d-inline-block" action="./delete.php" method="POST">
                  <input name="id" class="visually-hidden" type="text" value="<?= $product["id"] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger text-center">
                    <i class="fa-solid fa-circle-xmark"></i>
                  </button>
                </form>
              </td>
            </tr>

          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="mt-3">
        <h5 class="text-right">Total: <span class="text-danger">$<?= $_SESSION["total"] ?></span></h5>
        <form action="./cash.php" method="POST">
          <button type="submit" class="btn btn-primary">Cash</button>
        </form>
      </div>
    <?php else : ?>
      <h5 class="text-center mt-5">There is no product in cart. Back to <a href="/">homepage</a></h5>
    <?php endif; ?>
  </div>
</body>

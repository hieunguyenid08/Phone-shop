<?php

session_start();
if (!isset($_SESSION["userId"]) || !isset($_SESSION["role"]) || $_SESSION["role"] != "Admin") {
  Header("Location: ../index.php");
}
// @var getRole();
// use to fix bug lsp nvim -> delete when upload
include "../includes/helpers.php";
include "../class/Database.php";

$database = new Database();
$connect = $database->getConnection();

$keyword = $_GET["q"] ?? "";
$user_query = "SELECT * FROM User WHERE username LIKE '%$keyword%' OR fullname LIKE '%$keyword%' LIMIT 5";
$result = $connect->query($user_query);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<?php
require_once "../includes/header.php";
require_once "../includes/navbar.php";


?>

<body>
  <div class="container mt-3">
    <h3 class="mb-3">USER DASHBOARD</h3>

    <div class="d-flex justify-content-between gap-3">
      <a href="./add.php" class="btn btn-success">Add New User</a>
      <div class="d-flex gap-2">
        <form class="" style="max-width: 500px;" action="index.php" method="GET">
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
          <th scope="col">Fullname</th>
          <th scope="col">Username</th>
          <th scope="col">Role</th>
          <th style="text-align: center; max-width: 50px" scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $index => $user) : ?>
          <tr>
            <th scope="row"> <?= $index + 1 ?></th>
            <td scope="row"> <?= $user["fullname"] ?></td>
            <td scope="row"> <?= $user["username"] ?></td>
            <td scope="row"> <?= getRole($user["role_id"] ?? 0) ?></td>
            <td style="max-width: 50px;" scope="row">
              <form class="d-inline-block" action="./delete.php" method="POST">
                <input name="id" class="visually-hidden" type="text" value="<?= $user["id"] ?>">
                <button type="submit" class="btn btn-outline-danger">Delete</button>
              </form>
              <a href="./edit.php?id=<?= $user['id'] ?>" class="btn btn-outline-primary">Edit</a>
            </td>
          </tr>

        <?php endforeach; ?>
      </tbody>
    </table>

  </div>

</body>

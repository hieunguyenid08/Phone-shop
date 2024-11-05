<?php
session_start();
if (!isset($_SESSION["userId"])) {
  Header("Location: ../index.php");
}

include "../class/Database.php";
$database = new Database();
$connect = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = $_POST["name"];
  $phone = $_POST["phone"];
  $address = $_POST["address"];
  $email = $_POST["email"];
  $id = $_POST["id"];

  $update_sql = "UPDATE User SET fullname='$fullname', phone_number='$phone', address='$address', email='$email' WHERE id='$id'";

  if ($connect->query($update_sql) === TRUE) {
    Header("Location: /index.php");
  } else {
    Header("Location: /index.php");
  }
} else {
  $id = $_SESSION["userId"];
  $query = "SELECT * FROM User WHERE id=$id";
  $result = $connect->query($query);
  $user = $result->fetch_assoc();
}

?>

<?php require_once "../includes/header.php" ?>

<div class="container mt-3">
  <form method="POST" , action="profile.php">
    <div class="mb-3">
      <label for="name" class="form-label">Full Name</label>
      <input type="text" class="form-control" name="name" id="name" value="<?= $user["fullname"] ?>">
    </div>
    <div class="mb-3">
      <label for="phone" class="form-label">Phone</label>
      <input type="text" class="form-control" name="phone" id="phone" value="<?= $user["phone_number"] ?>">
    </div>
    <div class="mb-3">
      <label for="address" class="form-label">Address</label>
      <input type="text" class="form-control" name="address" id="address" value="<?= $user["address"] ?>">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="text" class="form-control" name="email" id="email" value="<?= $user["email"] ?>">
    </div>
    <input class="visually-hidden" type="text" name="id" value=<?= $id ?>>
    <button type="submit" class="btn btn-success">Edit</button>
    <a href="/index.php" type="submit" class="btn btn-primary">Cancel</a>
  </form>
</div>

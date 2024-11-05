<?php
require_once "../includes/header.php";

include "../includes/helpers.php";

session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST" || $_SESSION["role"] != "Admin") {
   Header("Location: ../index.php");
}


include "../class/Database.php";
$database = new Database();
$connect = $database->getConnection();

if (isset($_POST["confirm"])) {
   $id = $_POST["id"];
   $delete_sql = "DELETE FROM User WHERE id='$id'";
   if ($connect->query($delete_sql) === TRUE) {
      Header("Location: /users/index.php");
   }
   else {
      Header("Location: /users/index.php");
   }
}

$id = $_POST["id"];
$query = "SELECT * FROM User WHERE id=$id";
$result = $connect->query($query);
$user = $result->fetch_assoc();

?>

<body>
   <div class="container pt-4">
      <div class="card">
         <h5 class="card-header">Delete User</h5>
         <div class="card-body">
            <h5 class="card-title">
               Are you sure to delete user
               <span class="text-primary"><?= $user["fullname"], $id?></span>,
               username=<span class="text-primary"><?= $user["username"] ?></span>,
               role=<span class="text-primary"><?= getRole($user["role"]) ?></span>,
            </h5>

            <div class="pt-2">
               <a class="btn btn-outline-primary" href="/users/index.php">Cancel</a>
               <form class="d-inline-block" action="./delete.php" method="POST">
                  <input name="id" class="visually-hidden" type="text" value="<?= $id ?>">
                  <input name="confirm" class="visually-hidden" type="text" value=1>
                  <button type="submit" class="btn btn-danger">Delete</button>
               </form>
            </div>
         </div>
      </div>
      </d

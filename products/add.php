<?php
session_start();
if (!isset($_SESSION["userId"]) || !isset($_SESSION["role"]) || $_SESSION["role"] != "Admin") {
  Header("Location: ../index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  include_once "../class/Database.php";
  include_once "../class/Product.php";

  // Validate input
  $errors = [];
  if (empty($_POST['title'])) {
    $errors[] = "You must provide a title";
  }
  if (empty($_POST["description"])) {
    $errors[] = "You must provide a description";
  }
  if (empty($_POST["price"])) {
    $errors[] = "You must provide a price";
  }

  if (empty($errors)) {
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);

    $product->title = $_POST["title"];
    $product->description = $_POST["description"];
    $product->price = $_POST["price"];
    $product->thumbnail = $_POST["thumbnail"];

    if ($product->create()) {
      echo "<div class='alert alert-success'>Product was created.</div>";
    } else {
      echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
  }
}
?>


<?php include_once "../includes/header.php"; ?>

<body>
  <?php if (!empty($errors)) : ?>
    <?php foreach ($errors as $error) : ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <div class="container mt-3">
    <form method="POST" , action="add.php">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" name="title" id="title">
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" name="price" id="price">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" name="description" id="description">
      </div>
      <div class="mb-3">
        <label for="thumbnail" class="form-label">Thumbnail</label>
        <input type="text" class="form-control" name="thumbnail" id="thumbnail">
      </div>
      <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="text" class="form-control" name="quantity" id="quantity">
      </div>
      <a href="./index.php" class="btn btn-outline-dark">Cancel</a>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</body>

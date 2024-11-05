<?php
session_start();
if (!isset($_SESSION["userId"]) || !isset($_SESSION["role"]) || $_SESSION["role"] != "Admin") {
  Header("Location: ../index.php");
}

include_once "../class/Database.php";
include_once "../class/Product.php";


// get database connection
$database = new Database();
$db = $database->getConnection();
$productObj = new Product($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
  if (empty($_POST["quantity"])) {
    $errors[] = "You must provide a quantity";
  }

  if (empty($errors)) {

    $id = $_POST["id"];
    $productObj->title = $_POST["title"];
    $productObj->description = $_POST["description"];
    $productObj->price = $_POST["price"];
    $productObj->thumbnail = $_POST["thumbnail"];
    $productObj->quantity = $_POST["quantity"];

    if ($productObj->updateProductById($id)) {
      echo "<div class='alert alert-success'>Product was updated.</div>";
      $product = $productObj->getProductById($id);
    } else {
      echo "<div class='alert alert-danger'>Unable to update product.</div>";
    }
  }
} else {
  $id = $_GET["id"];
  if (!isset($id)) {
    Header("Location: ../index.php");
  }

  $product = $productObj->getProductById($id);
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
    <form method="POST" , action="edit.php">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" name="title" id="title" value="<?= $product['title'] ?>">
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" name="price" id="price" value="<?= $product['price'] ?>">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" name="description" id="description" value="<?= $product['description'] ?>">
      </div>
      <div class="mb-3">
        <label for="thumbnail" class="form-label">Thumbnail</label>
        <input type="text" class="form-control" name="thumbnail" id="thumbnail"  value="<?= $product['thumbnail'] ?>">
      </div>
      <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="text" class="form-control" name="quantity" id="quantity" value="<?= $product['available'] ?>">
      </div>
      <input class="visually-hidden" type="text" name="id" value=<?= $id ?>>
      <a href="./index.php" class="btn btn-outline-dark">Cancel</a>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</body>

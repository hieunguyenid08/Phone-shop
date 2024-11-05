<?php
class Product
{
  // database connection and table name
  private $connect;
  private $table_name = "product";

  // object properties
  public $id;
  public $title;
  public $price;
  public $quantity;
  public $thumbnail;
  public $description;
  public $category_id;
  public $timestamp;

  public function __construct($db)
  {
    $this->connect = $db;
  }

  // create product
  function create()
  {
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->price = htmlspecialchars(strip_tags($this->price));
    $this->description = htmlspecialchars(strip_tags($this->description));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->timestamp = date('Y-m-d H:i:s');
    $this->quantity = htmlspecialchars(strip_tags($this->quantity));

    $query = "INSERT INTO " . $this->table_name . " (title, price, description, created_at, thumbnail, available)
               VALUES ('$this->title','$this->price', '$this->description', '$this->timestamp', '$this->thumbnail', '$this->quantity')";


    try {
      $this->connect->query($query);
      $this->connect->close();
      return true;
    } catch (Exception) {
      $errors[] = $this->connect->error;
      $this->connect->close();
    }

    return true;
  }


  function readAll($where_sql, $limit)
  {
    $where_sql = $where_sql ?? '';
    $query = "SELECT * FROM " . $this->table_name . " " . $where_sql . "ORDER BY price ASC LIMIT $limit";
    $result = $this->connect->query($query);
    $products = $result->fetch_all(MYSQLI_ASSOC);
    return $products;
  }

  function getProductById($id)
  {
    $query = "SELECT * FROM " . $this->table_name . " WHERE id=$id";
    $result = $this->connect->query($query);
    return $result->fetch_assoc() ?? false;
  }

  function deleteProductById($id)
  {
    $delete_sql = "DELETE FROM " . $this->table_name . " WHERE id='$id'";
    if ($this->connect->query($delete_sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  }

  function updateProductById($id)
  {
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->price = htmlspecialchars(strip_tags($this->price));
    $this->description = htmlspecialchars(strip_tags($this->description));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->timestamp = date('Y-m-d H:i:s');
    $this->quantity = htmlspecialchars(strip_tags($this->quantity));

    $update_sql = "UPDATE " . $this->table_name . " SET title='$this->title', price='$this->price', updated_at='$this->timestamp', thumbnail='$this->thumbnail', available='$this->quantity' WHERE id='$id'";
    if ($this->connect->query($update_sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  }
}

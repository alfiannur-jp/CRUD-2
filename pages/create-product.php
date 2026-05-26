<?php
//CEK CATEGORIES
if (isset($_POST['simpan'])) {

  $category_id = htmlspecialchars($_POST['category_id']);
  $product_name = htmlspecialchars($_POST['product_name']);

  // ambil file
  $products_image = time() . '_' . $_FILES['products_image']['name'];
  $tmp_name = $_FILES['products_image']['tmp_name'];

  $quantity = htmlspecialchars($_POST['qty']);
  $price = htmlspecialchars($_POST['price']);
  $unit = htmlspecialchars($_POST['unit']);
  $description = $_POST['description'];
  $is_active = isset($_POST['is_active']) ? 1 : 0;

  // upload file
  move_uploaded_file($tmp_name, "assets/uploads/" . $products_image);

  // cek product
  $cek = mysqli_query($koneksi, "SELECT product_name FROM products WHERE product_name='$product_name'");

  if (mysqli_num_rows($cek) > 0) {
    header("location:?page=create-product&status=product-exist");
    exit();
  }

  try {

    $query = mysqli_query($koneksi, "INSERT INTO products 
    (category_id, product_name, products_image, qty, price, unit, description, is_active ) 
    VALUES 
    ('$category_id', '$product_name', '$products_image', '$quantity', '$price', '$unit', '$description', '$is_active')");

    if ($query) {
      header("location:?page=product&status=success");
      exit();
    }
  } catch (Exception $e) {
    echo "Error woi: " . $e;
  }
}

$id = $_GET['edit'] ?? '';
$query = mysqli_query($koneksi, "SELECT * FROM products WHERE id='$id'");
$edit = mysqli_fetch_assoc($query);

if (isset($_POST['edit'])) {
  $category_id = htmlspecialchars($_POST['category_id']);
  $product_name = htmlspecialchars($_POST['product_name']);
  $products_image = $_FILES['products_image'];
  $tmp_name = $_FILES['products_image']['tmp_name'];
  $quantity = htmlspecialchars($_POST['qty']);
  $price = htmlspecialchars($_POST['price']);
  $unit = htmlspecialchars($_POST['unit']);
  $description = $_POST['description'];
  $is_active = isset($_POST['is_active']) ? 1 : 0;

  if ($_FILES['product_name']['name'] != '') {
    $products_image = time() . '_' . $_FILES['products_image']['name'];
    $tmp_name = $_FILES['products_image']['tmp_name'];
    if (file_exists("assets/uploads/" . $edit['products_image']) && !empty($edit['products_image'])) {
      unlink("assets/uploads/" . $edit['products_image']);
    }
    move_uploaded_file($tmp_name, "assets/uploads/" . $products_image);
  } else {
    $products_image = $edit['products_image'];
  }

  $query = mysqli_query($koneksi, "UPDATE products SET category_id='$category_id', product_name ='$product_name', products_image='$products_image', qty='$quantity', price='$price', unit='$unit', description='$description', is_active='$is_active' WHERE id='$id'");
  if ($query) {
    header('location:?page=product&status=success');
    exit();
  }
}
?>

<div class="card">
  <h5 class="card-header">
    Create Products
  </h5>
  <div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="" class="from-label">Product Name</label>
        <select name="category_id" id="" class="form-select">
          <option value=""> -- Choose Categoty -- </option>
          <?php
          $cat = mysqli_query($koneksi, "SELECT * FROM categories");
          $row_categories = mysqli_fetch_all($cat, MYSQLI_ASSOC);
          foreach ($row_categories as $key => $v) {
          ?>
            <option value="<?= $v['id'] ?>"><?= $v['category_name'] ?></option>
          <?php
          }
          ?>
        </select>
        <div class="mb-3">
          <label for="" class="form-label">Product Name</label>
          <input type="text" value="<?= isset($_GET['edit']) ? $edit['product_name'] : '' ?>" class="form-control" name="product_name" required>
        </div>
        <div class="mb-3">
          <label for="" class="form-label">Products Image</label>
          <input type="file" value="<?= isset($_GET['edit']) ? $edit['products_image'] : '' ?>" class="form-control" name="products_image" required>
        </div>
        <div class="mb-3">
          <label for="" class="form-label">Quantity</label>
          <input type="number" value="<?= isset($_GET['edit']) ? $edit['qty'] : '' ?>" class="form-control" name="qty" required>
        </div>
        <div class="mb-3">
          <label for="" class="form-label">Price</label>
          <input type="number" value="<?= isset($_GET['edit']) ? $edit['price'] : '' ?>" class="form-control" name="price" required>
        </div>
        <div class="mb-3">
          <label for="" class="form-label">Unit</label>
          <input type="text" value="<?= isset($_GET['edit']) ? $edit['unit'] : '' ?>" class="form-control" name="unit" required>
        </div>
        <div class="mb-3">
          <label for="" class="form-label">Description</label>
          <textarea name="description" class="form-control" cols="30" rows="5" id=""><?= isset($_GET['edit']) ? $edit['description'] : '' ?></textarea>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" value="1" id="flexSwitchCheckChecked" name="is_active" checked>
          <label class="form-check-label" for="flexSwitchCheckChecked">Status (Active/Inactive)</label>
        </div>
      </div>
      <?php
      if (isset($_GET['status']) && $_GET['status'] == 'product-exist') {
        $status = "product Name Already Exist!";
        echo inputFailed($status);
      }
      ?>
      <br>
      <button type="submit" name="<?= isset($_GET['edit']) ? 'edit' : 'simpan' ?>" class="btn btn-primary mt-2"><?= isset($_GET['edit']) ? 'Edit' : 'Save' ?></button>
      <a href="?page=product" class="btn btn-secondary mt-2">Cancel</a>
    </form>
  </div>
</div>
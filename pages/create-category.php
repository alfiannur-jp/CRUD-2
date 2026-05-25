<?php
//CEK CATEGORIES
if (isset($_POST['simpan'])) {
  $category_name = htmlspecialchars($_POST['category_name']);
  $cek = mysqli_query($koneksi, "SELECT category_name FROM categories WHERE category_name='$category_name'");
  if (mysqli_num_rows($cek) > 0) {
    header("location:?page=create-category&status=category-exist");
  }
  //END CEK CATEGORIES
  $query = mysqli_query($koneksi, "INSERT INTO categories (category_name) VALUES ('$category_name')");
  if ($query) {
    header("location:?page=category&status=success");
    exit();
  }
}
?>

<div class="card">
  <h5 class="card-header">
    Create Category
  </h5>
  <div class="card-body">
    <form action="" method="post">
      <label for="" class="from-label">Category Name</label>
      <input type="text" class="form-control" name="category_name" required>
      <?php
      if (isset($_GET['status']) && $_GET['status'] == 'category-exist') {
        $status = "Category Name Already Exist!";
        echo inputFailed($status);
      }
      ?>
      <br>
      <button type="submit" name="simpan" class="btn btn-primary mt-2">Create</button>
      <a href="?page=category" class="btn btn-secondary mt-2">Cancel</a>
    </form>
  </div>
</div>
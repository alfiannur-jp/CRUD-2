<?php
$select = mysqli_query($koneksi, "SELECT products.*, categories.category_name FROM products LEFT JOIN categories ON products.category_id = categories.id ORDER BY id DESC");
$row_products = mysqli_fetch_all($select, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
  $id = $_GET['delete'] ?? 0;
  $cekFoto = mysqli_query($koneksi, "SELECT products_image FROM products WHERE id='$id'");
  $rowFoto = mysqli_fetch_assoc($cekFoto);
  if ($rowFoto) {
    $foto = $rowFoto['products_image'];
    if (file_exists("assets/uploads/" . $foto) && !empty($foto)) {
      unlink("assets/uploads/" . $foto);
    }
  }
  $delete = mysqli_query($koneksi, "DELETE FROM products WHERE id='$id'");
  header("location:?page=product");
  exit();
}
?>

<div class="card">
  <h5 class="card-header">
    Manage Product
  </h5>
  <div class="card-body">
    <div class="mb-2 d-flex justify-content-end">
      <a href="?page=create-product" class="btn btn-primary">+ Create Products</a>
    </div>
    <div class="table-responsive">
      <?php
      // if (isset($_GET['status']) && $_GET['status'] == 'success') {
      //   $status = "Data Berhasil ditambah!";
      //   $location = "?page=category";
      //   echo statusSuccess($status, $location);
      // }
      ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Image</th>
            <th>Product Name</th>
            <th>Category Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Unit</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($row_products as $index => $r) {
          ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><img src="assets/uploads/<?= $r['products_image'] ?>" alt="" width="80px"></td>
              <td><?= $r['product_name'] ?></td>
              <td><?= $r['category_name'] ?></td>
              <td><?= $r['qty'] ?></td>
              <td><?= $r['price'] ?></td>
              <td><?= $r['unit'] ?></td>
              <td><?= $r['description'] ?></td>
              <td><?= getStatus($r['is_active']) ?></td>
              <td>
                <a href="?page=create-product&edit=<?= $r['id'] ?>" class="btn btn-success">Edit</a>
                <form action="?page=product&delete=<?= $r['id'] ?> ?>" method="post" class="d-inline">
                  <button class="btn btn-danger" onclick="return confirm('Sure Delete?')">Delete</button>
                </form>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
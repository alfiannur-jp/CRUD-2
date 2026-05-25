<div class="card">
  <h5 class="card-header">
    Manage Category
  </h5>
  <div class="card-body">
    <div class="mb-2 d-flex justify-content-end">
      <a href="?page=create-category" class="btn btn-primary">+ Create Category</a>
    </div>
    <div class="table-responsive">
      <?php
      if (isset($_GET['status']) && $_GET['status'] == 'success') {
        $status = "Data Berhasil ditambah!";
        $location = "?page=category";
        echo statusSuccess($status, $location);
      }
      ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Category Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
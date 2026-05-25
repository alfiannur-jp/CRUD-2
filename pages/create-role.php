<?php
if (isset($_POST['simpan'])) {

    $name = htmlspecialchars($_POST['name']);
    $status = htmlspecialchars($_POST['is_active']);
    $description = htmlspecialchars($_POST['description']);

    mysqli_query($koneksi, "INSERT INTO roles (name,is_active,description)
    VALUES ('$name','$status','$description')");

    header('location:?page=role&status=success');
    exit;
}

$id = $_GET['edit'] ?? '';

$query = mysqli_query($koneksi, "SELECT * FROM roles WHERE id='$id'");

$edit = mysqli_fetch_assoc($query);

if (isset($_POST['edit'])) {

    $name = htmlspecialchars($_POST['name']);
    $status = htmlspecialchars($_POST['is_active']);
    $description = htmlspecialchars($_POST['description']);

    mysqli_query($koneksi, "UPDATE roles
    SET
    name='$name',
    is_active='$status',
    description='$description'
    WHERE id='$id'");

    header('location:?page=role');
    exit;
}
?>

<div class="card">

    <h5 class="card-header">
        <?= isset($_GET['edit']) ? "edit" : "Create" ?> Roles
    </h5>

    <div class="card-body">

        <form action="" method="post">

            <div class="row mb-3">

                <div class="row">
                    <label class="form-label">Role Name</label>

                    <input type="text" name="name" value="<?= isset($_GET['edit']) ? $edit['name'] : '' ?>">
                </div>

                <label>Status</label>

                <div class="col-4">

                    <!-- ACTIVE -->
                    <input type="radio" id="adm" value="1" name="is_active"
                        <?= isset($_GET['edit']) && $edit['is_active'] == 1 ? 'checked' : '' ?>
                        <?= !isset($_GET['edit']) ? 'checked' : '' ?>>

                    <label for="adm">Active</label>
                    <br>

                    <!-- INACTIVE -->
                    <input type="radio" id="usr" value="0" name="is_active"
                        <?= isset($_GET['edit']) && $edit['is_active'] == 0 ? 'checked' : '' ?>>

                    <label for="usr">Inactive</label>
                    <br>

                </div>

                <div class="row">

                    <label class="form-label">Description</label>

                    <textarea name="description"><?= isset($_GET['edit']) ? $edit['description'] : '' ?></textarea>

                </div>

            </div>

            <div class="text-end mt-2">

                <button type="submit" class="btn btn-primary" name="<?= isset($_GET['edit']) ? 'edit' : 'simpan' ?>">

                    <?= isset($_GET['edit']) ? 'Save Change' : 'Save' ?>

                </button>

                <a href="?page=role" class="btn btn-secondary">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>
<?php
if (isset($_POST['simpan'])) {


    $name = htmlspecialchars($_POST['name']);
    $parent_id = htmlspecialchars($_POST['parent_id']) ?: 'NULL';
    $url = htmlspecialchars($_POST['url']);
    $icon = htmlspecialchars($_POST['icon']);
    $is_active = htmlspecialchars($_POST['is_active']);
    $sort_order = htmlspecialchars($_POST['sort_order']);

    mysqli_query($koneksi, "INSERT INTO menus (name,parent_id,url,icon,is_active,sort_order)
    VALUES ('$name',$parent_id,'$url', '$icon','$is_active', '$sort_order')");

    header('location:?page=menu&status=success');
    exit;
}

$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$edit = null;

if ($editId > 0) {
    $query = mysqli_query($koneksi, "SELECT * FROM menus WHERE id='$editId'");
    $edit = mysqli_fetch_assoc($query);
}

if (isset($_POST['edit'])) {


    $name = htmlspecialchars($_POST['name']);
    $parent_id = htmlspecialchars($_POST['parent_id']) ?: 'NULL';
    $url = htmlspecialchars($_POST['url']);
    $icon = htmlspecialchars($_POST['icon']);
    $is_active = htmlspecialchars($_POST['is_active']);
    $sort_order = htmlspecialchars($_POST['sort_order']);

    mysqli_query($koneksi, "UPDATE menus SET name='$name', is_active='$is_active', parent_id=$parent_id, url='$url', icon='$icon' , sort_order='$sort_order' WHERE id='$editId'");
    header('location:?page=menu');
    exit;
}

$queryParent = mysqli_query($koneksi, "SELECT * FROM menus WHERE parent_id IS NULL OR parent_id = 0");
$rowParent = mysqli_fetch_all($queryParent, MYSQLI_ASSOC)
?>

<div class="card">

    <h5 class="card-header">
        <?= $editId > 0 ? "Edit Menu" : "Create Menu" ?>
    </h5>

    <div class="card-body">

        <form action="" method="post">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="menu-name">Name</label>
                        <input id="menu-name" type="text" name="name" class="form-control"
                            value="<?= $editId > 0 ? htmlspecialchars($edit['name']) : '' ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="parent-id">Parent Id</label>
                        <select name="parent_id" id="parent-id" class="form-control">
                            <option value="">Select One</option>
                            <?php foreach ($rowParent as $parent) : ?>
                                <option value="<?= $parent['id'] ?>"><?= $parent['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="menu-icon">Icon</label>
                        <input id="menu-icon" type="text" name="icon" class="form-control"
                            value="<?= $editId > 0 ? htmlspecialchars($edit['icon']) : '' ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="url">Sort Order</label>
                        <input id="url" type="text" name="sort_order" class="form-control"
                            value="<?= $editId > 0 ? htmlspecialchars($edit['sort_order']) : '' ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="url">URL</label>
                        <input id="url" type="text" name="url" class="form-control"
                            value="<?= $editId > 0 ? htmlspecialchars($edit['url']) : '' ?>">
                    </div>
                </div>
                <div class="col-md-6">

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
            </div>

            <div class="text-end mt-2">
                <button type="submit" class="btn btn-primary" name="<?= $editId > 0 ? 'edit' : 'simpan' ?>">
                    <?= $editId > 0 ? 'Save Change' : 'Save' ?>
                </button>
                <a href="?page=menu" class="btn btn-secondary">Batal</a>
            </div>

        </form>

    </div>

</div>
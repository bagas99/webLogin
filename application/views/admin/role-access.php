<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

  <div class="row">
    <div class="col-lg-6">
<!-- alert gagal -->
      <?= form_error('menu', '<div class="alert alert-danger" role="alert">','</div>'); ?> 

<!-- alert sukses -->
      <?= $this->session->flashdata('message'); ?>

      <h5>Role : <?= $role['role']; ?></h5>

      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Menu</th>
            <th scope="col">Access</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <!-- LOOPING MENU -->
          <?php foreach ($menu as $m) : ?>
          <tr>
            <th scope="row"><?= $i; ?></th>
            <td><?= $m['menu']; ?></td>
            <td>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" <?= check_access($role['id'], $m['id']); ?>  data-role="<?= $role['id']; ?>" data-menu="<?= $m['id']; ?>"> <!-- check_access untuk helper, data-role & -menu untuk memanggil jquery -->
                    <!-- fungsi di atas untuk membuat checklist ACCESS sesuai dengan user role. -->
                    <!-- fungsi diatas menerima 2 parameter 1. role_id berapa (line 15), 2. menu_id berapa (line 28) -->
                </div>
            </td>
          </tr>
          <?php $i++; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<!-- Table with stripped rows -->
<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<?php
if (session()->getFlashData('failed')) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
    Tambah Data
</button>
<div class="clearfix"></div>

<table class="table datatable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nominal</th>
            <th scope="col"> </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($discounts as $index => $discount) : ?>
            <tr>
                <th scope="row"><?php echo $index + 1 ?></th>
                <td><?php echo $discount['tanggal'] ?></td>
                <td><?php echo $discount['nominal'] ?></td>
                <td>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal-<?= $discount['id'] ?>">
                        Ubah
                    </button>
                    <a href="<?= base_url('diskon/delete/' . $discount['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus data diskon ini ?')">
                        Hapus
                    </a>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal-<?= $discount['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ubah Data Diskon</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <?= form_open('diskon/edit/' . $discount['id']) ?>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="tanggal" value="<?= $discount['tanggal'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="nominal" class="col-sm-3 col-form-label">Nominal</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="nominal" value="<?= $discount['nominal'] ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
            <!-- End Modal Edit -->

        <?php endforeach ?>
    </tbody>
</table>
<!-- End Table with stripped rows -->

<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Diskon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('diskon') ?>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="tanggal" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="nominal" class="col-sm-3 col-form-label">Nominal</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="nominal" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<!-- End Modal Add -->

<?= $this->endSection() ?>

<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

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

<div class="table-responsive">
    <!-- Table with stripped rows -->
    <table class="table datatable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID Pembelian</th>
                <th scope="col">Waktu Pembelian</th>
                <th scope="col">Pembeli</th>
                <th scope="col">Total Bayar</th>
                <th scope="col">Alamat</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($transactions)) :
                foreach ($transactions as $index => $item) :
            ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['created_at'] ?></td>
                        <td><?= $item['username'] ?></td>
                        <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                        <td><?= $item['alamat'] ?></td>
                        <td>
                            <?= ($item['status'] == "1")
                                ? '<span class="badge bg-success">Sudah Dikirim</span>'
                                : '<span class="badge bg-warning">Pending</span>' ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                                Detail
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#statusModal-<?= $item['id'] ?>">
                                Ubah Status
                            </button>
                        </td>
                    </tr>
            <?php
                endforeach;
            endif;
            ?>
        </tbody>
    </table>
    <!-- End Table with stripped rows -->
</div>

<?php if (!empty($transactions)) : ?>
    <?php foreach ($transactions as $item) : ?>
        <!-- Status Modal Begin -->
        <div class="modal fade" id="statusModal-<?= $item['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Status Transaksi #<?= $item['id'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?= form_open('admin-transaksi/update-status/' . $item['id']) ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status Pesanan</label>
                            <select name="status" class="form-select">
                                <option value="0" <?= $item['status'] == '0' ? 'selected' : '' ?>>Pending</option>
                                <option value="1" <?= $item['status'] == '1' ? 'selected' : '' ?>>Sudah Dikirim / Selesai</option>
                            </select>
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
        <!-- Status Modal End -->

        <!-- Detail Modal Begin -->
        <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Transaksi #<?= $item['id'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($products[$item['id']])) : ?>
                            <?php foreach ($products[$item['id']] as $index2 => $item2) : ?>
                                <?= $index2 + 1 . ")" ?>

                                <?php
                                $imagePath = FCPATH . 'img/' . $item2['foto'];

                                if (!empty($item2['foto']) && file_exists($imagePath)) :
                                ?>
                                    <div class="my-2">
                                        <img src="<?= base_url('img/' . $item2['foto']) ?>" width="100" class="img-thumbnail">
                                    </div>
                                <?php endif; ?>

                                <strong><?= $item2['nama'] ?></strong>
                                <?= number_to_currency($item2['harga'], 'IDR') ?>
                                <br>
                                <?= "(" . $item2['jumlah'] . " pcs)" ?><br>
                                <?= number_to_currency($item2['subtotal_harga'], 'IDR') ?>
                                <hr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        Ongkir <?= number_to_currency($item['ongkir'], 'IDR') ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Detail Modal End -->
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<!-- Table with stripped rows -->
<div class="row">
    <?php foreach ($products as $key => $item) : ?>
        <div class="col-lg-6">
            <?= form_open('keranjang') ?>
            <?php
            $harga_tampil = $item['harga'];
            $harga_asli = $item['harga'];
            if (isset($activeDiscount) && $activeDiscount) {
                $harga_tampil = $item['harga'] - $activeDiscount['nominal'];
                if ($harga_tampil < 0) $harga_tampil = 0;
            }
            
            echo form_hidden('id', (string)$item['id']);
            echo form_hidden('nama', $item['nama']);
            echo form_hidden('harga', (string)$harga_tampil);
            echo form_hidden('harga_asli', (string)$harga_asli);
            echo form_hidden('foto', $item['foto']);
            ?>
            <div class="card">
                <div class="card-body">
                    <img src="<?= base_url() . "img/" . $item['foto'] ?>" alt="..." width="50%">
                    <h5 class="card-title" style="color: #012970;"><?= $item['nama'] ?><br>
                        <?php if (isset($activeDiscount) && $activeDiscount): ?>
                            <del class="text-danger" style="font-size: 0.85em;"><?php echo number_to_currency($harga_asli, 'IDR') ?></del>
                            <span style="color: #012970; font-weight: 600; font-size: 1.1em;" class="ms-1"><?php echo number_to_currency($harga_tampil, 'IDR') ?></span>
                        <?php else: ?>
                            <span style="color: #012970; font-weight: 600; font-size: 1.1em;"><?php echo number_to_currency($harga_tampil, 'IDR') ?></span>
                        <?php endif; ?>
                    </h5>
                    <button type="submit" class="btn btn-info rounded-pill">Beli</button>
                </div>
            </div>

            <?= form_close() ?>
        </div>
    <?php endforeach ?>
</div>
<!-- End Table with stripped rows -->
<?= $this->endSection() ?>
<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-xl ">
    <div class="container mt-5">
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>


        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif ?>


        <form action="/peserta/<?= esc($progress->id)  ?>/update-payment" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="old_redeem_code" value="<?= $progress->redeem_code   ?>">

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Peserta</span>
                <input type="text" name="peserta_name" class="form-control" value="<?= set_value('peserta_name', $progress->peserta_name ?? '') ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                <input type="text" name="email" class="form-control" value="<?= set_value('email', $progress->email ?? '') ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Kelas</span>
                <input type="text" name="class_name" class="form-control" value="<?= $progress->class_name ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Jadwal</span>
                <input type="text" name="jadwal" class="form-control" value="<?= $progress->jadwal ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Tipe</span>
                <input type="text" name="tipe" class="form-control" value="<?= $progress->tipe ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Pembayaran</span>
                <select name="is_paymented" class="form-select" id="is_paymented">
                    <option value="0">Tidak</option>
                    <option value="1">Ya</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Periode Pembayaran</span>
                <input type="text" name="payment_period" class="form-control" value="<?= set_value('payment_period', $progress->payment_period ?? '') ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>

            <a href="/peserta" type="button" name="back" class="btn btn-secondary">Back</a>
            <button type="submit" name="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    const is_paymented = <?php echo json_encode($progress->is_paymented === '0' ? false : true) ?>;
    $('#is_paymented').val(<?php echo json_encode($progress->is_paymented) ?>)
    $('input[name="payment_period"]').attr('disabled', !is_paymented)
    $(document).on('change', '#is_paymented', function() {
        const val = $(this).val() === '0' ? false : true;
        $('input[name="payment_period"]').attr('disabled', !val)
    })
</script>
<?= $this->endSection() ?>
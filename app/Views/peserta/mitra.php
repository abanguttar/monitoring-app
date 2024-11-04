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


        <form action="/peserta/<?= esc($peserta->peserta_id)  ?>/update-mitra/<?= $peserta->master_class_id ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Peserta</span>
                <input type="text" name="peserta_name" class="form-control" value="<?= set_value('peserta_name', $peserta->peserta_name ?? '') ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                <input type="text" name="email" class="form-control" value="<?= set_value('email', $peserta->email ?? '') ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Phone</span>
                <input type="text" name="phone" class="form-control" value="<?= set_value('phone', $peserta->phone ?? '') ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Kelas</span>
                <input type="text" name="class_name" class="form-control" value="<?= set_value('class_name', $peserta->class_name ?? '') ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Jadwal</span>
                <input type="text" name="jadwal" class="form-control" value="<?= set_value('jadwal', $peserta->jadwal ?? '') ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Voucher</span>
                <input type="text" name="voucher" class="form-control" value="<?= set_value('voucher', $peserta->voucher ?? '') ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Invoice</span>
                <input type="text" name="invoice" class="form-control" value="<?= set_value('invoice', $peserta->invoice ?? '') ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Mitra</span>
                <div aria-describedby="inputGroup-sizing-default" style="width: 90%;">
                    <select name="mitra_id" id="mitra_id" class="form-select">
                        <option value="">--- Pilih Mitra ---</option>
                        <?php foreach ($mitras as $mitra): ?>
                            <option value="<?= esc($mitra->id) ?>"><?= esc($mitra->mitra_name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <a href="/peserta" type="button" name="back" class="btn btn-secondary">Back</a>
            <button type="submit" name="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('select[name="master_class_id"]').val(<?php echo json_encode($peserta->master_class_id) ?>)

        const val = <?php echo json_encode($peserta->mitra_id)  ?>;
        const mitra_id = val === '0' ? '' : val;
        $('#mitra_id').select2({
            width: '100%'
        }).val(mitra_id).trigger('change');
    })
</script>
<?= $this->endSection() ?>
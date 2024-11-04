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


        <form action="/peserta" method="post">
            <?= csrf_field() ?>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Peserta</span>
                <input type="text" name="peserta_name" class="form-control" value="<?= set_value('peserta_name') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                <input type="text" name="email" class="form-control" value="<?= set_value('email') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Phone</span>
                <input type="text" name="phone" class="form-control" value="<?= set_value('phone') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Kelas</span>
                <div aria-describedby="inputGroup-sizing-default" style="width: 90%;">

                    <select name="master_class_id" class="form-select" id="master_class_id">
                        <option value="">---Pilih Nama Kelas----</option>
                        <?php foreach ($master_classes as $master_class): ?>
                            <option value="<?= esc($master_class['id']) ?>"><?= esc($master_class['class_name']) . ' - ' . esc($master_class['jadwal']) ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Voucher</span>
                <input type="text" name="voucher" class="form-control" value="<?= set_value('voucher') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Invoice</span>
                <input type="text" name="invoice" class="form-control" value="<?= set_value('invoice') ?>" aria-describedby=" inputGroup-sizing-default">
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
        $('#master_class_id').select2()
    })
</script>
<?= $this->endSection() ?>
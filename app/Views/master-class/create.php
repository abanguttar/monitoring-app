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


        <form action="/master-class" method="post">
            <?= csrf_field() ?>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Kelas</span>
                <input type="text" name="class_name" class="form-control" value="<?= set_value('class_name') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Jadwal</span>
                <input type="text" name="jadwal" class="form-control" value="<?= set_value('jadwal') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Jam</span>
                <input type="text" name="jam" class="form-control" value="<?= set_value('jam') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Jenis Kelas</span>
                <select name="is_prakerja" class="form-select" id="">
                    <option value="0">Umum</option>
                    <option value="1">Prakerja</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Luring / Daring</span>
                <select name="tipe" class="form-select" id="">
                    <option value="Luring">Luring</option>
                    <option value="Daring">Daring</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Harga</span>
                <input type="text" name="price" inputmode="numeric" class="form-control" value="<?= set_value('price') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <a href="/master-class" type="button" name="back" class="btn btn-secondary">Back</a>
            <button type="submit" name="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
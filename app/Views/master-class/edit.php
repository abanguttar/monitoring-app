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


        <form action="/master-class/<?= $data['id'] ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">


            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Kelas</span>
                <input type="text" name="class_name" class="form-control" value="<?= set_value('class_name', $data['class_name'] ?? '') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Jadwal</span>
                <input type="text" name="jadwal" class="form-control" value="<?= set_value('jadwal', $data['jadwal'] ?? '') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Jam</span>
                <input type="text" name="jam" class="form-control" value="<?= set_value('jam', $data['jam'] ?? '') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Jenis Kelas</span>
                <select name="is_prakerja" class="form-select" id="">
                    <option value="0" <?= $data['is_prakerja'] === '0' ? 'selected'  : '' ?>>Umum</option>
                    <option value="1" <?= $data['is_prakerja'] === '1' ? 'selected'  : '' ?>>Prakerja</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Luring / Daring</span>
                <select name="tipe" class="form-select" id="">
                    <option value="Luring" <?= $data['tipe'] === 'Luring' ? 'selected'  : '' ?>>Luring</option>
                    <option value="Daring" <?= $data['tipe'] === 'Daring' ? 'selected'  : '' ?>>Daring</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Harga</span>
                <input type="text" name="price" inputmode="numeric" class="form-control" value="<?= set_value('price', $data['price'] ?? '') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <a href="/master-class" type="button" name="back" class="btn btn-secondary">Back</a>
            <button type="submit" name="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
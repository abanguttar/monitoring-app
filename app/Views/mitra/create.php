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


        <form action="/mitra" method="post">
            <?= csrf_field() ?>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Mitra</span>
                <input type="text" name="mitra_name" class="form-control" value="<?= set_value('mitra_name') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Penanggung Jawab</span>
                <input type="text" name="responsible" class="form-control" value="<?= set_value('responsible') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Alamat</span>
                <textarea type="text" name="address" class="form-control" value="<?= set_value('address') ?>" aria-describedby=" inputGroup-sizing-default"></textarea>
            </div>

            <a href="/mitra" type="button" name="back" class="btn btn-secondary">Back</a>
            <button type="submit" name="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
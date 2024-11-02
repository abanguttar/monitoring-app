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


        <form action="/digital-platform" method="post">
            <?= csrf_field() ?>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Digital Platform</span>
                <input type="text" name="dp_name" class="form-control" value="<?= set_value('dp_name') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <a href="/digital-platform" type="button" name="back" class="btn btn-secondary">Back</a>
            <button type="submit" name="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
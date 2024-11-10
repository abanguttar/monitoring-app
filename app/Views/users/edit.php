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


        <form action="/users/<?= $user->id ?>/edit" method="post">
            <?= csrf_field() ?>
            <input type="text" name="_method" value="PUT" hidden>

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Username</span>
                <input type="text" name="username" class="form-control" value="<?= set_value('username', $user->username ?? '') ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                <input type="text" name="email" class="form-control" value="<?= set_value('email', $user->email ?? '') ?>" aria-describedby=" inputGroup-sizing-default" disabled>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Password</span>
                <input type="password" name="password" class="form-control" value="<?= set_value('password') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>

            <a href="/users" type="button" name="back" class="btn btn-secondary">Back</a>
            <button type="submit" name="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
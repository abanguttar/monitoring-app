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


        <form action="/users/<?= $user->id ?>/permissions" method="post" style="margin-bottom: 10rem;">
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
            <input type="checkbox" class="form-check-input" id="check-all"> Check all <br>
            <div class="row mt-4">
                <?php foreach ($permissions as $key => $value) : ?>
                    <div class="col-6">
                        <p class="mb-0">--- <?= esc(ucwords(str_replace('_', ' ', $key))) ?></p>
                        <input type="checkbox" class="form-check-input checkbox" id="<?= esc($key) ?>"> Check all <br>
                        <ul class="list-group">
                            <?php foreach ($permissions[$key] as $val) : ?>
                                <li class="list-group-item">
                                    <input class="form-check-input checkbox checkbox-<?= esc($val['id']) ?> me-1 <?= esc($key) ?>" name="permissions[]" value="<?= esc($val['id']) ?>" type="checkbox" id="<?php esc($key . $val['name']) ?>">
                                    <label class="form-check-label" for="<?php esc($key . $val['name']) ?>"><?= esc($val['name']) ?></label>
                                </li>
                            <?php endforeach; ?> <br><br>
                        </ul>

                    </div>
                <?php endforeach; ?>
            </div>

            <a href="/users" type="button" name="back" class="btn btn-secondary">Back</a>
            <button type="submit" name="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).on('click', '#check-all', function() {
        const val = $(this).is(':checked');
        $('.checkbox').attr('checked', false);
        $('.checkbox').attr('checked', val);

    })
    <?php foreach ($permissions as $key => $value) : ?>
        $(document).on('click', '#<?php echo $key ?>', function() {
            $('.<?php echo $key ?>').attr('checked', $(this).is(':checked'))
        })

    <?php endforeach; ?>

    $(document).ready(function() {
        <?php foreach ($user_permissions as $val) : ?>
            $('.checkbox-<?php echo $val->permission_id ?>').attr('checked', true)

        <?php endforeach; ?>
    })
</script>
<?= $this->endSection() ?>
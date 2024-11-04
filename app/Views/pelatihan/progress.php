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


        <form action="/peserta/<?= esc($progress->id)  ?>/add-progress" method="post">
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
                <span class="input-group-text" id="inputGroup-sizing-default">Redeem Code</span>
                <input type="text" name="redeem_code" class="form-control" value="<?= set_value('redeem_code', $progress->redeem_code ?? '') ?>" aria-describedby=" inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">100% Pelatihan</span>
                <input type="text" name="is_finished" class="form-control" value="<?= set_value('is_finished', $progress->is_finished) ?>" aria-describedby=" inputGroup-sizing-default" disabled>
                <div class="form-check ms-2">
                    <input class="form-check-input" name="checked_box" type="checkbox" value="checked" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        100% Selesai
                    </label>
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
        const is_finished = <?php echo json_encode($progress->is_finished === NULL ? false : true) ?>;
        $('input[name="is_finished"]').attr('disabled', !is_finished)
        $('input[name="checked_box"]').attr('checked', is_finished)
        $(document).on('click', 'input[name="checked_box"]', function() {
            const val = $(this).is(':checked');
            $('input[name="is_finished"]').attr('disabled', !val)


        });
    })
</script>
<?= $this->endSection() ?>
<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid ">
    <div class="container mt-5">
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <ul style="list-style-type: none;">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('countErrors')): ?>
            <div class="alert alert-danger" style="list-style-type: none;">
                <?= session()->getFlashdata('countErrors') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
                <?= session()->getFlashdata('countSuccess') ?>
            </div>
        <?php endif ?>
        <form class="form-control" action="" enctype="multipart/form-data" method="POST">
            <h3 class="h4 mt-2 font-weight-bold text-center">Pilih Nama Pelatihan</h3>
            <div>
                <select name="master_class_id" id="master_class_id" class="form-control">
                    <option value="">--- Pilih Pelatihan ---</option>
                    <?php foreach ($master_classes as $master_class): ?>
                        <option value="<?= esc($master_class['id']) ?>"><?= esc($master_class['class_name']) . ' - ' . esc($master_class['jadwal']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="mt-5 ml-0 d-flex justify-content-center">
                <input class="ml-5 form-control" type="file" name="formFile" id="formFile">
                <input type="submit" class="btn btn-primary mx-2" name="submit" value="Upload File XLS/XLSX">
                <a href="/peserta" class="btn btn-secondary">Kembali </a>

            </div>
        </form>
    </div>

    <?php if ($messages !== null): ?>
        <button class="btn btn-sm btn-danger mt-5 ms-3" id="btn-delete-error-message">Hapus Data</button>
        <a href="/download/<?= esc($template)  ?>.xlsx" class="btn btn-success btn-sm mt-5 ms-1">Download Template Excel</a>
        <div class="container-fluid table-responsive mt-2">
            <?= $this->include('peserta/error-table') ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#master_class_id').select2()

        $(document).on('click', '#btn-delete-error-message', function() {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {

                fetch('/delete-table-message', {
                    method: 'DELETE',
                }).then(res => {
                    return location.reload()
                })

                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Success delete table messages!",
                        icon: "success"
                    });
                }
            });
        })

    })
</script>
<?= $this->endSection() ?>
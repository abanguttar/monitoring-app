<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid ">

    <div class="container-fluid mt-2">
        <form action="" class="mt-5">
            <div class="col-12 col-lg-3">
                <select name="master_class_id" class="form-select" id="master_class_id">
                    <option value="">--- Pilih Pelatihan dan Jadwal ---</option>
                    <?php foreach ($master_classes as $key => $master_class): ?>
                        <option value="<?= esc($master_class['id']) ?>"><?= esc($master_class['class_name']) . ' - ' . esc($master_class['jadwal'])  ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-lg-3 mt-2">
                <button type="submit" class="btn btn-sm btn-info text-white">Cari</button>
                <a href="/peserta" class="btn btn-sm btn-dark text-white">Reset</a>
            </div>
        </form>
        <a href="master-class/new" class="btn mt-3 btn-success">Create Master Class</a>
        <button id="btn-edit" class="btn btn-primary mt-3">Edit Master Class</button>
        <table class="table table-sm table-bordered table-hovered table-striped mt-2">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Jadwal</th>
                    <th>Jam</th>
                    <th>Jenis Kelas</th>
                    <th>Daring/Luring</th>
                    <th>Harga</th>
                    <th>User Update</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $number = ($page - 1) * 50;
                ?>
                <?php foreach ($masterClasses as $key => $item): ?>
                    <tr class="table-row" data-id="master-class/<?= esc($item->id) ?>">
                        <td><?= ++$number ?></td>
                        <td><?= esc($item->class_name) ?></td>
                        <td><?= esc($item->jadwal) ?></td>
                        <td><?= esc($item->jam) ?></td>
                        <td><?= esc($item->is_prakerja) === 0 ? 'Umum' : 'Prakerja' ?></td>
                        <td><?= esc($item->tipe) ?></td>
                        <td><?= esc($item->price) ?></td>
                        <td><?= esc($item->username) ?></td>
                        <td><?= esc($item->updated_at) ?></td>
                    </tr>

                <?php endforeach ?>
            </tbody>
        </table>
        <div class="container-full" style="margin-bottom: 18rem!important;">
            <?= $this->include('/pagination/index'); ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $('#master_class_id').select2().val(<?php echo json_encode($params['master_class_id']) ?? '' ?>).trigger('change')
</script>
<?= $this->endSection() ?>
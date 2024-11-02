<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-xl ">
    <div class="container-xl mt-5">

        <a href="master-class/new" class="btn btn-success">Create Master Class</a>
        <button id="btn-edit" class="btn btn-primary">Edit Master Class</button>
        <table class="table table-bordered table-hovered table-striped mt-2">
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
                <?php foreach ($masterClasses as $key => $item): ?>
                    <tr class="table-row" data-id="master-class/<?= esc($item['id']) ?>">
                        <td><?= esc(++$key) ?></td>
                        <td><?= esc($item['class_name']) ?></td>
                        <td><?= esc($item['jadwal']) ?></td>
                        <td><?= esc($item['jam']) ?></td>
                        <td><?= esc($item['is_prakerja']) ?></td>
                        <td><?= esc($item['tipe']) ?></td>
                        <td><?= esc($item['price']) ?></td>
                        <td><?= esc($item['user_update']) ?></td>
                        <td><?= esc($item['updated_at']) ?></td>
                    </tr>

                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
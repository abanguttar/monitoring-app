<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid ">
    <div class="container-fluid mt-5">

        <a href="master-class/new" class="btn btn-success">Create Master Class</a>
        <button id="btn-edit" class="btn btn-primary">Edit Master Class</button>
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
            <?= $pager->links() ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
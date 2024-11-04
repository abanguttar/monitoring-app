<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-xl ">
    <div class="container mt-5">

        <a href="mitra/new" class="btn btn-success">Create Mitra</a>
        <button id="btn-edit" class="btn btn-primary">Edit Mitra</button>
        <table class="table table-bordered table-hovered table-striped mt-2">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Mitra</th>
                    <th>Alamat</th>
                    <th>Penanggung Jawab</th>
                    <th>User Update</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($mitras as $key => $item): ?>
                    <tr class="table-row" data-id="mitra/<?= esc($item->id) ?>">
                        <td><?= esc(++$key) ?></td>
                        <td><?= esc($item->mitra_name) ?></td>
                        <td><?= esc($item->address) ?></td>
                        <td><?= esc($item->responsible) ?></td>
                        <td><?= esc($item->username) ?></td>
                        <td><?= esc($item->updated_at) ?></td>
                    </tr>

                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
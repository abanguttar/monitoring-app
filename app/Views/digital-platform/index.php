<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-xl ">
    <div class="container mt-5">

        <a href="digital-platform/new" class="btn btn-success">Create DP</a>
        <button id="btn-edit" class="btn btn-primary">Edit DP</button>
        <table class="table table-bordered table-hovered table-striped mt-2">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama DP</th>
                    <th>User Update</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($dps as $key => $item): ?>
                    <tr class="table-row" data-id="digital-platform/<?= esc($item->id) ?>">
                        <td><?= esc(++$key) ?></td>
                        <td><?= esc($item->dp_name) ?></td>
                        <td><?= esc($item->username) ?></td>
                        <td><?= esc($item->updated_at) ?></td>
                    </tr>

                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
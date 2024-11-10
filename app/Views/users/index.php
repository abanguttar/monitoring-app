<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid ">

    <div class="container-fluid mt-2">
        <form action="" class="mt-5">

            <div class="col-12 col-lg-3 mt-2">
                <button type="submit" class="btn btn-sm btn-info text-white">Cari</button>
                <a href="/peserta" class="btn btn-sm btn-dark text-white">Reset</a>
            </div>
        </form>
        <a href="users/new" class="btn mt-3 btn-success">Create User</a>
        <button id="btn-edit" class="btn btn-primary mt-3">Edit User</button>
        <button id="btn-permissions" class="btn btn-info text-white mt-3">Permissions</button>
        <table class="table table-sm table-bordered table-hovered table-striped mt-2">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Tipe</th>
                    <th>User Update</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $number = ($page - 1) * 50;
                ?>
                <?php foreach ($datas as $key => $item): ?>
                    <tr class="table-row" data-id="users/<?= esc($item->id) ?>">
                        <td><?= ++$number ?></td>
                        <td><?= esc($item->username) ?></td>
                        <td><?= esc($item->email) ?></td>
                        <td><?= esc($item->active) ?></td>
                        <td><?= esc($item->tipe == 999 ? 'Superadmin' : 'Admin') ?></td>
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
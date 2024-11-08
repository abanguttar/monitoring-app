<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid ">
    <div class="container-fluid  mt-5">

        <div class="container-fluid">
            <form action="">
                <div class="row gap-2">
                    <div class="col-12 col-lg-3">
                        <input type="text" name="peserta_name" class="form-control" value="<?= $params['peserta_name'] ?? '' ?>" placeholder="Cari Nama atau Email">
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="pelatihans" class="form-select" id="pelatihans">
                            <option value="">--- Pilih Pelatihan ---</option>
                            <?php foreach ($pelatihans as $key => $pelatihan): ?>
                                <option value="<?= esc($pelatihan) ?>"><?= esc($pelatihan) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="master_class_id" class="form-select" id="master_class_id">
                            <option value="">--- Pilih Pelatihan dan Jadwal ---</option>
                            <?php foreach ($master_classes as $key => $master_class): ?>
                                <option value="<?= esc($master_class['id']) ?>"><?= esc($master_class['class_name']) . ' - ' . esc($master_class['jadwal'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <input type="text" name="voucher" class="form-control" value="<?= $params['voucher'] ?? '' ?>" placeholder="Cari Voucher">
                    </div>
                    <div class="col-12 col-lg-3">

                        <input type="text" name="invoice" class="form-control" value="<?= $params['invoice'] ?? '' ?>" placeholder="Cari Invoice">
                    </div>
                    <div class="col-12 col-lg-3">

                        <input type="text" name="redeem_code" class="form-control" value="<?= $params['redeem_code'] ?? '' ?>" placeholder="Cari Redeem Code">
                    </div>
                    <div class="col-12 col-lg-3">
                        <input type="text" name="payment_period" class="form-control" value="<?= $params['payment_period'] ?? '' ?>" placeholder="Cari Periode">
                    </div>
                    <div class="col-12 col-lg-3 mt-2">
                        <button type="submit" class="btn btn-sm btn-info text-white">Cari</button>
                        <a href="/peserta" class="btn btn-sm btn-dark text-white">Reset</a>
                    </div>
                </div>
            </form>
        </div>


        <div class="mt-5 d-flex gap-1 flex-wrap">
            <a href="/peserta/import-data/pembelian" class="btn-sm btn btn-success">Import Data Pembelian</a>
            <a href="/peserta/import-data/redemption" class="btn-sm btn btn-success">Import Data Redemption</a>
            <a href="/peserta/import-data/completion" class="btn-sm btn btn-success">Import Data Completion</a>
            <a href="/peserta/import-data/reconcile" class="btn-sm btn btn-danger">Import Data Reconcile Mitra</a>
        </div>
        <div class="mt-2 d-flex gap-1 flex-wrap">
            <a href="peserta/new" class="btn-sm btn btn-success">Create Peserta</a>
            <button id="btn-edit-peserta" class="btn-sm btn btn-primary">Edit Peserta</button>
            <button id="btn-add-pelatihan" class="btn-sm btn btn-success">Add New Pelatihan</button>
            <button id="btn-edit-pelatihan" class="btn-sm btn btn-primary">Edit Pelatihan</button>
            <button id="btn-add-progress" class="btn-sm btn btn-danger">Add Progress</button>
            <button id="btn-update-payment" class="btn-sm btn btn-info text-white">Update Pembayaran</button>
            <button id="btn-update-mitra" class="btn-sm btn btn-info text-white">Update Mitra</button>
        </div>
        <div class="table-responsive">
            <table class="table table-sm  table-bordered table-hovered table-striped mt-2">
                <thead class="table-dark">
                    <tr>
                        <th class="text-nowrap">No</th>
                        <th class="text-nowrap">Nama Peserta</th>
                        <th class="text-nowrap">Email</th>
                        <th class="text-nowrap">Nama Mitra</th>
                        <th class="text-nowrap">Phone</th>
                        <th class="text-nowrap">Nama Pelatihan</th>
                        <th class="text-nowrap">Jadwal</th>
                        <th class="text-nowrap">Jam</th>
                        <th class="text-nowrap">Jenis</th>
                        <th class="text-nowrap">Daring/Luring</th>
                        <th class="text-nowrap">Harga Kelas</th>
                        <th class="text-nowrap">Voucher</th>
                        <th class="text-nowrap">Invoice</th>
                        <th class="text-nowrap">Redeem Code</th>
                        <th class="text-nowrap">100% Pelatihan</th>
                        <th class="text-nowrap">Pembayaran</th>
                        <th class="text-nowrap">Periode</th>
                        <th class="text-nowrap">User Update</th>
                        <th class="text-nowrap">Updated At</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $number = ($page - 1) * 50;
                    ?>
                    <?php foreach ($datas as $key => $item): ?>
                        <tr class="table-row" data-id="peserta/<?= esc($item->id) ?>" data-peserta_id="peserta/<?= esc($item->peserta_id) ?>" data-master_class_id="<?= esc($item->master_class_id) ?>">
                            <td class="text-nowrap"><?= ++$number ?></td>
                            <td class="text-nowrap"><?= esc($item->peserta_name) ?></td>
                            <td class="text-nowrap"><?= esc($item->email) ?></td>
                            <td class="text-nowrap"><?= esc($item->mitra_name) ?></td>
                            <td class="text-nowrap"><?= esc($item->phone) ?></td>
                            <td class="text-nowrap"><?= esc($item->class_name) ?></td>
                            <td class="text-nowrap"><?= esc($item->jadwal) ?></td>
                            <td class="text-nowrap"><?= esc($item->jam) ?></td>
                            <td class="text-nowrap"><?= esc($item->is_prakerja) === '0' ? 'Umum' : 'Prakerja' ?></td>
                            <td class="text-nowrap"><?= esc($item->tipe) ?></td>
                            <td class="text-nowrap"><?= esc(number_format($item->price)) ?></td>
                            <td class="text-nowrap"><?= esc($item->voucher) ?></td>
                            <td class="text-nowrap"><?= esc($item->invoice) ?></td>
                            <td class="text-nowrap"><?= esc($item->redeem_code) ?></td>
                            <td class="text-nowrap"><?= esc($item->is_finished)   ?></td>
                            <td class="text-nowrap"><?= esc($item->is_paymented) === '0' ? 'Belum' : 'Ya' ?></td>
                            <td class="text-nowrap"><?= esc($item->payment_period) ?></td>
                            <td class="text-nowrap"><?= esc($item->username) ?></td>
                            <td class="text-nowrap"><?= esc($item->updated_at) ?></td>
                        </tr>

                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="container-fluid pb-5 mb-5" style="margin-bottom: 10rem!important;">
            <?= $pager->links() ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        const pelatihans = <?php echo json_encode($params['pelatihans']) ?? '' ?>;
        const master_class_id = <?php echo json_encode($params['master_class_id']) ?? '' ?>;
        $('#pelatihans').select2().val(pelatihans).trigger('change');
        $('#master_class_id').select2().val(master_class_id).trigger('change');
    })
</script>
<?= $this->endSection() ?>
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
            <th class="text-nowrap">Voucher</th>
            <th class="text-nowrap">Invoice</th>
            <th class="text-nowrap">Redeem Code</th>
            <th class="text-nowrap">100% Pelatihan</th>
            <th class="text-nowrap">Pembayaran</th>
            <th class="text-nowrap">Periode</th>
            <th class="text-nowrap">Message Error</th>
    </thead>
    <tbody id="table-body">
        <?php foreach ($messages as $key => $item): ?>
            <tr class="table-row">
                <td class="text-nowrap"><?= ++$key ?></td>
                <td class="text-nowrap"><?= esc($item->peserta_name) ?></td>
                <td class="text-nowrap"><?= esc($item->email) ?></td>
                <td class="text-nowrap"><?= esc($item->mitra_name) ?></td>
                <td class="text-nowrap"><?= esc($item->phone) ?></td>
                <td class="text-nowrap"><?= esc($item->class_name) ?></td>
                <td class="text-nowrap"><?= esc($item->jadwal) ?></td>
                <td class="text-nowrap"><?= esc($item->voucher) ?></td>
                <td class="text-nowrap"><?= esc($item->invoice) ?></td>
                <td class="text-nowrap"><?= esc($item->redeem_code) ?></td>
                <td class="text-nowrap"><?= esc($item->is_finished)   ?></td>
                <td class="text-nowrap"><?= esc($item->is_paymented) === null ? null : 'Ya' ?></td>
                <td class="text-nowrap"><?= esc($item->payment_period) ?></td>
                <td class="text-nowrap"><?= esc($item->message) ?></td>
            </tr>

        <?php endforeach ?>
    </tbody>
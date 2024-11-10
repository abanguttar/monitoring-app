<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid mt-5 d-flex justify-content-center align-items-center flex-column" style="margin-bottom: 15rem;">
    <section class="col-11 col-md-9 mb-5 ">
        <h4 class="text-center">Grafik Pembelian dan Penyelesaian Kelas</h4>
        <div class="row justify-content-center gap-2">
            <div class="col-12 col-lg-9">
                <select name="pelatihans" class="form-select pelatihan" data-id="pembelian-penyelesaian">
                    <option value="">--- Pilih Pelatihan ---</option>
                    <?php foreach ($pelatihans as $key => $pelatihan): ?>
                        <option value="<?= esc($pelatihan) ?>"><?= esc($pelatihan) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-lg-9">
                <select name="master_class_id" class="form-select master_class" data-id="pembelian-penyelesaian">
                    <option value="">--- Pilih Pelatihan dan Jadwal ---</option>
                    <?php foreach ($master_classes as $key => $master_class): ?>
                        <option value="<?= esc($master_class['id']) ?>"><?= esc($master_class['class_name']) . ' - ' . esc($master_class['jadwal'])  ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-lg-9">
                <button class="btn btn-sm btn-info search" data-id="pembelian-penyelesaian">Cari</button>
                <button class="btn btn-sm btn-dark reset" data-id="pembelian-penyelesaian">Reset</button>
            </div>
        </div>

        <div id="container-pembelian-penyelesaian" class="container mt-5 border w-75 d-flex flex-column align-items-center">
            <button type="button" class="btn btn-danger mt-5" id="show-pembelian-penyelesaian">Tampilkan Data</button>
            <canvas id="pembelian-penyelesaian"></canvas>
        </div>
    </section>


    <section class="col-11 col-md-9 mt-5 mb-5">
        <h4 class="text-center">Grafik Penjualan Kelas Mitra dan Non Mitra (Organik)</h4>
        <div class="row justify-content-center gap-2">
            <div class="col-12 col-lg-9">
                <select name="pelatihans" class="form-select pelatihan" data-id="penjualan-kelas">
                    <option value="">--- Pilih Pelatihan ---</option>
                    <?php foreach ($pelatihans as $key => $pelatihan): ?>
                        <option value="<?= esc($pelatihan) ?>"><?= esc($pelatihan) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-lg-9">
                <select name="master_class_id" class="form-select master_class" data-id="penjualan-kelas">
                    <option value="">--- Pilih Pelatihan dan Jadwal ---</option>
                    <?php foreach ($master_classes as $key => $master_class): ?>
                        <option value="<?= esc($master_class['id']) ?>"><?= esc($master_class['class_name']) . ' - ' . esc($master_class['jadwal'])  ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-lg-9">
                <div class="input-group ">
                    <input type="text" class="form-control border " id="yearPicker" readonly>
                    <button class="btn btn-outline-secondary" type="button" id="togglePicker">Pilih Tahun!</button>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                <button class="btn btn-sm btn-info search" data-id="penjualan-kelas">Cari</button>
                <button class="btn btn-sm btn-dark reset" data-id="penjualan-kelas">Reset</button>
            </div>
        </div>

        <div id="container-penjualan-kelas" class="container mt-5 border w-75 d-flex flex-column align-items-center">
            <canvas id="penjualan-kelas"></canvas>
            <p class="text-center" id="p-penjualan-kelas">Cari data lebih dulu</p>
        </div>
    </section>
    <section class="col-11 col-md-9 mt-5 ">
        <h4 class="text-center">Grafik Mitra</h4>
        <div class="row justify-content-center gap-2">
            <div class="col-12 col-lg-9">
                <select name="pelatihans" class="form-select pelatihan" data-id="penjualan-mitra">
                    <option value="">--- Pilih Pelatihan ---</option>
                    <?php foreach ($pelatihans as $key => $pelatihan): ?>
                        <option value="<?= esc($pelatihan) ?>"><?= esc($pelatihan) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-lg-9">
                <select name="master_class_id" class="form-select master_class" data-id="penjualan-mitra">
                    <option value="">--- Pilih Pelatihan dan Jadwal ---</option>
                    <?php foreach ($master_classes as $key => $master_class): ?>
                        <option value="<?= esc($master_class['id']) ?>"><?= esc($master_class['class_name']) . ' - ' . esc($master_class['jadwal'])  ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-lg-9">
                <select name="payment_period" id="payment_period" class="form-select master_class payment_period" data-id="penjualan-mitra">
                    <option value="">--- Pilih Periode ---</option>
                    <?php foreach ($periodes as $key => $periode): ?>
                        <option value="<?= esc($periode->payment_period) ?>"><?= esc($periode->payment_period)  ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-12 col-lg-9">
                <button class="btn btn-sm btn-info search" data-id="penjualan-mitra">Cari</button>
                <button class="btn btn-sm btn-dark reset" data-id="penjualan-mitra">Reset</button>
            </div>
        </div>

        <div id="container-penjualan-mitra" class="container mt-5 border w-75 d-flex flex-column align-items-center">
            <canvas id="penjualan-mitra"></canvas>
            <p class="text-center" id="p-penjualan-mitra">Cari data lebih dulu</p>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Date Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>


<script>
    $(document).ready(function() {
        $('#yearPicker').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });
        $('#togglePicker').on('click', function() {
            $('#yearPicker').datepicker('show');
        });
        $('.pelatihan').select2()
        $('.master_class').select2()
        const grafik1 = document.getElementById('pembelian-penyelesaian');
        const grafik2 = document.getElementById('penjualan-kelas');
        const grafik3 = document.getElementById('penjualan-mitra');

        const showGrafik1 = (data) => {
            new Chart(grafik1, {
                type: 'doughnut',
                data: {
                    labels: data.title,
                    datasets: data.datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        const showGrafik2 = (data) => {
            new Chart(grafik2, {
                type: 'bar',
                data: {
                    labels: data.title,
                    datasets: data.datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        const showGrafik3 = (data) => {
            new Chart(grafik3, {
                type: 'bar',
                data: {
                    labels: data.title,
                    datasets: data.datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Remove chart
        const removeChart = (chart) => {
            $(`#show-${chart}`).addClass('d-none');
            let chartStatus = Chart.getChart(chart); // <canvas> id
            if (chartStatus != undefined) {
                chartStatus.destroy();
            }
        }



        const fetchDataPembelianPenyelesaian = (params) => {
            return fetch(`grafik-transaksi/pembelian-penyelesaian?${params}`, {
                method: 'GET'
            }).then(res => {
                return res.json()
            }).then(d => {
                return d
            })
        }
        const fetchDataPenjualanKelas = (params) => {
            return fetch(`grafik-transaksi/penjualan-kelas?${params}`, {
                method: 'GET'
            }).then(res => {
                return res.json()
            }).then(d => {
                return d
            })
        }
        const fetchDataPenjualanMitra = (params) => {
            return fetch(`grafik-transaksi/penjualan-mitra?${params}`, {
                method: 'GET'
            }).then(res => {
                return res.json()
            }).then(d => {
                return d
            })
        }

        fetchDataPenjualanMitra('').then((d) => {
            showGrafik3(d)
        })

        const getPelatihanMasterClass = (id) => {

            const pelatihan = $(`.pelatihan[data-id="${id}"]`).val()
            const master_class_id = $(`.master_class[data-id="${id}"]`).val()


            if (id !== 'penjualan-mitra') {

                if (pelatihan === '' && master_class_id === '') {
                    return Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Mohon pilih pencarian dengan benar!",
                    });
                } else if (pelatihan !== '' && master_class_id !== '') {
                    return Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Mohon pilih salah satu antara pelatihan atau pelatihan dan jadwal!",
                    });
                }
            }


            return {
                pelatihan: pelatihan,
                master_class_id: master_class_id,
            }
        }


        const resetPelatihanMasterClass = (id) => {
            $(`.pelatihan[data-id="${id}"]`).val('').trigger('change')
            $(`.master_class[data-id="${id}"]`).val('').trigger('change')
            removeChart(id);
        }



        $(document).on('click', '#show-pembelian-penyelesaian', function() {
            removeChart("pembelian-penyelesaian");
            fetchDataPembelianPenyelesaian('').then((d) => {
                showGrafik1(d);
            });
        })
        $(document).on('click', '#show-penjualan-kelas', function() {
            removeChart("penjualan-kelas");
            fetchDataPenjualanKelas('').then((d) => {
                showGrafik2(d);
            });
        })



        $(document).on('click', '.search', function() {
            const id = $(this).data('id');
            console.log({
                id
            });
            const input = getPelatihanMasterClass(id);

            if (id !== 'penjualan-mitra') {
                if (input.pelatihan === '' && input.master_class_id === '') {
                    return false
                } else if (input.pelatihan !== '' && input.master_class_id !== '') {
                    return false;
                }
            }

            const params = `pelatihan=${input.pelatihan}&master_class_id=${input.master_class_id}`
            removeChart(id);
            if (id === 'pembelian-penyelesaian') {
                fetchDataPembelianPenyelesaian(params).then((d) => {
                    showGrafik1(d);
                });

            } else if (id === 'penjualan-kelas') {
                const yearPeriode = $('#yearPicker').val()

                if (yearPeriode === '') {
                    return Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Mohon pilih periode!",
                    });
                }
                $(`#p-${id}`).addClass('d-none')
                let p = params + `&periode=${yearPeriode}`;
                fetchDataPenjualanKelas(p).then((d) => {
                    showGrafik2(d);
                });
            } else if (id === 'penjualan-mitra') {
                const yearPeriode = $('#payment_period').val()

                if (yearPeriode === '') {
                    return Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Mohon pilih periode!",
                    });
                }
                let p = params + `&periode=${yearPeriode}`;
                console.log(p);
                fetchDataPenjualanMitra(p).then((d) => {
                    showGrafik3(d);
                });
            }


        })

        $(document).on('click', '.reset', function() {
            const id = $(this).data('id');

            resetPelatihanMasterClass(id)
        })


    })
</script>
<?= $this->endSection() ?>
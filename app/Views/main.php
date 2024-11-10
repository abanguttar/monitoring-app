<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring App | <?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<style>
    .input-group .select2-container--default .select2-selection--single {
        border-radius: 0;
        height: 100%;
        padding: 4px;
    }

    .input-group .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-top: 0;
        padding-bottom: 0;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 8px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Width of the scrollbar */
    .table-responsive::-webkit-scrollbar {
        width: 6px;
        /* Adjust width here */
        height: 6px;
        /* For horizontal scrollbar, if needed */
    }

    /* Track of the scrollbar */
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Light background color */
        border-radius: 10px;
    }

    /* Scrollbar thumb */
    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        /* Darker color for the thumb */
        border-radius: 10px;
    }

    /* Scrollbar thumb on hover */
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
        /* Darker shade when hovering */
    }
</style>

<body>
    <div class="container-fluid">
        <nav>
            <?= $this->include('sidebar') ?>
        </nav>

        <h2 class="text-center"><?= esc($title) ?></h2>
        <?= $this->renderSection('content') ?>
    </div>
    <?= $this->include('footer') ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?= $this->renderSection('script') ?>
    <script>
        let id = "";
        $(document).on("click", ".table-row", function() {
            id = $(this).data("id");
            $('.table-row').removeClass('table-info')
            $(this).toggleClass('table-info')
        });
        $(document).on('click', '#btn-edit', function() {
            if (id === '') {
                alert("Mohon pilih data dengan benar!");
                return
            }
            window.location.href = `${id}/edit`;
        })
        $(document).on('click', '#btn-permissions', function() {
            if (id === '') {
                alert("Mohon pilih data dengan benar!");
                return
            }
            window.location.href = `${id}/permissions`;
        })
        $(document).on('click', '#btn-add-pelatihan', function() {
            const peserta_id = $('.table-row.table-info').data('peserta_id');
            if (peserta_id === undefined) {
                alert("Mohon pilih data dengan benar!");
                return
            }
            window.location.href = `${peserta_id}/add-pelatihan`;
        })
        $(document).on('click', '#btn-edit-peserta', function() {
            const peserta_id = $('.table-row.table-info').data('peserta_id');
            if (peserta_id === undefined) {
                alert("Mohon pilih data dengan benar!");
                return
            }
            window.location.href = `${peserta_id}/edit`;
        })
        $(document).on('click', '#btn-update-mitra', function() {
            const peserta_id = $('.table-row.table-info').data('peserta_id');
            const mc_id = $('.table-row.table-info').data('master_class_id');
            if (peserta_id === undefined) {
                alert("Mohon pilih data dengan benar!");
                return
            }
            window.location.href = `${peserta_id}/update-mitra/${mc_id}`;
        })
        $(document).on('click', '#btn-edit-pelatihan', function() {
            const peserta_id = $('.table-row.table-info').data('peserta_id');
            const mc_id = $('.table-row.table-info').data('master_class_id');
            if (peserta_id === undefined) {
                alert("Mohon pilih data dengan benar!");
                return
            }
            window.location.href = `${peserta_id}/edit-pelatihan/${mc_id}`;
        })
        $(document).on('click', '#btn-add-progress', function() {
            if (id === '') {
                alert("Mohon pilih data dengan benar!");
                return
            }
            window.location.href = `${id}/add-progress`;
        })
        $(document).on('click', '#btn-update-payment', function() {
            if (id === '') {
                alert("Mohon pilih data dengan benar!");
                return
            }
            window.location.href = `${id}/update-payment`;
        })
    </script>
</body>

</html>
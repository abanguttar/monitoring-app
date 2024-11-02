<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chiranjivi | <?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

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
    <?= $this->renderSection('table-click') ?>
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
    </script>
</body>

</html>
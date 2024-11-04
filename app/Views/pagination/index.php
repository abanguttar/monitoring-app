<?php if ($pager): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php if ($pager->hasPreviousPage()): ?>
                <li class="page-item">
                    <a href="<?= $pager->getPreviousPage() ?>" class="page-link" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif ?>


            <?php foreach ($pager->links() as $link): ?>
                <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                    <a href="<?= $link['uri'] ?>" class="page-link"><?= $link['title'] ?></a>
                </li>
            <?php endforeach ?>

            <?php if ($pager->hasNextPage()): ?>
                <li class="page-item">
                    <a href="<?= $pager->getNextPage() ?>" class="page-link" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif ?>
        </ul>
    </nav>
<?php endif ?>
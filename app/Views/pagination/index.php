<?php if ($pagination->total > 0): ?>
    <?php if ($pagination->lastPage > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?= $pagination->currentPage === 1 ? 'disabled' : '' ?>">
                    <a href="<?= $pagination->previousUrl ?>" class="page-link " aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <li class="page-item <?= $pagination->currentPage === $pagination->lastPage ? 'disabled' : '' ?>">
                    <a href="<?= $pagination->nextUrl ?>" class="page-link" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif ?>
    <p>Page <?= $pagination->currentPage ?> dari <?= $pagination->lastPage ?> | Menampilkan <span class="fw-bold"><?= $pagination->from ?></span> dari total <span class="fw-bold"><?= $pagination->total ?></span> </p>

<?php endif ?>
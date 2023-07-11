<?php

use App\Router;
use App\Support\View;
use App\Models\Task;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="<?= Router::generateUrl('/') ?>"
           class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                <use xlink:href="#bootstrap"></use>
            </svg>
        </a>
        <div class="col-md-3 text-end">
            <?php if (!$is_auth) : ?>
                <a href="<?= Router::generateUrl('/login') ?>" class="btn btn-outline-primary me-2" tabindex="-1"
                   role="button">Login</a>
            <?php else: ?>
                <a href="<?= Router::generateUrl('/logout') ?>" class="btn btn-primary" tabindex="-1" role="button">Logout</a>
            <?php endif; ?>
        </div>
    </header>
</div>

<div class="text-center d-grid gap-2 col-10 m-auto mb-5">
    <div class="row col-md-5 shadow m-auto">
        <form action="<?= Router::generateUrl('/add') ?>" method="post">
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="" value=""
                           required="" maxlength="50">
                </div>
                <div class="col-sm-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="" value="" required=""
                           maxlength="255">
                </div>
                <div class="col-12">
                    <label for="task" class="form-label">Task</label>
                    <input type="text" class="form-control" id="task" name="task" required="" maxlength="255">
                </div>
                <?php if ($success) : ?>
                    <div class="mb-3 Success">
                        Success
                    </div>
                <?php endif; ?>
                <div class="col-12">
                    <input type="submit" class="btn btn-primary" value="Add">
                </div>
                <div class="col-12">
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (!empty($tasks)) : ?>
    <div class="container text-center d-grid gap-2 col-10 m-auto mb-5">
        <div class="row col-md-5 shadow m-auto">
            <form action="<?= Router::generateUrl('/') ?>" method="get">
                <input hidden class="form-control" id="page" name="page" value="<?= View::render($page) ?>">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="order" class="form-label">Sort column</label>
                        <select name="order" class="form-select" aria-label="order">

                            <?php foreach (Task::ALLOWED_ORDER as $option): ?>
                                <option value="<?= View::render($option) ?>"
                                        <?php if ($order === $option) : ?>selected<?php endif; ?>
                                ><?= View::render(ucfirst($option)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="sort" class="form-label">Sort order</label>
                        <select name="sort" class="form-select" aria-label="sort">
                            <?php foreach (Task::ALLOWED_SORT as $option): ?>
                                <option value="<?= View::render($option) ?>"
                                        <?php if ($sort === $option) : ?>selected<?php endif; ?>
                                >
                                    <?= View::render(ucfirst($option)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary" value="Sort">
                    </div>
                    <div class="col-12">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<?php if (!empty($tasks)): ?>

    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                <?php foreach ($tasks as $task): ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <p class="card-text"><b><?= View::render($task['username']) ?></b></p>
                                <p class="card-text"><b><?= View::render($task['email']) ?></b></p>
                                <p class="card-text"><?= View::render($task['task']) ?></p>
                                <div class="form-check text-start my-3">
                                    <input class="form-check-input" type="checkbox" value="" id="status" disabled
                                        <?php if ($task['status']): ?> checked <?php endif; ?>
                                    >
                                    <label class="form-check-label" for="status">
                                        Done
                                    </label>
                                </div>
                                <div class="form-check text-start my-3">
                                    <input class="form-check-input" type="checkbox" value="" id="changed" disabled
                                        <?php if ($task['changed']): ?> checked <?php endif; ?>
                                    >
                                    <label class="form-check-label" for="status">
                                        Changed
                                    </label>
                                </div>
                                <?php if ($is_admin): ?>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <form action="<?= Router::generateUrl('/edit') ?>" method="get">
                                                <input hidden name="id" value="<?= View::render($task['id']) ?>">
                                                <input type="submit" class="btn btn-sm btn-outline-secondary"
                                                       value="Update">
                                            </form>
                                            <form action="<?= Router::generateUrl('/delete') ?>" method="post">
                                                <input hidden name="id" value="<?= View::render($task['id']) ?>">
                                                <input type="submit" class="btn btn-sm btn-outline-secondary"
                                                       value="Delete">
                                            </form>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


    <nav aria-label="..." class="">
        <ul class="pagination pagination-lg justify-content-center">
            <?php for ($i = 1; $i <= $maxPage; $i++): ?>
                <?php if ($i == $page): ?>
                    <li class="page-item active" aria-current="page">
                        <span class="page-link"><?= View::render($i) ?></span>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link"
                           href="<?= Router::generateUrl('/', ['page' => $i, 'order' => $order, 'sort' => $sort]) ?>">
                            <?= View::render($i) ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
        </ul>
    </nav>
    </div>
<?php endif; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>
</html>
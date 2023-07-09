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
<?php if (!$is_auth) : ?>
    <div class="container d-grid gap-2 col-4 m-auto mb-5 shadow p-5">
        <div class="d-grid gap-2 col-5 mx-auto">
            <a href="<?= Router::generateUrl('/login') ?>" class="btn btn-primary" tabindex="-1" role="button">Sign
                In</a>
        </div>
    </div>
<?php else: ?>
    <div class="container d-grid gap-2 col-4 m-auto mb-5 shadow p-5">
        <div class="d-grid gap-2 col-5 mx-auto">
            <a href="<?= Router::generateUrl('/logout') ?>" class="btn btn-primary" tabindex="-1"
               role="button">Logout</a>
        </div>
    </div>
<?php endif; ?>

<div class="text-center d-grid gap-2 col-10 m-auto mb-5">
    <div class="row col-md-5 shadow m-auto">
        <h3>TODO</h3>
        <form action="<?= Router::generateUrl('/add') ?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required maxlength="255">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required maxlength="255">
            </div>
            <div class="mb-3">
                <label for="task" class="form-label">Task</label>
                <input type="text" class="form-control" id="task" name="task" required maxlength="255">
            </div>
            <?php if ($success) : ?>
                <div class="mb-3 Success">
                    Success
                </div>
            <?php endif; ?>
            <input type="submit" class="btn btn-primary" value="Submit">
        </form>
    </div>
</div>

<?php if (!empty($tasks)) : ?>
    <div class="container text-center d-grid gap-2 col-10 m-auto mb-5">
        <div class="row col-md-5 shadow m-auto">
            <h3>Sort</h3>
            <form action="<?= Router::generateUrl('/') ?>" method="get">
                <input hidden class="form-control" id="page" name="page" value="<?= View::render($page) ?>">
                <div class="mb-3">
                    <label for="order" class="form-label">Sort column</label>
                    <select name="order" class="form-select" aria-label="order">

                        <?php foreach (Task::ALLOWED_ORDER as $option): ?>
                            <option value="<?= View::render($option) ?>"
                                    <?php if ($order === $option) : ?>selected<?php endif; ?>
                            ><?= View::render($option) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sort" class="form-label">Sort order</label>
                    <select name="sort" class="form-select" aria-label="sort">
                        <?php foreach (Task::ALLOWED_SORT as $option): ?>
                            <option value="<?= View::render($option) ?>"
                                    <?php if ($sort === $option) : ?>selected<?php endif; ?>
                            >
                                <?= View::render($option) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
            </form>
        </div>
    </div>

<?php endif; ?>

<?php if (!empty($tasks)): ?>
    <div class="container  m-auto mb-5 shadow">
        <div class="row m-3 p-3">
            <div class="col-1 text-truncate">ID</div>
            <div class="col-2 text-truncate">Username</div>
            <div class="col-2 text-truncate">E-mail</div>
            <div class="col text-truncate">Task</div>
            <div class="col-1 form-check">
                Done
            </div>
            <div class="col-1 form-check">
                Changed
            </div>
            <?php if ($is_admin): ?>
                <div class="col-1"></div>
                <div class="col-1"></div>
            <?php endif; ?>
        </div>

        <?php foreach ($tasks as $task): ?>
            <div class="row m-3 p-3">
                <div class="col-1 text-truncate"><?= View::render($task['id']) ?></div>
                <div class="col-2 text-truncate"><?= View::render($task['username']) ?></div>
                <div class="col-2 text-truncate"><?= View::render($task['email']) ?></div>
                <div class="col text-truncate"><?= View::render($task['task']) ?></div>
                <div class="col-1 form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           value=""
                           id="status"
                           disabled
                        <?php if ($task['status']): ?> checked <?php endif; ?>
                    >
                </div>
                <div class="col-1 form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           value=""
                           id="status"
                           disabled
                        <?php if ($task['changed']): ?> checked <?php endif; ?>
                    >
                </div>
                <?php if ($is_admin): ?>
                    <div class="col-1">
                        <form action="<?= Router::generateUrl('/edit') ?>" method="get">
                            <input hidden name="id" value="<?= View::render($task['id']) ?>">
                            <input type="submit" class="btn btn-success" value="Update">
                        </form>
                    </div>
                    <div class="col-1">
                        <form action="<?= Router::generateUrl('/delete') ?>" method="post">
                            <input hidden name="id" value="<?= View::render($task['id']) ?>">
                            <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
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
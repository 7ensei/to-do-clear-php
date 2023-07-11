<?php

use App\Router;

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

<div class="container text-center">
    <div class="row col-md-5 shadow m-auto">
        <h3>Edit</h3>
        <form action="<?= Router::generateUrl('/update') ?>" method="post">
            <input hidden name="id" value="<?= $task['id'] ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" disabled name="username"
                       value="<?= $task['username'] ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" disabled name="email" value="<?= $task['email'] ?>">
            </div>
            <div class="mb-3">
                <label for="task" class="form-label">Task</label>
                <input type="text" class="form-control" id="task" name="task" required value="<?= $task['task'] ?>">
            </div>
            <div class="mb-3 form-check">
                <input class="form-check-input"
                       type="checkbox"
                       name="status"
                       value="1"
                       id="flexCheckChecked"
                    <?php if ($task['status']): ?> checked <?php endif; ?>
                >
                <label class="form-check-label" for="flexCheckChecked">
                    Done
                </label>
            </div>
            <input type="submit" class="btn btn-primary" value="Submit">
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>
</html>
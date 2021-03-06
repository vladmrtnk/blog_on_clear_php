<?php require_once APP_ROOT . '/views/parts/blog-header.php'; ?>

<main class="container">
    <div class="d-flex justify-content-center">
        <form class="w-50 p-5 border rounded" method="POST" action="<?php echo URL_ROOT . '/sign-in' ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Email address</label>
                <input type="email" class="form-control <?php echo \App\Components\Flash::hasErrors() ? 'is-invalid' : ''?>" name="email" id="name" aria-describedby="emailHelp" value="<?php echo \App\Components\FormData::getOldData('email') ?? '' ?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control <?php echo \App\Components\Flash::hasErrors() ? 'is-invalid' : ''?>" name="password" id="password">
                <?php echo \App\Components\Flash::displayMessage(SIGN_IN_ERROR); ?>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<?php require_once APP_ROOT . '/views/parts/blog-footer.php' ?>

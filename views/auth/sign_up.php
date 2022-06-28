<?php require_once APP_ROOT . '/views/parts/blog-header.php'; ?>

<main class="container">
    <div class="d-flex justify-content-center">
        <form class="w-50 p-5 border rounded" method="POST" action="<?php echo URL_ROOT . '/sign-up' ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control <?php echo \App\Components\Flash::hasErrors(INVALID_NAME) ? 'is-invalid' : ''?>" name="name" id="name" aria-describedby="nameHelp" value="<?php echo \App\Components\FormData::getOldData('name') ?? '' ?>">
                <?php echo \App\Components\Flash::displayMessage(INVALID_NAME); ?>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control <?php echo \App\Components\Flash::hasErrors(INVALID_EMAIL) ? 'is-invalid' : ''?>" name="email" id="email" aria-describedby="emailHelp" value="<?php echo \App\Components\FormData::getOldData('email') ?? '' ?>">
                <?php echo \App\Components\Flash::displayMessage(INVALID_EMAIL); ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control <?php echo \App\Components\Flash::hasErrors(INVALID_PASSWORDS) ? 'is-invalid' : ''?>" name="password" id="password">
            </div>

            <div class="mb-3">
                <label for="second_password" class="form-label">Repeat Password</label>
                <input type="password" class="form-control <?php echo \App\Components\Flash::hasErrors(INVALID_PASSWORDS) ? 'is-invalid' : ''?>" name="second_password" id="second_password">
                <?php echo \App\Components\Flash::displayMessage(INVALID_PASSWORDS); ?>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<?php require_once APP_ROOT . '/views/parts/blog-footer.php' ?>

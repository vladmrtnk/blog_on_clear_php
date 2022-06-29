<?php require_once APP_ROOT . '/views/parts/blog-header.php'; ?>

<main class="container">
    <div class="d-flex justify-content-center">
        <form class="w-50 p-5 border rounded" method="POST" action="<?php echo URL_ROOT . '/dashboard/tags' ?>">
            <label for="title" class="form-label">Title</label>

            <div class="input-group mb-3">
                <span class="input-group-text" id="sharp">#</span>
                <input name="title" type="text" class="form-control <?php echo \App\Components\Flash::hasErrors(INVALID_TAG_TITLE) ? 'is-invalid' : ''?>" aria-describedby="sharp" id="title" value="<?php echo \App\Components\FormData::getOldData('title') ?? '' ?>" placeholder="example_tag" required>
                <?php echo \App\Components\Flash::displayMessage(INVALID_TAG_TITLE); ?>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<?php require_once APP_ROOT . '/views/parts/blog-footer.php' ?>

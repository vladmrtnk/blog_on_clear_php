<?php require_once APP_ROOT . '/views/parts/blog-header.php'; ?>

<main class="container">
    <div class="d-flex justify-content-center">
        <form class="w-75 p-5 border rounded" method="POST" enctype="multipart/form-data" action="<?php echo URL_ROOT . '/dashboard/posts' ?>">

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input name="title" type="text" class="form-control <?php echo \App\Components\Flash::hasErrors(INVALID_POST_TITLE) ? 'is-invalid' : ''?>" id="title" value="<?php echo \App\Components\FormData::getOldData('title') ?? '' ?>" required>
                <?php echo \App\Components\Flash::displayMessage(INVALID_POST_TITLE); ?>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" class="form-control <?php echo \App\Components\Flash::hasErrors(INVALID_POST_CONTENT) ? 'is-invalid' : ''?>" id="content" rows="5" required><?php echo \App\Components\FormData::getOldData('content') ?? '' ?></textarea>
                <?php echo \App\Components\Flash::displayMessage(INVALID_POST_CONTENT); ?>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input name="image" class="form-control <?php echo \App\Components\Flash::hasErrors(INVALID_POST_IMAGE) ? 'is-invalid' : ''?>" type="file" id="image" accept="image/png, image/jpeg, image/img, image/jpg">
                <?php echo \App\Components\Flash::displayMessage(INVALID_POST_IMAGE); ?>
            </div>

            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                <div class="" id="tags">
                    <?php $oldTags = \App\Components\FormData::getOldData('tags');?>
                    <?php /** @var array $tags */ ?>
                    <?php foreach ($tags as $tag): ?>
                    <div class="form-check form-check-inline">
                        <input name="tags[]" class="form-check-input" type="checkbox" id="<?php echo $tag['id'] ?>" value="<?php echo $tag['id'] ?>" <?php echo in_array($tag['id'], (array)$oldTags) ? 'checked' : ''?>>
                        <label class="form-check-label" for="<?php echo $tag['id'] ?>"><?php echo '#' . $tag['title'] ?></label>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<?php require_once APP_ROOT . '/views/parts/blog-footer.php' ?>

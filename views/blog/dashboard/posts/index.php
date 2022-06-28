<?php require_once APP_ROOT . '/views/parts/blog-header.php' ?>

<main class="container">
    <div class="row mb-2">
        <h3>My posts:</h3>
        <?php if(!empty($posts)): ?>
        <?php /** @var array $posts */ ?>
        <?php foreach ($posts as $post): ?>
        <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <div class="d-inline-block mb-2 text-primary">
                        <?php
                        if (isset($post['tags'])):
                        foreach ($post['tags'] as $tag) {
                            echo '#' . $tag['title'] . ' ';
                        }
                        endif;
                        ?>
                    </div>
                    <h3 class="mb-0"><?php echo $post['title']; ?></h3>
                    <div class="mb-1 text-muted"><?php echo date_create($post['created_at'])->format('M d - G:i'); ?></div>
                    <p class="card-text mb-auto"><?php echo mb_substr($post['content'], 0, 140) . ' ...'; ?></p>
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo URL_ROOT . '/posts/' . $post['id'] ?>" class="stretched-link">Continue reading</a>
                        <div>
                            <a href="#" class="btn btn-primary btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </div>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <?php if (is_null($post['image_path'])): ?>
                    <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Image</text></svg>
                    <?php else: ?>
                    <img src="<?php echo $post['image_path'] ?>" alt="image" width="200" height="250">
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; endif;?>
    </div>
</main>

<?php require_once APP_ROOT . '/views/parts/blog-footer.php' ?>

<?php require_once APP_ROOT . '/views/parts/blog-header.php' ?>

<main class="container">
    <div class="row mb-2">
        <?php /** @var \App\Models\Post $post */ ?>
        <div class="col-md-12">
            <img class="rounded float-end" width="500" src="<?php echo $post->image_path ?>" alt="image">
            <div class="display-3"><?php echo $post->title ?></div>
                <div class="text-primary">
                    <?php
                    if (isset($post->tags)):
                        foreach ($post->tags as $tag) {
                            echo '#' . $tag['title'] . ' ';
                        }
                    endif;
                    ?>
                </div>
                <div class="mb-1 text-muted"><?php echo date_create($post->created_at)->format('M d - G:i'); ?></div>
                <div class="lead"><?php echo $post->content; ?></div>
                <h4 class="mt-1 text-muted"><?php echo 'Author: ' . $post->author['name']; ?></h4>
        </div>
    </div>
</main>

<?php require_once APP_ROOT . '/views/parts/blog-footer.php' ?>

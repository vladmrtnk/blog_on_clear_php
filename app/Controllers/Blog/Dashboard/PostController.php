<?php

namespace App\Controllers\Blog\Dashboard;

use App\Components\Flash;
use App\Components\FormData;
use App\Controllers\BaseController;
use App\Models\Post;
use App\Models\Tag;
use App\Requests\PostStoreRequest;

class PostController extends BaseController
{
    /**
     * @return void
     */
    public function index()
    {
        $posts = Post::getOwn();

        require_once APP_ROOT . '/views/blog/dashboard/posts/index.php';
    }

    /**
     * @return void
     */
    public function create()
    {
        $tags = Tag::getAll();

        require_once APP_ROOT . '/views/blog/dashboard/posts/create.php';
    }

    /**
     * @return void
     */
    public function store(): void
    {
        $data = $_POST;
        $data['image'] = $_FILES['image'];
        $validated = PostStoreRequest::validated($data);

        if (array_search(false, $validated)) {
            if (!$validated['title']) {
                Flash::createMessage(INVALID_POST_TITLE, 'Enter the correct title. Min: 4 symbols Max: 50 symbols',
                    FLASH_ERROR);
            }

            if (!$validated['content']) {
                Flash::createMessage(INVALID_POST_CONTENT,
                    'Enter the correct content. Min: 50 symbols Max: 10000 symbols', FLASH_ERROR);
            }

            if (!$validated['image']) {
                Flash::createMessage(INVALID_POST_IMAGE, 'Enter the correct image. Formats: .img .png .jpg .jpeg',
                    FLASH_ERROR);
            }
            FormData::setOldData($_POST);
            header('Location: /dashboard/posts/create');
            exit;
        }

        if ($_FILES["image"]["error"] == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["image"]["tmp_name"];
            $type = explode('.', $_FILES['image']['name']);
            $name = rand(1000000, 9999999) . '.' . end($type);
            $saveImage = move_uploaded_file($tmp_name, APP_ROOT . "/public/images/posts/$name");
            if ($saveImage) {
                $validated['image_path'] = "/images/posts/$name";
            }
        }

        $post = new Post($validated);
        if ($post->save()) {
            header('Location: /dashboard/posts');
        }
    }

    /**
     * @return void
     */
    public function destroy(int $id)
    {
        $post = Post::find($id);

        if ($post->destroy()){
            header('Location: /dashboard/posts');
        }
    }
}
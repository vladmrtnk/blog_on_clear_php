<?php

namespace App\Controllers\Blog\Dashboard;

use App\Components\Flash;
use App\Components\FormData;
use App\Controllers\BaseController;
use App\Models\Tag;
use App\Requests\TagStoreRequest;

class TagController extends BaseController
{
    /**
     * @return void
     */
    public function create()
    {
        require_once APP_ROOT . '/views/blog/dashboard/tags/create.php';
    }

    /**
     * @return void
     */
    public function store()
    {
        $validated = TagStoreRequest::validated($_POST);

        if (array_search(false, $validated)) {
            if (!$validated['title']) {
                Flash::createMessage(INVALID_TAG_TITLE,
                    'Enter the correct title. Min: 4 symbols Max: 15 symbols. Or this tag already exists',
                    FLASH_ERROR);
            }

            FormData::setOldData($_POST);
            header('Location: /dashboard/tags/create');
            exit;
        }

        $tag = new Tag($validated['title']);
        if ($tag->save()) {
            header('Location: /dashboard/posts');
        }
    }
}
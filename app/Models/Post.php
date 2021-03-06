<?php

namespace App\Models;

use App\DB;
use DateTime;
use PDO;

class Post
{
    public $id;
    public $user_id;
    public $title;
    public $content;
    public $image_path;
    public $created_at;
    public $updated_at;
    public $tags;
    public $author;

    /**
     * @param  string|array|null  $title
     * @param  string|null  $content
     * @param  string|null  $image_path
     * @param  array|null  $tags
     */
    public function __construct(
        string|array $title = null,
        string $content = null,
        string $image_path = null,
        array $tags = null
    ) {
        if (is_array($title)) {
            $this->title = $title['title'];
            $this->content = $title['content'];
            $this->image_path = $title['image_path'];
            $this->tags = $title['tags'];
        } else {
            $this->title = $title;
            $this->content = $content;
            $this->image_path = $image_path;
            $this->tags = $tags;
        }
    }

    /**
     * Find post by ID
     *
     * @param  int  $needle
     *
     * @return \App\Models\Post
     */
    public static function find($needle)
    {
        $db = DB::getConection();

        $result = $db->query("SELECT * from posts where id = $needle");
        $data = $result->fetch(PDO::FETCH_ASSOC);

        $post = new Post();
        $post->id = $data['id'];
        $post->user_id = $data['user_id'];
        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->image_path = $data['image_path'];
        $post->created_at = $data['created_at'];
        $post->updated_at = $data['updated_at'];
        $post->tags = self::getRelationTags([$needle => ['id' => $data['id']]])[$needle]['tags'];
        $post->author = self::getRelationUser([$needle => ['user_id' => $data['user_id']]])[$needle]['author'];

        return $post;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $db = DB::getConection();

        $user_id = $_SESSION[AUTHENTICATED_USER];
        $created_at = (new DateTime())->format(DATE_ATOM);

        $query = $db->query("INSERT INTO posts (user_id, title, content, image_path, created_at, updated_at) VALUES ('$user_id', '$this->title', '$this->content', '$this->image_path', '$created_at', '$created_at')");
        $lastPostId = $db->lastInsertId('posts');

        if ($query) {
            foreach ($this->tags as $tag) {
                $db->query("INSERT INTO posts_tags (post_id, tag_id) VALUES ($lastPostId, $tag)");
            }
        }

        return (bool) $query;
    }

    /**
     * @return bool
     */
    public function destroy()
    {
        $db = DB::getConection();

        $db->query("DELETE FROM posts_tags WHERE post_id = $this->id");
        unlink(APP_ROOT . '/public' . $this->image_path);
        $deleted = $db->query("DELETE FROM posts WHERE id = $this->id");

        return (bool) $deleted;
    }

    /**
     * Get all post authenticated user
     *
     * @return array|null
     */
    public static function getAll()
    {
        $db = DB::getConection();

        $queryPosts = $db->query("SELECT * FROM posts");
        $postsData = $queryPosts->fetchAll(PDO::FETCH_ASSOC);

        if (empty($postsData)) {
            return null;
        }

        $posts = [];
        foreach ($postsData as $post) {
            $posts[$post['id']] = $post;
        }

        $posts = self::getRelationUser($posts);
        $posts = self::getRelationTags($posts);

        return $posts;
    }

    /**
     * Get all post authenticated user
     *
     * @return array|null
     */
    public static function getOwn()
    {
        $db = DB::getConection();

        $queryPosts = $db->query("SELECT * FROM posts WHERE user_id = " . $_SESSION[AUTHENTICATED_USER]);
        $postsData = $queryPosts->fetchAll(PDO::FETCH_ASSOC);

        if (empty($postsData)) {
            return null;
        }

        $posts = [];
        foreach ($postsData as $post) {
            $posts[$post['id']] = $post;
        }

        $posts = self::getRelationTags($posts);

        return $posts;
    }

    /**
     * Get array with Tags relations
     * Every array index must be post_id
     *
     * @param  array  $posts
     *
     * @return array
     */
    private static function getRelationTags(array $posts): array
    {
        $db = DB::getConection();

        $postsIds = implode(',', array_column($posts, 'id'));

        $queryTagsIds = $db->query("SELECT * FROM posts_tags WHERE post_id IN ($postsIds)");
        $postsTags = $queryTagsIds->fetchAll(PDO::FETCH_ASSOC);
        $tagsIds = implode(',', array_column($postsTags, 'tag_id'));

        $queryTags = $db->query("SELECT * FROM tags WHERE id IN ($tagsIds)");
        $tagsData = $queryTags->fetchAll(PDO::FETCH_ASSOC);

        $tags = [];
        foreach ($tagsData as $tag) {
            $tags[$tag['id']] = $tag;
        }

        foreach ($postsTags as $item) {
            $posts[$item['post_id']]['tags'][] = $tags[$item['tag_id']];
        }

        return $posts;
    }

    /**
     * Get array with User (Author) relations
     * Every array index must be post_id
     *
     * @param  array  $posts
     *
     * @return array
     */
    private static function getRelationUser(array $posts): array
    {
        $db = DB::getConection();

        $userIds = implode(',', array_column($posts, 'user_id'));

        $queryUsers = $db->query("SELECT id, name FROM users WHERE id IN ($userIds)");
        $userData = $queryUsers->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($userData as $user) {
            $users[$user['id']] = $user;
        }

        foreach ($posts as &$post) {
            $post['author'] = $users[$post['user_id']];
        }

        return $posts;
    }
}
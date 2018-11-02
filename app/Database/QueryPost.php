<?php
namespace victorhugobatista\WpEruptor\Database;

use WP_Query;

class QueryPost
{
    private $postTypeName;
    private $postName;
    private $query;

    public function __construct($postTypeName, $postName)
    {
        $this->postTypeName = $postTypeName;
        $this->postName = $postName;
        $this->query = new WP_Query([
            'post_type' => $postTypeName,
            'name' => $postName,
            'posts_per_page' => 1,
        ]);
    }

    public function postExists()
    {
        return ! empty($this->query->posts);
    }

    public function getPost()
    {
        if (empty($this->query->posts)) {
            return false;
        }
        return $this->query->posts[0];
    }
}

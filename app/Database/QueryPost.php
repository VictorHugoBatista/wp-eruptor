<?php
namespace victorhugobatista\WpEruptor\Database;

use WP_Query;

/**
 * Responsible for get one post passing the post type
 * name and the post name on constructor.
 */
class QueryPost
{
    private $postTypeName;
    private $postName;

    /**
     * Query generated on constructor.
     *
     * @var WP_Query
     */
    private $query;

    /**
     * Do an WP_Query by one post with the post type
     * name and the post name pass to a property.
     * Get only published posts.
     *
     * @param string $postTypeName Post type name, showed on single page slugs.
     * @param string $postName Post name, showed on single page slugs.
     */
    public function __construct($postTypeName, $postName)
    {
        $this->postTypeName = $postTypeName;
        $this->postName = $postName;
        $this->query = new WP_Query([
            'post_type' => $postTypeName,
            'name' => $postName,
            'posts_per_page' => 1,
            'post_status' => 'publish',
        ]);
    }

    /**
     * Verify if the return of WP_Query is not empty.
     *
     * @return boolean
     */
    public function postExists()
    {
        return ! empty($this->query->posts);
    }

    /**
     * Return the queried post or false if not exists.
     *
     * @return boolean|WP_Post
     */
    public function getPost()
    {
        if (empty($this->query->posts)) {
            return false;
        }
        return $this->query->posts[0];
    }
}

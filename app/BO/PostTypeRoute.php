<?php
namespace victorhugobatista\WpEruptor\BO;

use Brain\Cortex\Route\RouteCollectionInterface;
use Brain\Cortex\Route\QueryRoute;
use victorhugobatista\WpEruptor\Database\QueryPost;
use victorhugobatista\WpEruptor\View\TemplateRenderer;
use WP_Post_Type;

/**
 * Responsible by post type route creation.
 * Have to be called on 'cortex.routes' filter.
 */
class PostTypeRoute
{
    /**
     * Post type to add childen routes.
     *
     * @var WP_Post_Type
     */
    private $postType;

    /**
     * Route object received on 'cortex.routes' action.
     *
     * @var RouteCollectionInterface
     */
    private $cortexRoutes;

    /**
     * Initialize route for a specific post type.
     *
     * @param WP_Post_Type $postType Post type to initialize route.
     * @param RouteCollectionInterface $routes Object of 'cortex.routes' filter.
     */
    public function __construct(WP_Post_Type $postType, RouteCollectionInterface $routes)
    {
        $this->postType = $postType;
        $this->cortexRoutes = $routes;
        $this->addRoute();
    }

    /**
     * Add route for one specifc post type passed through the constructor.
     * If the parent post is not published or not exists, send to 404 template.
     */
    private function addRoute()
    {
        if (! $this->postType->rewrite)  {
            return;
        }
        $postTypeSlug = $this->postType->rewrite['slug'];
        $this->cortexRoutes->addRoute(new QueryRoute(
            "{$postTypeSlug}/{postName}/{singleChildName}",
            function (array $matches) use ($postTypeSlug) {
                $queryPost = new QueryPost(
                    $this->postType->name,
                    $matches['postName']
                );
                if (! $queryPost->postExists()) {
                    new TemplateRenderer('404');
                }
                $postSingle = $queryPost->getPost();
                new TemplateRenderer(
                    $postTypeSlug,
                    $matches['singleChildName'],
                    $this->makeDataArray([
                        'post-id' => $postSingle->ID,
                    ])
                );
                die();
            }
        ));
    }
    
    private function makeDataArray($data)
    {
        return apply_filters('eruptor/data', $data);
    }
} 

<?php
namespace victorhugobatista\WpEruptor\BO;

use Brain\Cortex\Route\RouteCollectionInterface;
use Brain\Cortex\Route\QueryRoute;
use victorhugobatista\WpEruptor\Database\QueryPost;

class PostTypeRoute
{
    private $postType;
    private $cortexRoutes;

    public function __construct($postType, RouteCollectionInterface $routes)
    {
        $this->postType = $postType;
        $this->cortexRoutes = $routes;
        $this->addRoute();
    }

    private function addRoute()
    {
        if (! $this->postType->rewrite)  {
            return;
        }
        $this->cortexRoutes->addRoute(new QueryRoute(
            "{$this->postType->rewrite['slug']}/{postName}/{singleChildName}",
            function (array $matches) {
                $queryPost = new QueryPost(
                    $this->postType->name,
                    $matches['postName']
                );
                if (! $queryPost->postExists()) {
                    $this->goTo404();
                }
                die();
            }
        ));
    }

    private function goTo404()
    {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        get_template_part( 404 );
        die();
    }
} 

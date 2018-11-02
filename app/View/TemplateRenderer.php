<?php
namespace victorhugobatista\WpEruptor\View;

class TemplateRenderer
{
    private $pageData;

    public function __construct($template = '404', $postTypeName = '', $pageData = [])
    {
        $this->pageData = $pageData;
        ob_start();
        get_header();
        $this->getTemplateContent($template, $postTypeName);
        get_footer();
        echo ob_get_clean();
    }

    private function getTemplateContent($template, $postTypeName)
    {
        if ('404' === $template) {
            $this->get404Template();
        } else {
            $themePath = get_template_directory();
            $templateToInclude =
                "{$themePath}/single-page-children/single-{$template}/{$postTypeName}.php";
            if (! file_exists($templateToInclude)) {
                $this->get404Template();
            } else {
                $pageData = $this->pageData;
                include $templateToInclude;
            }
        }
    }

    private function get404Template()
    {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        get_template_part( 404 );
    }
}

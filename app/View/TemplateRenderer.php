<?php
namespace victorhugobatista\WpEruptor\View;

/**
 * Responsible for render the templates of single children pages.
 * Gets the 404 status page if receives '404' as
 * first parameter (or nothing, '404' is default).
 */
class TemplateRenderer
{
    /**
     * Data to make accessible on template.
     *
     * @var array
     */
    private $pageData;

    /**
     * Root directory where the templates are loaded.
     *
     * @var string
     */
    private $templateRootDirectory;

    /**
     * Receive the template and post type names and invokes the template with header e footer.
     * If receive '404' as template name, load the 404 page.
     * Do the same if the template file not exists.
     * Receive the root directory where the templates are loaded. Defaults to <active-theme-dir>/single-page-children.
     *
     * @todo Add filters to allow the modification of header, content and footer by post type, post name and template name.
     *
     * @param string $template Template name. Default to '404'.
     * @param string $postTypeName Post type name, used to find the template path.
     * @param array $pageData Data make available on template.
     * @param boolean $templateRootDirectory Defaults to <active-theme-dir>/single-page-children.
     */
    public function __construct($template = '404', $postTypeName = '', $pageData = [], $templateRootDirectory = '')
    {
        $this->pageData = $pageData;
        $this->templateRootDirectory = $templateRootDirectory;
        ob_start();
        get_header();
        $this->getTemplateContent($template, $postTypeName);
        get_footer();
        echo ob_get_clean();
    }

    /**
     * Verify if template file exists and include to page.
     * If template file does not not exists, get the404 page.
     *
     * @param string $template Template name. Can be 404.
     * @param string $postTypeName Post type name.
     */
    private function getTemplateContent($template, $postTypeName)
    {
        if ('404' === $template) {
            $this->get404Template();
        } else {
            if ('' === $this->templateRootDirectory) {
                $themePath = get_template_directory();
                $templatePath =
                    "{$themePath}/single-page-children";
            } else {
                $templatePath = $this->templateRootDirectory;
            }
            $templateToInclude =
                "{$templatePath}/single-{$template}/{$postTypeName}.php";
            if (! file_exists($templateToInclude)) {
                $this->get404Template();
            } else {
                $pageData = $this->pageData;
                include $templateToInclude;
            }
        }
    }

    /**
     * Load the WordPress 404 page template.
     */
    private function get404Template()
    {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        get_template_part( 404 );
    }
}

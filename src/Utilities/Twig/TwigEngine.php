<?php
declare(strict_types=1);

namespace Grzechu\Utilities\Twig;

use Grzechu\Utilities\Twig\Extension\SymfonyExtensions;
use Grzechu\Utilities\Twig\Extension\WebpackExtension;
use Grzechu\Utilities\Twig\Extension\WordpressExtensions;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class TwigEngine
{
    /**
     * @var Package
     */
    private $package;

    /**
     * @var Environment
     */
    private $twig;

    public function __construct()
    {
        $this->package = new Package(new EmptyVersionStrategy());
        $loader = new FilesystemLoader(dirname(__DIR__) . '/../../templates');
        $this->twig = new Environment($loader);
        $this->addExtensions();
    }

    /**
     * @return Environment
     */
    public function getEnviroment(): Environment
    {
        return $this->twig;
    }

    private function addExtensions(): void
    {
        $webpackExtension = new WebpackExtension();
        $this->twig->addFunction(new TwigFunction('webpack_entry_css_tag', [$webpackExtension, 'webpackEntryCssTag']));
        $this->twig->addFunction(new TwigFunction('webpack_entry_script_tag', [$webpackExtension, 'webpackEntryScriptTag']));

        // WordPress extensions
        $wordpressExtensions = new WordpressExtensions();
        $this->twig->addFunction(new TwigFunction('language_attributes', [$wordpressExtensions, 'language_attributes']));
        $this->twig->addFunction(new TwigFunction('body_class', [$wordpressExtensions, 'body_class']));
        $this->twig->addFunction(new TwigFunction('bloginfo', [$wordpressExtensions, 'bloginfo']));
        $this->twig->addFunction(new TwigFunction('wp_head', [$wordpressExtensions, 'wp_head']));
        $this->twig->addFunction(new TwigFunction('wp_footer', [$wordpressExtensions, 'wp_footer']));
        $this->twig->addFunction(new TwigFunction('wp_title', [$wordpressExtensions, 'wp_title']));
        $this->twig->addFunction(new TwigFunction('get_post_meta', [$wordpressExtensions, 'get_post_meta']));

        // Symfony extensions
        $symfonyExtensions = new SymfonyExtensions();
        $this->twig->addFunction(new TwigFunction('dump', [$symfonyExtensions, 'dump']));
        $this->twig->addFunction(new TwigFunction('asset', [$symfonyExtensions, 'getAssetUrl']));
    }
}

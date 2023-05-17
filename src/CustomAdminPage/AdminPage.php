<?php
declare(strict_types=1);

namespace Grzechu\CustomAdminPage;

use PlainDataTransformer\Transform;

abstract class AdminPage
{
    private static $instances;

    /**
     * @var string
     */
    protected $pageTitle;

    /**
     * @var string
     */
    protected $menuTitle;

    /**
     * @var string
     */
    protected $capability;

    /**
     * @var string
     */
    protected $menuSlug;

    /**
     * @var string
     */
    private $iconUrl;

    /**
     * @var int
     */
    private $position;

    /**
     * @var string|null
     */
    private $parentSlug;

    final public static function getInstance(): self
    {
        $className = get_called_class();

        if (isset(self::$instances[$className]) === false) {
            self::$instances[$className] = new static();
        }

        return self::$instances[$className];
    }

    public function __toString()
    {
        return self::class;
    }

    final private function __construct()
    {
        $this->pageTitle = $this->getPageTitle();
        $this->menuTitle = $this->getMenuTitle();
        $this->capability = $this->getCapability();
        $this->menuSlug = $this->getMenuSlug();
        $this->iconUrl = $this->getIconUrl();
        $this->position = $this->getPosition();
        $this->parentSlug = $this->getParentSlug();
        $this->parentSlug = $this->getParentSlug();

        add_action('in_admin_header', [$this, 'dismissAllNotices'], 1000);

        if ($this->isPageActive()) {
            add_filter('admin_body_class', [$this, 'addBodyClasses'], 1000);
            add_action('in_admin_header', [$this, 'embedPageHeader'], 1000);
        }

        $this->registerMenu();

    }

    abstract public function getPageTitle(): string;
    abstract public function getMenuTitle(): string;
    abstract public function getCapability(): string;
    abstract public function getMenuSlug(): string;
    abstract public function getBodyClasses(): array;
    abstract public function getPageHeaderHtml(): string;
    abstract public function callableFunction();

    public function getPosition(): int
    {
        return 1;
    }

    public function getIconUrl(): string
    {
        return '';
    }

    public function getParentSlug()
    {
        return '';
    }

    public function adminMenu()
    {
        add_menu_page(
            $this->pageTitle,
            $this->menuTitle,
            $this->capability,
            $this->menuSlug,
            [$this, 'callableFunction'],
            $this->iconUrl,
            $this->position
        );
    }

    public function adminSubMenu()
    {
        add_submenu_page(
            $this->parentSlug,
            $this->pageTitle,
            $this->menuTitle,
            $this->capability,
            $this->menuSlug,
            [$this, 'callableFunction']
        );
    }

    public function dismissAllNotices()
    {
        if (!isset($_GET['page']) || $_GET['page'] !== $this->menuSlug) {
            return;
        }

        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
    }

    private function registerMenu()
    {
        if ($this->parentSlug !== '') {
            add_action('admin_menu', [$this, 'adminSubMenu']);

            return;
        }

        add_action('admin_menu', [$this, 'adminMenu']);
    }

    public function addBodyClasses(string $classes): string
    {
        $classes = explode(' ', $classes);

        foreach ($this->getBodyClasses() as $newClass) {
            $class = Transform::toString($newClass ?? '');

            if ($class === '') {
                continue;
            }

            $classes[] = $class;
        }

        return implode(' ', $classes);
    }

    public function embedPageHeader(): void
    {
        echo $this->getPageHeaderHtml();
    }

    private function isPageActive(): bool
    {
        return isset($_GET['page']) && $_GET['page'] === $this->getMenuSlug();
    }

    private function __clone()
    {
    }

    final public function __wakeup()
    {
        throw new \Exception("Cannot unserialize");
    }
}

<?php
declare(strict_types=1);

namespace Grzechu\CustomAdminPage;

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

        add_action(
            'in_admin_header',
            [$this, 'dismissAllNotices'],
            1000
        );
        $this->registerMenu();

    }

    abstract public function getPageTitle(): string;
    abstract public function getMenuTitle(): string;
    abstract public function getCapability(): string;
    abstract public function getMenuSlug(): string;
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

    final private function __clone()
    {
    }

    final private function __wakeup()
    {
    }
}

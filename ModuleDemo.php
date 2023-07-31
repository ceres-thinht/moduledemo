<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

$autoloadPath = __DIR__ . '/vendor/autoload.php';

if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

class ModuleDemo extends Module
{
    const SUCCESS = 1;
    const FAILED = 2;

    const ON = 1;
    const OFF = 0;

    public function __construct()
    {
        $this->name = 'moduledemo';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'THINH TRAN';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => _PS_VERSION_,
        ];

        parent::__construct();

        $this->displayName = $this->l('Module Demo');
        $this->description = $this->l('A demo module for PrestaShop.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('moduledemo')) {
            $this->warning = $this->l('No name provided');
        }

        $this->menus = [
            [
                'className' => 'AdminModuleDemo',
                'name' => 'Module Demo',
                'icon' => '',
            ],
            [
                'className' => 'AdminModuleDemoCatalog',
                'name' => 'Catalog',
                'icon' => 'store',
                'tabParentClassName' => 'AdminModuleDemo',
            ],
            [
                'className' => 'AdminModuleDemoList',
                'name' => 'Filters',
                'icon' => '',
                'tabParentClassName' => 'AdminModuleDemoCatalog',
            ],
            [
                'className' => 'AdminModuleDemoExample',
                'name' => 'Others',
                'icon' => '',
                'tabParentClassName' => 'AdminModuleDemoCatalog',
            ],
            [
                'className' => 'AdminModuleDemoProductList',
                'name' => 'Products',
                'icon' => '',
                'tabParentClassName' => 'AdminModuleDemoList',
            ],
            [
                'className' => 'AdminModuleDemoManufactureList',
                'name' => 'Manufactures',
                'icon' => '',
                'tabParentClassName' => 'AdminModuleDemoList',
            ],
            [
                'className' => 'AdminModuleDemoSupplierList',
                'name' => 'Suppliers',
                'icon' => '',
                'tabParentClassName' => 'AdminModuleDemoList',
            ],
            [
                'className' => 'AdminModuleDemoCategoryList',
                'name' => 'Categories',
                'icon' => '',
                'tabParentClassName' => 'AdminModuleDemoList',
            ],
        ];
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('actionAdminControllerSetMedia') &&
            $this->installTabs();
    }

    public function uninstall()
    {
        return parent::uninstall() && $this->uninstallTabs();
    }

    /**
     * @throws SmartyException
     */
    public function getContent()
    {
        $configData = json_decode(Configuration::get('MODULEDEMO_CONFIG_DATA') ?? '', true);
        $settingStatus = $configData['settingStatus'] ?? self::OFF;
        $serviceAPIURL = $configData['serviceAPIURL'] ?? '';
        $serviceKey = $configData['serviceKey'] ?? '';
        $authorizationAPIURL = $configData['authorizationAPIURL'] ?? '';
        $isUpdated = null;
        $tab = null;

        if (Tools::isSubmit('submit' . $this->name)) {
            // Process the configuration form submission here
            $settingStatus = (string)Tools::getValue('settingStatus', self::OFF);
            $serviceAPIURL = (string)Tools::getValue('serviceAPIURL', '');
            $serviceKey = (string)Tools::getValue('serviceKey', '');
            $authorizationAPIURL = (string)Tools::getValue('authorizationAPIURL', '');
            $configData = json_encode([
                'settingStatus' => $settingStatus,
                'serviceAPIURL' => $serviceAPIURL,
                'serviceKey' => $serviceKey,
                'authorizationAPIURL' => $authorizationAPIURL,
            ]);
            $isUpdated = self::FAILED;

            // Validate and save the configuration value
            if ((int)$settingStatus === self::OFF) {
                Configuration::updateValue('MODULEDEMO_CONFIG_DATA', '');
                $isUpdated = self::SUCCESS;
            }

            if ((int)$settingStatus === self::ON) {
                if (empty($serviceAPIURL) || empty($serviceKey)) {
                    $isUpdated = self::FAILED;
                } else {
                    Configuration::updateValue('MODULEDEMO_CONFIG_DATA', $configData);
                    $isUpdated = self::SUCCESS;
                }
            }
            $this->context->cookie->__set('tab', 'advanced_settings');
            $this->context->cookie->__set('isUpdated', $isUpdated);
            Tools::redirect($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name);
        }

        if ($this->context->cookie->__isset('tab')) {
            $tab = $this->context->cookie->__get('tab');
            $this->context->cookie->__unset('tab');
        }

        if ($this->context->cookie->__isset('isUpdated')) {
            $isUpdated = $this->context->cookie->__get('isUpdated');
            $this->context->cookie->__unset('isUpdated');
        }

        return $this->context->smarty->assign([
            'serviceAPIURL' => $serviceAPIURL,
            'serviceKey' => $serviceKey,
            'authorizationAPIURL' => $authorizationAPIURL,
            'settingStatus' => $settingStatus,
            'isUpdated' => $isUpdated,
            'tab' => $tab,
        ])->fetch($this->getLocalPath() . '/views/templates/admin/configuration/configuration.tpl');
    }

    public function hookActionAdminControllerSetMedia()
    {
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addJS($this->_path . 'views/js/admin/configuration.js');
            $this->context->controller->addCSS(_PS_ADMIN_DIR_ . '/themes/new-theme/public/theme.css');
        }
    }

    public function installTabs($index = 0): bool
    {
        $tabData = $this->menus[$index] ?? null;
        if (empty($tabData)) {
            return true;
        }
        return $this->installModuleTab(
                $tabData['className'] ?? '',
                $tabData['name'] ?? '',
                $tabData['icon'] ?? '',
                $tabData['tabParentClassName'] ?? '',
            ) &&
            $this->installTabs(++$index);
    }

    public function uninstallTabs($index = 0): bool
    {
        $tabData = $this->menus[$index] ?? null;
        if (empty($tabData)) {
            return true;
        }
        return $this->uninstallModuleTab($tabData['className']) && $this->uninstallTabs(++$index);
    }

    private function installModuleTab($tabClass = '', $tabName = '', $icon = '', $tabParentClassName = false, $routeName = ''): bool
    {
        $tab = Tab::getInstanceFromClassName($tabClass);
        foreach (Language::getLanguages() as $language) {
            $tab->name[$language['id_lang']] = $tabName;
        }
        $tab->icon = $icon;
        $tab->class_name = $tabClass;
        $tab->route_name = $routeName;
        $tab->module = $this->name;
        $tab->active = 1;
        if (!empty($tabParentClassName)) {
            $tab->id_parent = (int)Tab::getInstanceFromClassName($tabParentClassName)->id ?? 0;
        } else {
            $tab->id_parent = 0;
        }
        if ($tab->id) {
            return $tab->update();
        } else {
            return $tab->add();
        }
    }

    private function uninstallModuleTab($class_name): bool
    {
        $tab = Tab::getInstanceFromClassName($class_name);
        if ($tab->id != 0) {
            return $tab->delete();
        }
        return false;
    }
}

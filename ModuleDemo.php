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
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'THINH TRAN';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Module Demo');
        $this->description = $this->l('A demo module for PrestaShop.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('moduledemo')) {
            $this->warning = $this->l('No name provided');
        }
    }

    public function install()
    {
        return parent::install() && $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * @throws SmartyException
     */
    public function getContent()
    {
        $settingStatus = Configuration::get('SETTING_STATUS');
        $serviceAPIURL = Configuration::get('SERVICE_API_URL');
        $serviceKey = Configuration::get('SERVICE_KEY');
        $authorizationAPIURL = Configuration::get('AUTHORIZATION_API_URL');
        $isUpdated = null;
        $tab = null;

        if (Tools::isSubmit('submit' . $this->name)) {
            // Process the configuration form submission here
            $settingStatus = (string)Tools::getValue('SETTING_STATUS');
            $serviceAPIURL = (string)Tools::getValue('SERVICE_API_URL');
            $serviceKey = (string)Tools::getValue('SERVICE_KEY');
            $authorizationAPIURL = (string)Tools::getValue('AUTHORIZATION_API_URL');
            $isUpdated = self::FAILED;

            // Validate and save the configuration value
            if ((int)$settingStatus === self::OFF) {
                $serviceAPIURL = '';
                $serviceKey = '';
                $authorizationAPIURL = '';
                Configuration::updateValue('SETTING_STATUS', $settingStatus);
                Configuration::updateValue('SERVICE_API_URL', $serviceAPIURL);
                Configuration::updateValue('SERVICE_KEY', $serviceKey);
                Configuration::updateValue('AUTHORIZATION_API_URL', $authorizationAPIURL);
                $isUpdated = self::SUCCESS;
            }

            if ((int)$settingStatus === self::ON) {
                if (empty($serviceAPIURL) || empty($serviceKey)) {
                    $isUpdated = self::FAILED;
                } else {
                    Configuration::updateValue('SETTING_STATUS', $settingStatus);
                    Configuration::updateValue('SERVICE_API_URL', $serviceAPIURL);
                    Configuration::updateValue('SERVICE_KEY', $serviceKey);
                    Configuration::updateValue('AUTHORIZATION_API_URL', $authorizationAPIURL);
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
        ])->fetch('module:' . $this->name . '/views/templates/admin/configure.tpl');
    }

    public function changeValueOfQueryString($key, $value)
    {
        $queryString = $_SERVER['QUERY_STRING'];

        // Define the parameter to change and its new value
        $paramToChange = $key;
        $newValue = $value;

        // Parse the query string to an associative array
        parse_str($queryString, $paramsArray);

        // Update the parameter value in the array
        $paramsArray[$paramToChange] = $newValue;

        // Redirect to the modified URL
        return $_SERVER['PHP_SELF'] . '?' . http_build_query($paramsArray);
    }

    public function hookDisplayBackOfficeHeader($params)
    {
        $this->context->controller->addJS($this->_path . 'views/js/admin/configure.js');
        $this->context->controller->addCSS(_PS_ADMIN_DIR_ . '/themes/new-theme/public/theme.css');
    }
}

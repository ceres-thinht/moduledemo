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
    private $html = '';

    public function __construct()
    {
        $this->name = 'moduledemo';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'THINH TRAN';
        $this->need_instance = 0;

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
        return parent::install();
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function getContent()
    {
        $settingStatus = Configuration::get('SETTING_STATUS');
        $serviceAPIURL = Configuration::get('SERVICE_API_URL');
        $serviceKey = Configuration::get('SERVICE_KEY');
        $authorizationAPIURL = Configuration::get('AUTHORIZATION_API_URL');
        $isUpdated = null;

        if (Tools::isSubmit('submit' . $this->name)) {
            // Process the configuration form submission here
            $settingStatus = (string)Tools::getValue('SETTING_STATUS');
            $serviceAPIURL = (string)Tools::getValue('SERVICE_API_URL');
            $serviceKey = (string)Tools::getValue('SERVICE_KEY');
            $authorizationAPIURL = (string)Tools::getValue('AUTHORIZATION_API_URL');
            $isUpdated = false;

            // Validate and save the configuration value
            if ((int)$settingStatus === 0) {
                $serviceAPIURL = '';
                $serviceKey = '';
                $authorizationAPIURL = '';
                Configuration::updateValue('SETTING_STATUS', $settingStatus);
                Configuration::updateValue('SERVICE_API_URL', $serviceAPIURL);
                Configuration::updateValue('SERVICE_KEY', $serviceKey);
                Configuration::updateValue('AUTHORIZATION_API_URL', $authorizationAPIURL);
                $isUpdated = true;
            }

            if ((int)$settingStatus === 1) {
                if (empty($serviceAPIURL) || empty($serviceKey)) {
                    $isUpdated = false;
                } else {
                    Configuration::updateValue('SETTING_STATUS', $settingStatus);
                    Configuration::updateValue('SERVICE_API_URL', $serviceAPIURL);
                    Configuration::updateValue('SERVICE_KEY', $serviceKey);
                    Configuration::updateValue('AUTHORIZATION_API_URL', $authorizationAPIURL);
                    $isUpdated = true;
                }
            }
        }

        $this->context->controller->addJS($this->_path . 'views/js/admin/configure.js');

        return $this->context->smarty->assign([
            'welcomeURL' => $this->changeValueOfQueryString('page', 'welcome'),
            'advancedSettingsURL' => $this->changeValueOfQueryString('page', 'advanced_settings'),
            'helpURL' => $this->changeValueOfQueryString('page', 'help'),
            'serviceAPIURL' => $serviceAPIURL,
            'serviceKey' => $serviceKey,
            'authorizationAPIURL' => $authorizationAPIURL,
            'settingStatus' => $settingStatus,
            'isUpdated' => $isUpdated,
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
}

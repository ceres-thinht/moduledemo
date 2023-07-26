<?php

class AdminModuleDemoController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        parent::__construct();
    }

    public function renderForm()
    {
        $fieldsForm = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Module Demo Configuration'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Configuration Field 1'),
                        'name' => 'MODULEDEMO_CONFIG_FIELD_1',
                        'desc' => $this->l('Enter your configuration for Field 1.'),
                    ),
                    // Add more configuration fields as needed
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        $helper = new HelperForm();
        $helper->module = $this->module;
        $helper->name_controller = $this->module->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->module->name;
        $helper->submit_action = 'submit' . $this->module->name;
        $helper->tpl_vars = array(
            'fields_value' => array(
                'MODULEDEMO_CONFIG_FIELD_1' => Configuration::get('MODULEDEMO_CONFIG_FIELD_1'),
            ),
        );

        return $helper->generateForm(array($fieldsForm));
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submit' . $this->module->name)) {
            $configField1Value = Tools::getValue('MODULEDEMO_CONFIG_FIELD_1');

            // Validate and save the configuration values
            Configuration::updateValue('MODULEDEMO_CONFIG_FIELD_1', $configField1Value);

            // Optionally, display a success message
            $this->confirmations[] = $this->l('Settings updated successfully.');
        }
    }
}
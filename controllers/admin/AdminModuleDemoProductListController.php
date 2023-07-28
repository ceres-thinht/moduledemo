<?php

class AdminModuleDemoProductListController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'product';
        $this->className = 'Product';
        $this->meta_title = 'Module demo';
        parent::__construct();
        if (!$this->module->active) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));
        }

        $this->_select = 'a.*, pl.name';
        $this->_join = '
            LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (a.`id_product` = pl.`id_product`)
        ';
        $this->fields_list = [
            'id_product' => [
                'title' => 'ID',
                'align' => 'center',
                'class' => 'fixed-width-xs',
            ],
            'name' => [
                'title' => 'Name',
            ],
            'price' => [
                'title' => 'Price',
                'type' => 'price',
            ],
            'quantity' => [
                'title' => 'Quantity',
            ],
        ];
    }

    public function renderList()
    {
        if (!($this->fields_list && is_array($this->fields_list))) {
            return false;
        }
        $this->getList($this->context->language->id);
        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        // Actions to be displayed in the "Actions" column
        $helper->actions = ['edit', 'delete', 'view', 'details'];
        $helper->identifier = 'id_product';
        $helper->show_toolbar = true;
        $helper->title = 'Product List';
        $helper->specificConfirmDelete = true;
        $helper->token = Tools::getAdminTokenLite('AdminModuleDemoList');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->module->name;
        $helper->listTotal = count($this->_list);
        return $helper->generateList($this->_list, $this->fields_list);
    }
}

<?php

class AdminModuleDemoProductListController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'product';
        $this->className = 'Product';
        $this->meta_title = 'Module demo';
        $this->context = Context::getContext();
        parent::__construct();
        if (!$this->module->active) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));
        }
        $this->fields_list = [
            'id_product' => [
                'title' => $this->trans('ID', [], 'Modules.ModuleDemo.Admin'),
                'align' => 'center',
                'class' => 'fixed-width-xs',
            ],
            'name' => [
                'title' => 'Name',
                'filter_key' => 'pl!name',
            ],
            'default_category' => [
                'title' => $this->trans('Default Category', [], 'Modules.ModuleDemo.Admin'),
                'filter_key' => 'ct!name',
            ],
            'reference' => [
                'title' => $this->trans('Reference', [], 'Modules.ModuleDemo.Admin'),
            ],
            'price' => [
                'title' => $this->trans('Price', [], 'Modules.ModuleDemo.Admin'),
                'type' => 'price',
            ],
            'quantity' => [
                'title' => $this->trans('Quantity', [], 'Modules.ModuleDemo.Admin'),
            ],
        ];
    }

    public function getProducts()
    {
        // Join product_lang
        $this->_select = 'pl.name, ct.name as default_category';
        $this->_join = '
            LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` as pl ON (a.`id_product` = pl.`id_product`)
            LEFT JOIN (
                  SELECT ct.*, ctl.name
                  FROM `' . _DB_PREFIX_ . 'category` as ct
                  JOIN `' . _DB_PREFIX_ . 'category_lang` as ctl ON ct.id_category = ctl.id_category AND ctl.id_lang = ' . $this->context->language->id . '
            ) as ct ON (a.`id_category_default` = ct.`id_category`)
        ';

        $this->getList($this->context->language->id);
    }

    public function renderList()
    {
        // Get products
        $this->getProducts();

        // Config helper list
        $this->addRowAction('edit');
        $this->addRowAction('view');
        $this->toolbar_btn['new'] = array(
            'href' => $this->context->link->getAdminLink(
                'AdminProducts',
                false,
                ['route' => 'admin_product_new'],
            ),
            'desc' => $this->trans('Add new')
        );

        return parent::renderList();
    }
}

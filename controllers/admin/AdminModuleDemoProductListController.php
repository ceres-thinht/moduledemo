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
    }

    public function getProducts()
    {
        $inputs = Tools::getAllValues();
        $orderBy = $inputs['configurationOrderby'] ?? '';
        $orderWay = $inputs['configurationOrderway'] ?? '';

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

        $this->filters($inputs);

        $this->getList($this->context->language->id, $orderBy, $orderWay);
    }

    public function filters($inputs)
    {
        $where = [];
        $id = trim($inputs['configurationFilter_id_product'] ?? '');
        $name = trim($inputs['configurationFilter_name'] ?? '');
        $defaultCategory = trim($inputs['configurationFilter_default_category'] ?? '');
        $reference = trim($inputs['configurationFilter_reference'] ?? '');
        $price = trim($inputs['configurationFilter_price'] ?? '');
        $quantity = trim($inputs['configurationFilter_quantity'] ?? '');
        $isClearFilter = $inputs['submitFilterconfiguration'] ?? '';

        if ($isClearFilter === '0') {
            Tools::redirectAdmin(
                $this->context->link->getAdminLink('AdminModules')
                . '&controller=' . $this->controller_name
                . '&configure=' . $this->module->name
                . '&token=' . $this->token
            );
        }
        if (!empty($id)) {
            $where[] = "AND a.id_product={$id}";
        }
        if (!empty($name)) {
            $where[] = "AND pl.name LIKE '%{$name}%'";
        }
        if (!empty($defaultCategory)) {
            $where[] = "AND ct.name LIKE '%{$defaultCategory}%'";
        }
        if (!empty($reference)) {
            $where[] = "AND a.reference LIKE '%{$reference}%'";
        }
        if (!empty($price) || $price === '0') {
            $formattedNumber = number_format((float)$price, '6');
            $where[] = "AND a.price = {$formattedNumber}";
        }
        if (!empty($quantity) || $quantity === '0') {
            $quantity = (int)$quantity;
            $where[] = "AND a.quantity = {$quantity}";
        }

        $this->_where .= implode(' ', $where);
    }

    public function renderList()
    {
        $fields_list = [
            'id_product' => [
                'title' => $this->trans('ID', [], 'Modules.ModuleDemo.Admin'),
                'align' => 'center',
                'class' => 'fixed-width-xs',
            ],
            'name' => [
                'title' => 'Name',
                'search' => true,
                'orderby' => true,
            ],
            'default_category' => [
                'title' => $this->trans('Default Category', [], 'Modules.ModuleDemo.Admin'),
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

        $this->getProducts();

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        // Actions to be displayed in the "Actions" column
        $helper->actions = ['edit', 'view'];
        $helper->identifier = 'id_product';
        $helper->show_toolbar = true;
        $helper->title = 'Product List: ';
        $helper->specificConfirmDelete = true;
        $helper->token = Tools::getAdminTokenLite('AdminModuleDemoProductList');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->module->name;
        $helper->listTotal = count($this->_list);
        $addURLArr = explode('?', $this->context->link->getAdminLink(
            'AdminProducts', false
        ));
        $addURLArr[0] = ($addURLArr[0] ?? '') . '/new';
        $helper->toolbar_btn['new'] = array(
            'href' => implode('?', $addURLArr),
            'desc' => $this->trans('Add new')
        );

        return $helper->generateList($this->_list, $fields_list);
    }

    public function postProcess()
    {
        $input = Tools::getAllValues();
        if (array_key_exists('updateconfiguration', $input) && !empty($input['id_product'])) {
            Tools::redirectAdmin(
                $this->context->link->getAdminLink(
                    'AdminProducts',
                    true,
                    ['id_product' => $input['id_product']]
                )
            );
        }
        if (array_key_exists('viewconfiguration', $input)) {
            Tools::redirect(
                $this->context->link->getProductLink(
                    $input['id_product']
                )
            );
        }
        if (array_key_exists('deleteconfiguration', $input)) {
            Tools::redirectAdmin(
                $this->context->link->getAdminLink(
                    'AdminProducts',
                    true,
                    ['id_product' => $input['id_product'], 'deleteproduct' => 1]
                )
            );
        }
        return parent::postProcess();
    }
}

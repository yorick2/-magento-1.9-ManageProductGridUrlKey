<?php
class PaulMillband_ManageProductUrlKey_Block_Adminhtml_Catalog_Product_Grid
    extends  Mage_Adminhtml_Block_Catalog_Product_Grid {

    
     protected function _prepareCollection($collection)
    {
        $store = $this->_getStore();
        
        if(!isset($collection)){
            $collection = Mage::getModel('catalog/product')->getCollection();
        }
        
        $collection->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('attribute_set_id')
            ->addAttributeToSelect('type_id');

        if (Mage::helper('catalog')->isModuleEnabled('Mage_CatalogInventory')) {
            $collection->joinField('qty',
                'cataloginventory/stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1',
                'left');
        }
        if ( !is_null($store->getId()) ) {
            //$collection->setStoreId($store->getId());
            $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
            $collection->addStoreFilter($store);
            $collection->joinAttribute(
                'name',
                'catalog_product/name',
                'entity_id',
                null,
                'inner',
                $adminStore
            );
            $collection->joinAttribute(
                'custom_name',
                'catalog_product/name',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'status',
                'catalog_product/status',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'visibility',
                'catalog_product/visibility',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'price',
                'catalog_product/price',
                'entity_id',
                null,
                'left',
                $store->getId()
            );
            $collection->joinAttribute(
                'url_key',
                'catalog_product/url_key',
                'entity_id',
                null,
                'left',
                $store->getId()
            );
            $collection->joinAttribute(
                'url_path',
                'catalog_product/url_path',
                'entity_id',
                null,
                'left',
                $store->getId()
            );
        }
        else {
            $collection->addAttributeToSelect('price');
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        }

        $this->setCollection($collection);

//        parent::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
    }
    
    protected function _prepareColumns()
    {
        $this->addColumn('url_key', array(
            'header' => Mage::helper('catalog')->__('URL Key'),
            'index' => 'url_key',
            'width' => '70',
            'filter'    => false,
            'sortable'  => false,
            'renderer' => 'PaulMillband_ManageProductUrlKey_Block_Adminhtml_Catalog_Product_Renderer_Link'
        )); 
        return parent::_prepareColumns();
    }

     
}
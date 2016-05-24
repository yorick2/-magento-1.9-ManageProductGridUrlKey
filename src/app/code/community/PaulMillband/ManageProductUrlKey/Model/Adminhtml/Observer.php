<?php
class PaulMillband_ManageProductUrlKey_Model_Adminhtml_Observer
{

    public function onBlockHtmlBefore(Varien_Event_Observer $observer) {
        $block = $observer->getBlock();
        if (!isset($block)) return;

        switch ($block->getType()) {
            case 'adminhtml/catalog_product_grid':
                /* @var $block Mage_Adminhtml_Block_Catalog_Product_Grid */
                $block->addColumnAfter('url_key', array(
                    'header' => Mage::helper('catalog')->__('URL Key'),
                    'index' => 'url_key',
                    'width' => '70',
                    'filter'    => false,
                    'sortable'  => false,
                    'renderer' => 'PaulMillband_ManageProductUrlKey_Block_Adminhtml_Catalog_Product_Renderer_Link'
                ),'massaction');
                $block->sortColumnsByOrder();
                break;
        }
    }

    public function onEavLoadBefore(Varien_Event_Observer $observer) {
        $collection = $observer->getCollection();

        if (!isset($collection)) return;

        if ( $collection instanceof Mage_Catalog_Model_Resource_Product_Collection ) {
            /* @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */
            // Manipulate $collection here to add a COLUMN_ID column
            $collection->addExpressionAttributeToSelect('url_key', '', 'url_key');
            $collection->addExpressionAttributeToSelect('url_path', '', 'url_path');
        }
    }

}
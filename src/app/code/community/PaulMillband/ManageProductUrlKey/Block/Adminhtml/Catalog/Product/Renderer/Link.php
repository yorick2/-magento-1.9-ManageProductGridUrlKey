<?php 
class PaulMillband_ManageProductUrlKey_Block_Adminhtml_Catalog_Product_Renderer_Link extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    } 
    protected function _getValue(Varien_Object $row)
    {   
        $out = '';
        $val = $row->getData($this->getColumn()->getIndex());
        if( isset($val) && $val !== 'no_selection' ){
            $url = Mage::getBaseUrl() . $row->getData('url_path');;
            $out .= "<a href='". $url ."'>".$val."</a>"; 
        }
        return $out;
    }
}
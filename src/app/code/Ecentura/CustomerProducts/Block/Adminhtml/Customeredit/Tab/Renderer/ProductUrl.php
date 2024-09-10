<?php
namespace Ecentura\CustomerProducts\Block\Adminhtml\Customeredit\Tab\Renderer;

use Magento\Framework\DataObject;

class ProductUrl extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    public function render(DataObject $row)
    {
        $productId = $row->getData('entity_id');

        $url = $this->getUrl('catalog/product/edit', ['id' => $productId]);

        return '<a href="' . $url . '" target="_blank">' . __('View Product') . '</a>';
    }
}

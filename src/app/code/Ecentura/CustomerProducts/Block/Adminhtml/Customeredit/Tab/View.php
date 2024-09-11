<?php
 
namespace Ecentura\CustomerProducts\Block\Adminhtml\Customeredit\Tab;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
 
class View extends Extended implements TabInterface
{
    protected $_productCollectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('product_grid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(false);
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('name');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('in_products', [
            'type'   => 'checkbox',
            'header' => __('Select'),
            'field_name' => 'checbox', 
            'index'  => 'entity_id', 
        ]);

        $this->addColumn('entity_id', [
            'header' => __('ID'),
            'index'  => 'entity_id',
        ]);
        
        $this->addColumn('name', [
            'header' => __('Name'),
            'index'  => 'name',
        ]);

        $this->addColumn('product_url', [
            'header'   => __('Product URL'),
            'filter'   => false,
            'sortable' => false,
            'renderer' => \Ecentura\CustomerProducts\Block\Adminhtml\Customeredit\Tab\Renderer\ProductUrl::class,
        ]);
    

        return parent::_prepareColumns();
    }

    public function getTabLabel()
    {
        return __('Products');
    }

    public function getTabTitle()
    {
        return __('Products');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
    public function isAjaxLoaded()
    {
        return false;
    }
}
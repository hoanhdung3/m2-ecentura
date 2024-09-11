<?php
 
namespace Ecentura\CustomerProducts\Block\Adminhtml\Customeredit\Tab;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template\Context as ViewContext;
 
class View extends Extended implements TabInterface
{
    protected $_productCollectionFactory;
    protected $_viewContext;
    protected $_customerRepository;
    protected $request;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        CollectionFactory $productCollectionFactory,
        CustomerRepositoryInterface $customerRepository,
        ViewContext $viewContext,
        RequestInterface $request,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_customerRepository = $customerRepository;
        $this->_viewContext = $viewContext;
        $this->request = $request;
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
            'field_name' => 'in_products[]', 
            'index'  => 'entity_id', 
            'values' => $this->getSelectedProducts(),
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

    public function getCustomHtml()
    {
        return $this->getChildHtml('custom_html');
    }

    public function toHtml()
    {
        $html = parent::toHtml();
        $customTemplate = 'Ecentura_CustomerProducts::customer/form/hidden.phtml';
        $customHtml = $this->renderTemplate($customTemplate);

        return $html . $customHtml;
    }

    protected function renderTemplate($templatePath)
    {
        $layout = $this->_viewContext->getLayout();
        $block = $layout->createBlock(Template::class)->setTemplate($templatePath);
        return $block->toHtml();
    }

    public function getSelectedProducts()
    {
        $customerId = $this->request->getParam('id');
        $selectedProducts = [];

        if ($customerId) {
            $customer = $this->_customerRepository->getById($customerId);
            $selectedProductsValue = $customer->getCustomAttribute('products_assigned');

            if ($selectedProductsValue) {
                $selectedProducts = explode(',', $selectedProductsValue->getValue());
            }
        }

        return $selectedProducts;
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
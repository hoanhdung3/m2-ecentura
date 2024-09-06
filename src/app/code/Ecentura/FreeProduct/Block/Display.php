<?php
namespace Ecentura\FreeProduct\Block;

class Display extends \Magento\Framework\View\Element\Template
{
	protected $scopeConfig;
    protected $productRepository;
    protected $freeProduct;
    protected $imageHelper;
    protected $listProduct;
    protected $checkoutSession;

    const FREE_PRODUCT_SKU_PATH = 'checkout/free_product/free_product';

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Catalog\Block\Product\ListProduct $listProduct,
        \Magento\Checkout\Model\Session $checkoutSession
    )
	{
		parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
        $this->listProduct = $listProduct;
        $this->checkoutSession = $checkoutSession;

        if(!isset($this->freeProduct)){
            $this->getFreeProductBySKU();
        }
	}

	public function getFreeProductBySKU()
	{
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $freeProductSKU = $this->scopeConfig->getValue(self::FREE_PRODUCT_SKU_PATH, $storeScope);
        $this->freeProduct = $this->productRepository->get($freeProductSKU) ?: null;
	}

    public function getFreeProduct()
    {
        return $this->freeProduct;
    }

    public function getFreeProductImgUrl()
    {
        $imageUrl = $this->imageHelper->init($this->freeProduct, 'product_page_image_small')
                            ->setImageFile($this->freeProduct->getSmallImage())
                            ->resize(200)
                            ->getUrl();
        return $imageUrl;
    }

    public function getProductCartUrl()
    {
        return $this->listProduct->getAddToCartUrl($this->freeProduct);
    }

    public function checkDisplay()
    {
        if($this->freeProduct == null) return false;

        // Check if the Free Product existed in Cart
        $productId = $this->freeProduct->getId();
        return !$this->checkoutSession->getQuote()->hasProductId($productId);
    }
}
<?php
namespace Ecentura\CustomerProducts\Plugin;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\RequestInterface;

class CustomerSavePlugin
{
    protected $customerRepository;
    protected $request;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        RequestInterface $request
    ) {
        $this->customerRepository = $customerRepository;
        $this->request = $request;
    }

    public function afterExecute(\Magento\Customer\Controller\Adminhtml\Index\Save $subject, $result)
    {
        $selectedProductIds = $this->request->getParam('selected_products');

        if ($selectedProductIds) {
            $customerInfo = $this->request->getParam('customer');
            $customerId = $customerInfo['entity_id'];
            
            if ($customerId) {
                $customer = $this->customerRepository->getById($customerId);
                $customer->setCustomAttribute('products_assigned', $selectedProductIds);
                $this->customerRepository->save($customer);
            }
        }

        return $result;
    }
}

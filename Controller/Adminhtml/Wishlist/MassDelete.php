<?php

namespace Dotdigitalgroup\Email\Controller\Adminhtml\Wishlist;

use Magento\Framework\Controller\ResultFactory;

class MassDelete extends \Magento\Backend\App\Action
{

    /**
     * @var \Dotdigitalgroup\Email\Model\WishlistFactory
     */
    public $wishlist;

    /**
     * MassDelete constructor.
     *
     * @param \Magento\Backend\App\Action\Context          $context
     * @param \Dotdigitalgroup\Email\Model\WishlistFactory $wishlistFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Dotdigitalgroup\Email\Model\WishlistFactory $wishlistFactory
    ) {
        $this->wishlist = $wishlistFactory;

        parent::__construct($context);
    }
    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected');

        if (!is_array($ids)) {
            $this->messageManager->addErrorMessage(__('Please select wishlist.'));
        } else {
            try {
                //@codingStandardsIgnoreStart
                foreach ($ids as $id) {
                    $model = $this->wishlist->create()
                        ->setId($id);
                    $model->delete();
                }
                //@codingStandardsIgnoreEnd
                $this->messageManager->addSuccessMessage(__('Total of %1 record(s) were deleted.', count($ids)));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/');

        return $resultRedirect;
    }
}

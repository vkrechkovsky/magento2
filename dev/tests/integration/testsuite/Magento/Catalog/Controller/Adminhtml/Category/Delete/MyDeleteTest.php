<?php

declare(strict_types=1);

namespace Magento\Catalog\Controller\Adminhtml\Category\Delete;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * @magentoAppArea adminhtml
 */
class MyDeleteTest extends AbstractBackendController
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->categoryRepository = $this->_objectManager->get(CategoryRepositoryInterface::class);
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoDataFixture Magento/Catalog/_files/myCategory.php
     * @return void
     */
    public function testCategoryDelete(): void
    {
        $this->getRequest()->setMethod(HttpRequest::METHOD_POST);
        $this->getRequest()->setPostValue(['id' => 333]);
        $this->dispatch('backend/catalog/category/delete');
        $this->assertSessionMessages($this->equalTo([(string)__('You deleted the category.')]));
        $this->expectExceptionMessage('No such entity with id = 333');
        $this->expectException(\Magento\Framework\Exception\NoSuchEntityException::class);
        $this->categoryRepository->get(333);
    }
}

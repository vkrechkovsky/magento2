<?php

declare(strict_types=1);

namespace Magento\Catalog\Controller\Adminhtml\Category\Save;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\AbstractBackendController;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * @magentoAppArea adminhtml
 */
class CategorySaveTest extends AbstractBackendController
{
    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var Json
     */
    private $jsonSerializer;

    protected function setUp()
    {
        parent::setUp();
        $this->categoryFactory = Bootstrap::getObjectManager()->get(CategoryFactory::class);
        $this->categoryRepository = $this->_objectManager->get(CategoryRepositoryInterface::class);
        $this->jsonSerializer = $this->_objectManager->get(Json::class);
    }

    /**
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testSaveCategory(): void
    {
        $postData = [
            'path_ids' =>
                [
                    0 => '',
                ],
            'use_config' =>
                [
                    'available_sort_by' => true,
                    'default_sort_by' => true,
                    'filter_price_range' => true,
                ],
            'parent' => '2',
            'name' => 'zxc',
            'filter_price_range' => '',
            'is_active' => '1',
            'include_in_menu' => '1',
            'is_anchor' => '1',
            'custom_use_parent_settings' => '0',
            'url_key_create_redirect' => '0',
            'custom_apply_to_products' => '0',
            'display_mode' => 'PRODUCTS',
            'default_sort_by' => 'position',
            'return_session_messages_only' => true,
            'custom_layout_update_file' => '__no_update__'
        ];
        $this->getRequest()->setMethod(HttpRequest::METHOD_POST);
        $this->getRequest()->setPostValue($postData);
        $this->dispatch('backend/catalog/category/save');
        $responseData = $this->jsonSerializer->unserialize($this->getResponse()->getBody());
        $categoryId = $responseData['category']['entity_id'] ?? null;
        $categoryName = $responseData['category']['name'] ?? null;
        $this->assertNotNull($categoryId);
        $this->assertEquals('zxc', $categoryName);
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoDataFixture Magento/Catalog/_files/myCategory.php
     * @return void
     */
    public function testUpdateCategory(): void
    {
        $this->getRequest()->setMethod(HttpRequest::METHOD_POST);
        $this->getRequest()->setPostValue(['entity_id' => 333, 'name' => 'zxc2']);
        $this->dispatch('backend/catalog/category/save');
        $category = $this->categoryRepository->get(333);
        $this->assertEquals('zxc2', $category->getName());
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoDataFixture Magento/Catalog/_files/myCategory.php
     * @return void
     */
    public function testUpdateCategoryError(): void
    {
        $this->getRequest()->setMethod(HttpRequest::METHOD_POST);
        $this->getRequest()->setPostValue([]);
        $this->dispatch('backend/catalog/category/save');
        $this->assertSessionMessages($this->equalTo([(string)__('The "Name" attribute value is empty. Set the attribute and try again.')]));
    }
}

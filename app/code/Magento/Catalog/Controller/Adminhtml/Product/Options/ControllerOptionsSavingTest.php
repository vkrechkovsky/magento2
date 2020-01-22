<?php

declare(strict_types=1);

namespace Magento\Catalog\Controller\Adminhtml\Product\Options;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * @magentoAppArea adminhtml
 */
class ControllerOptionsSavingTest extends AbstractBackendController
{
    /** @var ProductRepositoryInterface $productRepository */
    private $productRepository;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->productRepository = $this->_objectManager->create(ProductRepositoryInterface::class);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/my_product_without_options.php
     * @magentoDbIsolation enabled
     * @dataProvider optionsDataProvider
     * @param array $postData
     * @return void
     */
    public function testCreateCustomOptions(array $postData): void
    {
        $product = $this->productRepository->get('simple');
        $this->getRequest()->setMethod(HttpRequest::METHOD_POST);
        $this->getRequest()->setPostValue($postData);
        $this->dispatch('backend/catalog/product/save/id/' . $product->getEntityId());
        $product = $this->productRepository->get('simple', false, null, true);
        $this->assertNotNull($product);
        $options = $product->getOptions();
        $newtitle = $postData['product']['options'][0]['title'];
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === $newtitle) {
                $found = $option;
            }
        }
        $this->assertNotNull($found);
    }

    /**
     * @return array
     */
    public function optionsDataProvider(): array
    {
        return [
            'Cteate Field' => [
                'field' => [
                    'product' => [
                        'options' => [
                            [
                                'type' => 'field',
                                'title' => 'opt3',
                                'price' => 1.00,
                                'price_type' => 'fixed'
                            ]
                        ]
                    ]
                ]
            ],
            'Create Area' => [
                'area' => [
                    'product' => [
                        'options' => [
                            [
                                'type' => 'area',
                                'title' => 'area3',
                                'price' => 1.00,
                                'price_type' => 'fixed'
                            ]
                        ]
                    ]
                ]
            ],
            'Create DropDown' => [
                'DropDown' => [
                    'product' => [
                        'options' => [
                            [
                                'title' => 'drop_down option',
                                'type' => 'drop_down',
                                'is_require' => true,
                                'sort_order' => 4,
                                'values' => [
                                    [
                                        'title' => 'drop_down option 1',
                                        'price' => 10,
                                        'price_type' => 'fixed',
                                        'sku' => 'drop_down option 1 sku',
                                        'sort_order' => 1,
                                    ],
                                    [
                                        'title' => 'drop_down option 2',
                                        'price' => 20,
                                        'price_type' => 'fixed',
                                        'sku' => 'drop_down option 2 sku',
                                        'sort_order' => 2,
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/my_product_with_options.php
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testDeleteCustomOptions(): void
    {
        $postData = [
            'product' => [
                'options' => [ [] ]
            ]
        ];
        $product = $this->productRepository->get('simple');
        $this->getRequest()->setMethod(HttpRequest::METHOD_POST);
        $this->getRequest()->setPostValue($postData);
        $this->dispatch('backend/catalog/product/save/id/' . $product->getEntityId());
        $product = $this->productRepository->get('simple', false, null, true);
        $this->assertCount(0, $product->getOptions());
    }
}

<?php

declare(strict_types=1);

namespace Catalog\Model\Product\Option;

use Magento\Catalog\Api\Data\ProductCustomOptionInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

class OptionsSavingTest extends TestCase
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->productRepository = $this->objectManager->get(ProductRepositoryInterface::class);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/my_product_with_options.php
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testUpdateField(): void
    {
        $product = $this->productRepository->get('simple');
        $options = $product->getOptions();
        $optionsQty = count($options);
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'test_option_code_1') {
                $found = $option;
            }
        }
        $this->assertNotNull($found);
        $found->setTitle('Cahnged');
        $product->setOptions($options);
        $this->productRepository->save($product);
        $product = $this->productRepository->get('simple', false, null, true);
        $options = $product->getOptions();
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'Cahnged') {
                $found = $option;
            }
        }
        $this->assertNotNull($found);
        $this->assertCount($optionsQty, $options);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/my_product_with_options.php
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testUpdateArea(): void
    {
        $product = $this->productRepository->get('simple');
        $options = $product->getOptions();
        $optionsQty = count($options);
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'area option') {
                $found = $option;
            }
        }
        $this->assertNotNull($found);
        $found->setTitle('Cahnged');
        $product->setOptions($options);
        $this->productRepository->save($product);
        $product = $this->productRepository->get('simple', false, null, true);
        $options = $product->getOptions();
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'Cahnged') {
                $found = $option;
            }
        }
        $this->assertNotNull($found);
        $this->assertCount($optionsQty, $options);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/my_product_with_options.php
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testUpdateDropDown(): void
    {
        $product = $this->productRepository->get('simple');
        $options = $product->getOptions();
        $optionsQty = count($options);
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'drop_down option') {
                $found = $option;
            }
        }
        $this->assertNotNull($found);
        $found->setTitle('Cahnged');
        $product->setOptions($options);
        $this->productRepository->save($product);
        $product = $this->productRepository->get('simple', false, null, true);
        $options = $product->getOptions();
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'Cahnged') {
                $found = $option;
            }
        }
        $this->assertNotNull($found);
        $this->assertCount($optionsQty, $options);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/my_product_with_options.php
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testDeleteField(): void
    {
        $product = $this->productRepository->get('simple');
        $options = $product->getOptions();
        $optionsQty = count($options);
        $found = null;
        foreach ($options as $key => $option) {
            if ($option->getTitle() === 'test_option_code_1') {
                unset($options[$key]);
            }
        }
        $product->setOptions($options);
        $this->productRepository->save($product);
        $product = $this->productRepository->get('simple', false, null, true);
        $options = $product->getOptions();
        foreach ($options as $key => $option) {
            if ($option->getTitle() === 'test_option_code_1') {
                $found = $option;
            }
        }
        $this->assertNull($found);
        $this->assertCount($optionsQty-1, $options);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/my_product_with_options.php
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testDeleteArea(): void
    {
        $product = $this->productRepository->get('simple');
        $options = $product->getOptions();
        $optionsQty = count($options);
        $found = null;
        foreach ($options as $key => $option) {
            if ($option->getTitle() === 'area option') {
                unset($options[$key]);
            }
        }
        $product->setOptions($options);
        $this->productRepository->save($product);
        $product = $this->productRepository->get('simple', false, null, true);
        $options = $product->getOptions();
        foreach ($options as $key => $option) {
            if ($option->getTitle() === 'area option') {
                $found = $option;
            }
        }
        $this->assertNull($found);
        $this->assertCount($optionsQty-1, $options);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/my_product_with_options.php
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testDeleteDropDown(): void
    {
        $product = $this->productRepository->get('simple');
        $options = $product->getOptions();
        $optionsQty = count($options);
        $found = null;
        foreach ($options as $key => $option) {
            if ($option->getTitle() === 'drop_down option') {
                unset($options[$key]);
            }
        }
        $product->setOptions($options);
        $this->productRepository->save($product);
        $product = $this->productRepository->get('simple', false, null, true);
        $options = $product->getOptions();
        foreach ($options as $key => $option) {
            if ($option->getTitle() === 'drop_down option') {
                $found = $option;
            }
        }
        $this->assertNull($found);
        $this->assertCount($optionsQty-1, $options);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/my_product_with_options.php
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testCreateField():void
    {
        $option = [
                'title' => 'test_option_code_2',
                'type' => 'field',
                'is_require' => true,
                'sort_order' => 1,
                'price' => 0,
                'price_type' => 'fixed',
                'sku' => 'sku1',
                'max_characters' => 10,
            ];
        $product = $this->productRepository->get('simple');
        $options = $product->getOptions();
        $optionsQty = count($options);
        $customOptionFactory = $this->objectManager->create(ProductCustomOptionInterfaceFactory::class);
        $customOption = $customOptionFactory->create(['data' => $option]);
        $customOption->setProductSku($product->getSku());
        $options[] = $customOption;
        $product->setOptions($options);
        $this->productRepository->save($product);
        $product = $this->productRepository->get('simple', false, null, true);
        $options = $product->getOptions();
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'test_option_code_2') {
                $found = $option;
            }
        }
        $this->assertNotNull($found);
        $this->assertCount($optionsQty+1, $options);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/my_product_with_options.php
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testCreateArea():void
    {
        $option = [
            'title' => 'area option2',
            'type' => 'area',
            'is_require' => false,
            'sort_order' => 2,
            'price' => 20.0,
            'price_type' => 'percent',
            'sku' => 'sku2',
            'max_characters' => 20
        ];
        $product = $this->productRepository->get('simple');
        $options = $product->getOptions();
        $optionsQty = count($options);
        $customOptionFactory = $this->objectManager->create(ProductCustomOptionInterfaceFactory::class);
        $customOption = $customOptionFactory->create(['data' => $option]);
        $customOption->setProductSku($product->getSku());
        $options[] = $customOption;
        $product->setOptions($options);
        $this->productRepository->save($product);
        $product = $this->productRepository->get('simple', false, null, true);
        $options = $product->getOptions();
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'area option2') {
                $found = $option;
            }
        }
        $this->assertNotNull($found);
        $this->assertCount($optionsQty+1, $options);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/my_product_with_options.php
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testCreateDropDown():void
    {
        $option = [
            'title' => 'drop_down option2',
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
                ]
            ],
        ];
        $product = $this->productRepository->get('simple');
        $options = $product->getOptions();
        $optionsQty = count($options);
        $customOptionFactory = $this->objectManager->create(ProductCustomOptionInterfaceFactory::class);
        $customOption = $customOptionFactory->create(['data' => $option]);
        $customOption->setProductSku($product->getSku());
        $options[] = $customOption;
        $product->setOptions($options);
        $this->productRepository->save($product);
        $product = $this->productRepository->get('simple', false, null, true);
        $options = $product->getOptions();
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'drop_down option2') {
                $found = $option;
            }
        }
        $this->assertNotNull($found);
        $this->assertCount($optionsQty+1, $options);
    }
}

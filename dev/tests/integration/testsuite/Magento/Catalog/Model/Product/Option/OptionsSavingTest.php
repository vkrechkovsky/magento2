<?php

declare(strict_types=1);

namespace Catalog\Model\Product\Option;

use Magento\Catalog\Api\Data\ProductCustomOptionInterfaceFactory;
use Magento\Catalog\Api\ProductCustomOptionRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\ObjectManager;
use PHPUnit\Framework\TestCase;

class OptionsSavingTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /** @var ProductCustomOptionRepositoryInterface */
    private $optionsRepository;

    /** @var ProductCustomOptionInterfaceFactory */
    private $optionsFactory;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->productRepository = $this->objectManager->get(ProductRepositoryInterface::class);
        $this->optionsRepository = $this->objectManager->get(ProductCustomOptionRepositoryInterface::class);
        $this->optionsFactory = $this->objectManager->get(ProductCustomOptionInterfaceFactory::class);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/my_product_with_options.php
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testUpdateField(): void
    {
        $product = $this->productRepository->get('simple');
        $options = $this->optionsRepository->getProductOptions($product);
        $optionsQty = count($options);
        foreach ($options as $option) {
            if ($option->getTitle() === 'test_option_code_1') {
                $option->setTitle('Changed');
                $option->setProductSku($product->getSku());
                $this->optionsRepository->save($option);
                break;
            }
        }
        $options = $this->optionsRepository->getProductOptions($product);
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'Changed') {
                $found = $option;
                break;
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
        $options = $this->optionsRepository->getProductOptions($product);
        $optionsQty = count($options);
        foreach ($options as $option) {
            if ($option->getTitle() === 'area option') {
                $option->setTitle('Changed');
                $option->setProductSku($product->getSku());
                $this->optionsRepository->save($option);
                break;
            }
        }
        $options = $this->optionsRepository->getProductOptions($product);
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'Changed') {
                $found = $option;
                break;
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
        $options = $this->optionsRepository->getProductOptions($product);
        $optionsQty = count($options);
        foreach ($options as $option) {
            if ($option->getTitle() === 'drop_down option') {
                $option->setTitle('Changed');
                $option->setProductSku($product->getSku());
                $this->optionsRepository->save($option);
                break;
            }
        }
        $options = $this->optionsRepository->getProductOptions($product);
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'Changed') {
                $found = $option;
                break;
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
        $options = $this->optionsRepository->getProductOptions($product);
        $optionsQty = count($options);
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'test_option_code_1') {
                $this->optionsRepository->delete($option);
                break;
            }
        }
        $options = $this->optionsRepository->getProductOptions($product);
        foreach ($options as $option) {
            if ($option->getTitle() === 'test_option_code_1') {
                $found = $option;
                break;
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
        $options = $this->optionsRepository->getProductOptions($product);
        $optionsQty = count($options);
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'area option') {
                $this->optionsRepository->delete($option);
                break;
            }
        }
        $options = $this->optionsRepository->getProductOptions($product);
        foreach ($options as $option) {
            if ($option->getTitle() === 'area option') {
                $found = $option;
                break;
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
        $options = $this->optionsRepository->getProductOptions($product);
        $optionsQty = count($options);
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'drop_down option') {
                $this->optionsRepository->delete($option);
                break;
            }
        }
        $options = $this->optionsRepository->getProductOptions($product);
        foreach ($options as $option) {
            if ($option->getTitle() === 'drop_down option') {
                $found = $option;
                break;
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
        $options = $this->optionsRepository->getProductOptions($product);
        $optionsQty = count($options);
        $customOption = $this->optionsFactory->create(['data' => $option]);
        $customOption->setProductSku($product->getSku());
        $this->optionsRepository->save($customOption);
        $options = $this->optionsRepository->getProductOptions($product);
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'test_option_code_2') {
                $found = $option;
                break;
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
            'max_characters' => 20,
        ];
        $product = $this->productRepository->get('simple');
        $options = $this->optionsRepository->getProductOptions($product);
        $optionsQty = count($options);
        $customOption = $this->optionsFactory->create(['data' => $option]);
        $customOption->setProductSku($product->getSku());
        $this->optionsRepository->save($customOption);
        $options = $this->optionsRepository->getProductOptions($product);
        $found = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'area option2') {
                $found = $option;
                break;
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
                    'title' => 'drop_down option value 1',
                    'price' => 10,
                    'price_type' => 'fixed',
                    'sku' => 'drop_down option 1 sku',
                    'sort_order' => 1,
                ],
            ],
        ];
        $product = $this->productRepository->get('simple');
        $options = $this->optionsRepository->getProductOptions($product);
        $optionsQty = count($options);
        $customOption = $this->optionsFactory->create(['data' => $option]);
        $customOption->setProductSku($product->getSku());
        $this->optionsRepository->save($customOption);
        $product = $this->productRepository->get('simple', false, null, true);
        $options = $this->optionsRepository->getProductOptions($product);
        $correctOption = null;
        $correctValue = null;
        foreach ($options as $option) {
            if ($option->getTitle() === 'drop_down option2') {
                $values = $option->getValues();
                foreach ($values as $value) {
                    if ($value->getTitle() === 'drop_down option value 1') {
                        $correctValue = $value;
                    };
                    break;
                }
                $correctOption = $option;
                break;
            }
        }
        $this->assertNotNull($correctOption);
        $this->assertNotNull($correctValue);
        $this->assertCount($optionsQty+1, $options);
    }
}

<?php

declare(strict_types=1);

use Magento\Catalog\Api\Data\ProductCustomOptionInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Store\Api\WebsiteRepositoryInterface;
use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\Store\StoreManager;

$objectManager = ObjectManager::getInstance();

/** @var WebsiteRepositoryInterface $websiteRepository */
$websiteRepository = $objectManager->get(WebsiteRepositoryInterface::class);


/** @var ProductRepositoryInterface $productRepository */
$productRepository = $objectManager->get(ProductRepositoryInterface::class);

/** @var Product $product*/
$product = $objectManager->create(Product::class);

/** @var ProductCustomOptionInterfaceFactory $customOptionFactory */
$customOptionFactory = $objectManager->create(ProductCustomOptionInterfaceFactory::class);

$product->setTypeId(
    Type::TYPE_SIMPLE
)->setAttributeSetId(
    $product->getDefaultAttributeSetId()
)->setWebsiteIds(
    [$websiteRepository->get('base')->getId()]
)->setName(
    'Simple Product With Custom Options'
)->setSku(
    'simple'
)->setPrice(
    10
)->setMetaTitle(
    'meta title'
)->setMetaKeyword(
    'meta keyword'
)->setMetaDescription(
    'meta description'
)->setVisibility(
    Visibility::VISIBILITY_BOTH
)->setStatus(
    Status::STATUS_ENABLED
)->setCanSaveCustomOptions(
    true
)->setStockData(
    [
        'qty' => 100,
        'is_in_stock' => 1,
        'manage_stock' => 1,
    ]
)->setHasOptions(true);

$options = [
    [
        'title' => 'test_option_code_1',
        'type' => 'field',
        'is_require' => true,
        'sort_order' => 1,
        'price' => 0,
        'price_type' => 'fixed',
        'sku' => 'sku1',
        'max_characters' => 10,
        'product_sku' => 'simple',
    ],
    [
        'title' => 'area option',
        'type' => 'area',
        'is_require' => false,
        'sort_order' => 2,
        'price' => 20.0,
        'price_type' => 'percent',
        'sku' => 'sku2',
        'max_characters' => 20,
        'product_sku' => 'simple',
    ],
    [
        'title' => 'file option',
        'type' => 'file',
        'is_require' => true,
        'sort_order' => 3,
        'price' => 30.0,
        'price_type' => 'percent',
        'sku' => 'sku3',
        'file_extension' => 'jpg, png, gif',
        'image_size_x' => 10,
        'image_size_y' => 20,
        'product_sku' => 'simple',
    ],
    [
        'title' => 'drop_down option',
        'type' => 'drop_down',
        'is_require' => true,
        'sort_order' => 4,
        'product_sku' => 'simple',
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
        ],
    ],
    [
        'title' => 'radio option',
        'type' => 'radio',
        'is_require' => true,
        'sort_order' => 5,
        'product_sku' => 'simple',
        'values' => [
            [
                'title' => 'radio option 1',
                'price' => 10,
                'price_type' => 'fixed',
                'sku' => 'radio option 1 sku',
                'sort_order' => 1,
            ],
            [
                'title' => 'radio option 2',
                'price' => 20,
                'price_type' => 'fixed',
                'sku' => 'radio option 2 sku',
                'sort_order' => 2,
            ],
        ],
    ],
    [
        'title' => 'checkbox option',
        'type' => 'checkbox',
        'is_require' => true,
        'sort_order' => 6,
        'product_sku' => 'simple',
        'values' => [
            [
                'title' => 'checkbox option 1',
                'price' => 10,
                'price_type' => 'fixed',
                'sku' => 'checkbox option 1 sku',
                'sort_order' => 1,
            ],
            [
                'title' => 'checkbox option 2',
                'price' => 20,
                'price_type' => 'fixed',
                'sku' => 'checkbox option 2 sku',
                'sort_order' => 2,
            ],
        ],
    ],
    [
        'title' => 'multiple option',
        'type' => 'multiple',
        'is_require' => true,
        'sort_order' => 7,
        'product_sku' => 'simple',
        'values' => [
            [
                'title' => 'multiple option 1',
                'price' => 10,
                'price_type' => 'fixed',
                'sku' => 'multiple option 1 sku',
                'sort_order' => 1,
            ],
            [
                'title' => 'multiple option 2',
                'price' => 20,
                'price_type' => 'fixed',
                'sku' => 'multiple option 2 sku',
                'sort_order' => 2,
            ],
        ],
    ],
    [
        'title' => 'date option',
        'type' => 'date',
        'price' => 80.0,
        'price_type' => 'fixed',
        'sku' => 'date option sku',
        'is_require' => true,
        'sort_order' => 8,
        'product_sku' => 'simple',
    ],
    [
        'title' => 'date_time option',
        'type' => 'date_time',
        'price' => 90.0,
        'price_type' => 'fixed',
        'is_require' => true,
        'sort_order' => 9,
        'sku' => 'date_time option sku',
        'product_sku' => 'simple',
    ],
    [
        'title' => 'time option',
        'type' => 'time',
        'price' => 100.0,
        'price_type' => 'fixed',
        'is_require' => true,
        'sku' => 'time option sku',
        'sort_order' => 10,
        'product_sku' => 'simple',
    ]
];

$customOptions = [];
foreach ($options as $option) {

    /** @var \Magento\Catalog\Api\Data\ProductCustomOptionInterface $customOption */
    $customOption = $customOptionFactory->create(['data' => $option]);
    $customOption->setProductSku($product->getSku());
    $customOptions[] = $customOption;
}
$product->setOptions($customOptions);
$productRepository->save($product);

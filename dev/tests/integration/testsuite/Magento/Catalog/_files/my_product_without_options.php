<?php

declare(strict_types=1);

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;

/** @var ObjectManagerInterface $objectManager */
$objectManager = Bootstrap::getObjectManager();

/** @var ProductRepositoryInterface $productRepository */
$productRepository = $objectManager->get(ProductRepositoryInterface::class);

/** @var ProductFactory $productFactory */
$productFactory = $objectManager->get(ProductFactory::class);
$product = $productFactory->create();
$product->setSku(
    'simple'
)->setTypeId(
    Type::TYPE_SIMPLE
)->setAttributeSetId(
    $product->getDefaultAttributeSetId()
)->setName(
    'Simple Product Without Custom Options'
)->setPrice(
    10
)->setCanSaveCustomOptions(
    true
);
$productRepository->save($product);

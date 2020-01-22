<?php

declare(strict_types=1);

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\TestFramework\Helper\Bootstrap;

/** @var Registry $registry */
$registry = Bootstrap::getObjectManager()->get(Registry::class);
$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);

/** @var ProductRepositoryInterface $repository */
$repository = Bootstrap::getObjectManager()->get(ProductRepositoryInterface::class);
try {
    $repository->deleteById('simple');
} catch (NoSuchEntityException $e) {
    //Entity already deleted
}
$registry->unregister('isSecureArea');
$registry->register('isSecureArea', false);

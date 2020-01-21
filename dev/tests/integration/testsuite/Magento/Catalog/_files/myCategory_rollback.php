<?php

declare(strict_types=1);

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\TestFramework\Helper\Bootstrap;

/** @var $objectManager */
$objectManager = Bootstrap::getObjectManager();
/** @var Registry $registry */
$registry = $objectManager->get(Registry::class);
/** @var CategoryRepositoryInterface $categoryRepository */
$categoryRepository = $objectManager->get(CategoryRepositoryInterface::class);
$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);
try {
    $categoryRepository->deleteByIdentifier(333);
} catch (NoSuchEntityException $e) {
    //category already deleted
}
$registry->unregister('isSecureArea');
$registry->register('isSecureArea', false);

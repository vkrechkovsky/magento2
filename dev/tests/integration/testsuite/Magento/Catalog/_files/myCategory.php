<?php

declare(strict_types=1);

use Magento\Catalog\Model\CategoryFactory;
use Magento\TestFramework\Helper\Bootstrap;

/** @var CategoryFactory $categoryFactory */
$categoryFactory = Bootstrap::getObjectManager()->create(CategoryFactory::class);
$category = $categoryFactory->create();
$category->isObjectNew(true);
$category->setId(
    333
)->setCreatedAt(
    '2014-06-23 09:50:07'
)->setName(
    'Category 1'
)->setParentId(
    2
)->setPath(
    '1/2/333'
)->setLevel(
    2
)->setAvailableSortBy(
    ['position', 'name']
)->setDefaultSortBy(
    'name'
)->setIsActive(
    true
)->setPosition(
    1
)->save();

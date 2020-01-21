<?php

declare(strict_types=1);

namespace Magento\Catalog\Model\CategoryRepository;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\CategoryRepositoryInterfaceFactory;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    /**
     * @var CategoryRepositoryFactory
     */
    private $categoryRepositoryFactory;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    protected function setUp()
    {
        parent::setUp();
        $this->objectManager = Bootstrap::getObjectManager();
        $this->categoryRepository = $this->objectManager->get(CategoryRepositoryInterface::class);
        $this->categoryFactory = $this->objectManager->get(CategoryFactory::class);
        $this->categoryRepositoryFactory = $this->objectManager->get(CategoryRepositoryInterfaceFactory::class);
    }

    /**
     * @magentoDbIsolation enabled
     * @return void
     */
    public function testCreateCategory(): void
    {
        $category = $this->categoryFactory->create();
        $category->isObjectNew(true);
        $category->setName('Category 1')
            ->setParentId(2)
            ->setAvailableSortBy(['position', 'name'])
            ->setDefaultSortBy('name')
            ->setIsActive(true)
            ->setPosition(1);
        try {
            $newCategory = $this->categoryRepository->save($category);
            $this->assertInstanceOf(CategoryInterface::class, $newCategory);
            $this->assertNotNull($newCategory->getId());
        } catch (NoSuchEntityException $e) {
            $this->fail('category isn\'t created');
        }
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoDataFixture Magento/Catalog/_files/myCategory.php
     * @return void
     */
    public function testEditCategory(): void
    {
        $category = $this->categoryRepository->get(333);
        $category->setName('Category changed');
        $this->categoryRepository->save($category);
        $categoryRepository = $this->categoryRepositoryFactory->create();
        $category = $categoryRepository->get(333);
        $this->assertEquals('Category changed', $category->getName());
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoDataFixture Magento/Catalog/_files/myCategory.php
     * @magentoAppArea adminhtml
     * @return void
     */
    public function testDeleteCategory(): void
    {
        $category = $this->categoryRepository->get(333);
        $this->categoryRepository->delete($category);
        $categoryRepository = $this->categoryRepositoryFactory->create();
        $this->expectExceptionMessage('No such entity with id = 333');
        $categoryRepository->get(333);
    }

    /**
     * @param string $name
     * @param int $categoryId
     * @dataProvider categoryDataProvider
     * @magentoDbIsolation enabled
     * @magentoDataFixture Magento/Catalog/_files/myCategory.php
     * @return void
     */
    public function testEditCategory2(string $name, int $categoryId): void
    {
        $category = $this->categoryRepository->get($categoryId);
        $category->setName($name);
        $this->categoryRepository->save($category);
        $categoryRepository = $this->categoryRepositoryFactory->create();
        $category = $categoryRepository->get($categoryId);
        $this->assertEquals($name, $category->getName());
    }

    /**
     * @return array
     */
    public function categoryDataProvider(): array
    {
        return [
            'Changed Name' => [
                'asdasdasda',
                333
            ],
            'Changed Name2' => [
                'ewrggheyhet',
                333
            ],
            'Changed Name3' => [
                'dgfsghg',
                333
            ]
        ];
    }
}

<?php

namespace Scriptkid\Rootcategorynavigation\Block;

class Rootcategorynavigation extends \Magento\Catalog\Block\Navigation
{
  protected $_objectManager;
  protected $_rootCategory;
  protected $_rootCategoryId = 3;

  public function getCategory()
  {
    return $this->getRootCategory();
  }

  public function getRootCategory()
  {
    if(empty($_objectManager))
    {
      $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }
    $_rootCategory = $this->_objectManager->create('Magento\Catalog\Model\Category')->load($this->_rootCategoryId);

    $this->_rootCategory = $_rootCategory;
    return $_rootCategory;
  }

  public function getCurrentCategory()
  {
      //return $this->_catalogLayer->getCurrentCategory();

      if(isset($this->_rootCategory))
      {
        return $this->_rootCategory;
      } else {
        return $this->getRootCategory();
      }
  }

  public function isCategoryActive($category)
  {
      if ($this->_catalogLayer->getCurrentCategory()) {
          return in_array($category->getId(), $this->_catalogLayer->getCurrentCategory()->getPathIds());
      }
      return false;
  }

  public function getCurrentChildCategories()
  {
      $categories = $this->getCategory()->getChildrenCategories();
      /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection */
      $productCollection = $this->_productCollectionFactory->create();
      $this->_catalogLayer->prepareProductCollection($productCollection);
      $productCollection->addCountToCategories($categories);
      return $categories;
  }

}

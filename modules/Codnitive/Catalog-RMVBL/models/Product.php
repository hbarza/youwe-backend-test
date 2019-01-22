<?php

namespace app\modules\Codnitive\Catalog\models;

use app\modules\Codnitive\Core\models\ActiveRecord;
use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Event\models\Event\Price;

class Product extends ActiveRecord
{
    const NAME_GLUE = '__';

    protected $_noFreePrice = false;

    public static function tableName()
    {
       return '{{catalog_product}}';
    }

    public function rules()
    {
       $rules = [
           [['name', 'price', 'entity_id', 'entity_type', 'entity_model',
            'price_id', 'price_model', 'merchant_id'],
           'safe']
       ];
       return $rules;
    }

    public function getName($linear = false, $link = true, string $name = null)
    {
        $name = $name ?? $this->name;
        list($parent, $child) = explode(self::NAME_GLUE, $name);
        $name = $linear ? "$parent <span>($child)</span>" : $parent;
        if ($link) {
            $url    = $this->getEntityUrl();
            $name   = "<a href=\"$url\">$name</a>";
        } 
        
        return $linear ? $name : "<dl><dt>$name</dt><dd>$child</dd></dl>";
    }

    public function getEntityUrl()
    {
        $entityModel       = new $this->entity_model;
        $entityModel->name = $this->name;
        $entityModel->id   = $this->entity_id;

        return $entityModel->getUrl();
    }

    public function loadEntityWithPrice($entityId, $priceId)
    {
       return $this->loadOne(0, ['entity_id' => $entityId, 'price_id' => $priceId]);
       // $product = $this->find()
       //      ->where(['entity_id' => $entityId, 'price_id' => $priceId])
       //      ->limit(1)
       //      ->one();
       //  if ($product) {
       //      return $product;
       //  }
       //  return $this;
    }

    protected function _prepareCollection($fieldsToSelect = ['*'])
    {
       $this->setLimit(1000);
       $collection = parent::_prepareCollection($fieldsToSelect);
       if ($this->_noFreePrice) {
           $collection->andFilterWhere(['!=', 'price', Price::FREE_PRICE]);
       }
       return $collection;
    }

    public function getEntityProducts($entityId, $noFreePrice = false)
    {
       $this->_noFreePrice = $noFreePrice;
       return $this->setParentObjectId('entity_id', $entityId)->getCollection();
    }

    public function deleteProduct($entityId, $priceId = null)
    {
       $whereString = 'entity_id = :entity_id';
       $whereArray  = ['entity_id' => $entityId];
       // $where = ['entity_id' => $entityId];
       if ($priceId === '*') {
           $whereString .= ' AND price != :price';
           $whereArray['price'] = Price::FREE_PRICE;
       }
       elseif ($priceId !== null) {
           // $where['price_id'] = $priceId;
           $whereString .= ' AND price_id = :price_id';
           $whereArray['price_id'] = $priceId;
       }
       return $this->deleteAll($whereString, $whereArray);
    }

    public function initData($entityObject, $priceObject, $params)
    {
        $entityModel = get_class($entityObject);
        $priceModel  = get_class($priceObject);
        $entityType  = $params['entity_type'];
        $namefield   = $params['entity_name'];
        $name    = $entityObject->$namefield;
        $price   = Price::FREE_PRICE;
        $priceId = 0;

        if ($entityModel != $priceModel) {
           $namefield = $params['price_name'];
           $priceName = $priceObject->$namefield;
           $name     .= self::NAME_GLUE;
           $name     .= $priceName;
           $price     = $priceObject->base_price;
           $priceId   = $priceObject->id?:0;
        }

        return [
           'name'          => $name,
           'price'         => $price,
           'entity_id'     => $entityObject->id,
           'entity_type'   => Tools::getOptionIdByValue('Catalog', 'EntityType', $entityType),
           'entity_model'  => $entityModel,
           'price_id'      => $priceId,
           'price_model'   => $priceModel,
           'merchant_id'   => Tools::getUser()->id,
        ];
    }

    public function checkForAvailableQty($quantity)
    {
        $availableQty = (new $this->price_model)->loadOne($this->price_id)->qty;
        return $quantity <= $availableQty;
    }

    public function getUnavailableMessage($quantity)
    {
        return sprintf('%s is not available in %d quantity', $this->getName(true), $quantity);
    }
}

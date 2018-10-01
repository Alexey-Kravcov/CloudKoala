<?php

namespace backend\components;


use yii\data\BaseDataProvider;
use yii\base\InvalidConfigException;
use yii\db\QueryInterface;

class ProductDataProvider extends BaseDataProvider {

    public $query_section;
    public $query_element;
    public $db;
    public $key;

    public function init()
    {
        parent::init();
        if (is_string($this->db)) {
            $this->db = Instance::ensure($this->db, Connection::className());
        }
    }

    protected function prepareModels()
    {
        if (!$this->query_section instanceof QueryInterface) {
            //throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }
        // sections
        $query = clone $this->query_section;
        if(\Yii::$app->request->get('depth') > 0) $depth = intval( \Yii::$app->request->get('depth') );
        else $depth = 0;
        $query->andFilterWhere([
            'depth'=> $depth,
            'parent' => intval( \Yii::$app->request->get('section_id') ),
        ]);

        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();
            $query->limit($pagination->getLimit())->offset($pagination->getOffset());
        }
        /*if (($sort = $this->getSort()) !== false) {
            $query->addOrderBy($sort->getOrders());
        }*/
        
        $result = array();
        $result['sections'] = $query->all();

        //elements
        $query = clone $this->query_element;
        $query->andFilterWhere([
            'section_id' => intval( \Yii::$app->request->get('section_id') ),
        ]);
        $result['elements'] = $query->all();


        return $result;

    }

    protected function prepareKeys($models)
    {
        $keys = [];
        if ($this->key !== null) {
            foreach ($models as $model) {
                if (is_string($this->key)) {
                    $keys[] = $model[$this->key];
                } else {
                    $keys[] = call_user_func($this->key, $model);
                }
            }

            return $keys;
        } elseif ($this->query_section instanceof ActiveQueryInterface) {
            /* @var $class \yii\db\ActiveRecord */
            $class = $this->query_section->modelClass;
            $pks = $class::primaryKey();
            if (count($pks) === 1) {
                $pk = $pks[0];
                foreach ($models as $model) {
                    $keys[] = $model[$pk];
                }
            } else {
                foreach ($models as $model) {
                    $kk = [];
                    foreach ($pks as $pk) {
                        $kk[$pk] = $model[$pk];
                    }
                    $keys[] = $kk;
                }
            }

            return $keys;
        } else {
            return array_keys($models);
        }
    }

    protected function prepareTotalCount()
    {
        if (!$this->query_section instanceof QueryInterface) {
            throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }
        $query = clone $this->query_section;
        return (int) $query->limit(-1)->offset(-1)->orderBy([])->count('*', $this->db);
    }

    public function setSort($value)
    {
        parent::setSort($value);
        if (($sort = $this->getSort()) !== false && $this->query_section instanceof ActiveQueryInterface) {
            /* @var $model Model */
            $model = new $this->query_section->modelClass;
            if (empty($sort->attributes)) {
                foreach ($model->attributes() as $attribute) {
                    $sort->attributes[$attribute] = [
                        'asc' => [$attribute => SORT_ASC],
                        'desc' => [$attribute => SORT_DESC],
                        'label' => $model->getAttributeLabel($attribute),
                    ];
                }
            } else {
                foreach ($sort->attributes as $attribute => $config) {
                    if (!isset($config['label'])) {
                        $sort->attributes[$attribute]['label'] = $model->getAttributeLabel($attribute);
                    }
                }
            }
        }
    }
}
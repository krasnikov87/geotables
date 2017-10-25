<?php

class geoTableLocalItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'geoTableLocalItem';
    public $classKey = 'geoTableLocalItem';
    public $languageTopics = array('geotable');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $itemId = trim($this->getProperty('item_id'));
        if (empty($itemId)) {
            $this->modx->error->addError('geo_table_fossils_item_err_item_id');
        }
        $regionId = trim($this->getProperty('region_id'));
        if (empty($regionId)) {
            $this->modx->error->addField('region_id', $this->modx->lexicon('geo_table_fossils_item_err_region_id'));
        }
        $count = trim($this->getProperty('count'));
        if(empty($count)){
            $this->modx->error->addField('count', $this->modx->lexicon('geo_table_fossils_item_err_count'));
        }
        $type = trim($this->getProperty('type'));
        if(empty($type)){
            $this->modx->error->addField('count', $this->modx->lexicon('geo_table_fossils_item_err_type'));
        }

        if ($this->modx->getCount($this->classKey, [
            'region_id'=>$regionId,
            'type'  => $type,
            'item_id' => $itemId
            ])){
            $this->modx->error->addField('region_id', $this->modx->lexicon('geotables_itemlocal_err_ae'));
            $this->modx->error->addField('type', $this->modx->lexicon('geotables_itemlocal_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'geoTableLocalItemCreateProcessor';
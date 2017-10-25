<?php

class geoTableItemsCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'geoTableItems';
    public $classKey = 'geoTableItems';
    public $languageTopics = array('geotable');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $year = trim($this->getProperty('year'));
        if (empty($year)) {
            $this->modx->error->addField('year', $this->modx->lexicon('geotable_item_err_year'));
        }
        $fossilsId = $this->getProperty('fossils_id');
        if (empty($fossilsId)){
            $this->modx->error->addField('fossils_id', $this->modx->lexicon('geotable_item_err_fossils'));
        }

        if($this->modx->getCount($this->classKey, [
            'fossils_id' => $this->modx->toJSON($fossilsId),
            'year'      => $year
        ])){
            return $this->modx->lexicon('geotables_itemlocal_err_ae');
        }


        return parent::beforeSet();
    }

}

return 'geoTableItemsCreateProcessor';
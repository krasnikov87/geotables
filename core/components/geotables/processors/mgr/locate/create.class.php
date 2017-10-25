<?php

class geoTableRegionsCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'geoTableRegions';
    public $classKey = 'geoTableRegions';
    public $languageTopics = array('geotable');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('geo_table_fossils_item_err_name'));
        }

        if ($this->modx->getCount($this->classKey, ['name'=>$name])){
            $this->modx->error->addField('name', $this->modx->lexicon('geotables_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'geoTableRegionsCreateProcessor';
<?php

class geoTableFossilsItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'geoTableFossils';
    public $classKey = 'geoTableFossils';
    public $languageTopics = array('geotable');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('geotables_item_err_name'));
        }

        if ($this->modx->getCount($this->classKey, ['name'=>$name])){
            $this->modx->error->addField('name', $this->modx->lexicon('geotables_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'geoTableFossilsItemCreateProcessor';
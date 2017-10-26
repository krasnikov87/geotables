<?php

class geoTableItemsUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'geoTableItems';
    public $classKey = 'geoTableItems';
    public $languageTopics = array('geotable');
    //public $permission = 'save';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int)$this->getProperty('id');
        if (empty($id)) {
            return $this->modx->lexicon('modextra_item_err_ns');
        }
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
            'year'      => $year,
            'id:!=' => $id
        ])){
            return $this->modx->lexicon('geotables_itemlocal_err_ae');
        }



        return parent::beforeSet();
    }

    public function afterSave()
    {
        $this->modx->removeCollection('geoTableFossilsItem', [
            'item_id' =>  $this->object->get('id'),
        ]);


        $fossilsId = $this->getProperty('fossils_id');

        foreach ($fossilsId as $id){
            $obj = $this->modx->newObject('geoTableFossilsItem', [
                'fossils_id' => $id,
                'item_id' => $this->object->get('id'),
            ]);
            $obj->save();
        }

        return parent::afterSave();
    }


}

return 'geoTableItemsUpdateProcessor';

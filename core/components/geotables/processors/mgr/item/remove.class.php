<?php

class modExtraItemRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'geoTableItems';
    public $classKey = 'geoTableItems';
    public $languageTopics = array('geotables');
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('modextra_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var modExtraItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('modextra_item_err_nf'));
            }

            $object->remove();

            $this->modx->removeCollection('geoTableFossilsItem', [
                'item_id' =>  $id,
            ]);

            $this->modx->removeCollection('geoTableLocalItem', [
                'item_id' =>  $id,
            ]);
        }



        return $this->success();
    }




}

return 'modExtraItemRemoveProcessor';
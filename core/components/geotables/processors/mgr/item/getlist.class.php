<?php

class geoTableItemsGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'geoTableItems';
    public $classKey = 'geoTableItems';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    //public $permission = 'list';


    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where(array(
                'name:LIKE' => "%{$query}%",
            ));
        }

        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $fossils = $this->modx->getCollection('geoTableFossils', ['id:IN'=>$array['fossils_id']]);

        $nameFossil = '';
        foreach ($fossils as $fossil){
            $nameFossil .= !empty($nameFossil) ? ', '.$fossil->get('name') : $fossil->get('name');
        }

        $array['fossils_id'] = $nameFossil;
        $array['actions'] = array();

        // Edit
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('geotables_item_update'),
            'action' => 'updateItem',
            'button' => true,
            'menu' => true,
        );


        // Remove
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('geotables_item_remove'),
            'multiple' => $this->modx->lexicon('geotables_items_remove'),
            'action' => 'removeItem',
            'button' => true,
            'menu' => true,
        );

        return $array;
    }

}

return 'geoTableItemsGetListProcessor';
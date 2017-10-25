<?php

class geoTableLocalItemGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'geoTableLocalItem';
    public $classKey = 'geoTableLocalItem';
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
                'name:LIKE' => "%{$query}%"
            ));
        }

        if($items = trim($this->getProperty('item_id'))){
            $c->where([
                'item_id' => $items
            ]);
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

        /*Тип*/
        $array['type']= $array['type'] == 1 ? $this->modx->lexicon('geotables_item_region_type_main') : $this->modx->lexicon('geotables_item_region_type_extraction');

        /*Регион*/
        $region = $this->modx->getObject('geoTableRegions', $array['region_id']);
        $array['region_id'] = $region->get('name');

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

return 'geoTableLocalItemGetListProcessor';
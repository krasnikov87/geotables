<?php
$xpdo_meta_map['geoTableFossilsItem']= array (
  'package' => 'geotables',
  'version' => '1.1',
  'table' => 'geo_table_fossils_item',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'item_id' => 0,
    'fossils_id' => 0,
  ),
  'fieldMeta' => 
  array (
    'item_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'fossils_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
  ),
  'aggregates' => 
  array (
    'geoTableFossilsRegionItems' => 
    array (
      'class' => 'geoTableItems',
      'local' => 'item_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'geoTableFossilsItem' => 
    array (
      'class' => 'geoTableFossils',
      'local' => 'fossils_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);

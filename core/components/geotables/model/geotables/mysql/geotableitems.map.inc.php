<?php
$xpdo_meta_map['geoTableItems']= array (
  'package' => 'geotables',
  'version' => '1.1',
  'table' => 'geo_table_items',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'fossils_id' => NULL,
    'year' => NULL,
  ),
  'fieldMeta' => 
  array (
    'fossils_id' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'json',
      'null' => false,
      'index' => 'index',
    ),
    'year' => 
    array (
      'dbtype' => 'int',
      'precision' => '4',
      'phptype' => 'integer',
    ),
  ),
  'composites' => 
  array (
    'geoTableLocalItems' => 
    array (
      'class' => 'geoTableItems',
      'local' => 'id',
      'foreign' => 'item_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'geoTableFossilsItems' => 
    array (
      'class' => 'geoTableFossils',
      'local' => 'fossils_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);

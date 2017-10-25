<?php
$xpdo_meta_map['geoTableLocalItem']= array (
  'package' => 'geotables',
  'version' => '1.1',
  'table' => 'geo_table_local',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'item_id' => 0,
    'region_id' => 0,
    'count' => NULL,
    'type' => NULL,
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
    'region_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'count' => 
    array (
      'dbtype' => 'int',
      'precision' => '6',
      'phptype' => 'integer',
    ),
    'type' => 
    array (
      'dbtype' => 'int',
      'precision' => '2',
      'phptype' => 'integer',
    ),
  ),
  'aggregates' => 
  array (
    'geoTableLocal' => 
    array (
      'class' => 'geoTableRegions',
      'local' => 'region_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'geoTableFossilsRegionItems' => 
    array (
      'class' => 'geoTableItems',
      'local' => 'item_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);

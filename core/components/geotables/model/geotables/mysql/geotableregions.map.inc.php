<?php
$xpdo_meta_map['geoTableRegions']= array (
  'package' => 'geotables',
  'version' => '1.1',
  'table' => 'geo_table_regions',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => '',
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
  ),
  'composites' => 
  array (
    'geoTableLocal' => 
    array (
      'class' => 'geoTableLocalItem',
      'local' => 'id',
      'foreign' => 'region_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);

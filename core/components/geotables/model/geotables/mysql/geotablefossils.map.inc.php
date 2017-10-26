<?php
$xpdo_meta_map['geoTableFossils']= array (
  'package' => 'geotables',
  'version' => '1.1',
  'table' => 'geo_table_fossils',
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
    'geoTableFossilsItems' => 
    array (
      'class' => 'geoTableItems',
      'local' => 'id',
      'foreign' => 'fossils_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'geoTableFossilsItem' => 
    array (
      'class' => 'geoTableFossilsItem',
      'local' => 'id',
      'foreign' => 'fossils_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);

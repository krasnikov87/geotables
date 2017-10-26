<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var modExtra $modExtra */
/*Параметры*/
$year = $modx->getOption('year', $scriptProperties, date('Y'));
$outerTpl = $modx->getOption('outerTpl', $scriptProperties, 'tpl.geotable.outerTpl');
$regionTpl = $modx->getOption('regionTpl', $scriptProperties, 'tpl.geotable.regionTpl');
$resourceRowTpl = $modx->getOption('resourceRowTpl', $scriptProperties, 'tpl.geotable.resourceRowTpl');
$resourceItemTpl = $modx->getOption('resourceItemTpl', $scriptProperties, 'tpl.geotable.resourceItemTpl');


/*Подключаем класс*/
$modx->getService('geotables', 'geoTables', MODX_CORE_PATH . 'components/geotables/model/geotables/', $scriptProperties);

/*Получаем записи с ресурсами*/
$q = $modx->newQuery('geoTableItems');
$q->select('geoTableItems.id, geoTableFossilsItem.fossils_id, geoTableLocalItem.region_id,   geoTableLocalItem.count, geoTableLocalItem.type, geoTableFossils.name');
$q->leftJoin('geoTableLocalItem', '', 'geoTableItems.id = geoTableLocalItem.item_id');
$q->leftJoin('geoTableFossilsItem', '', 'geoTableItems.id = geoTableFossilsItem.item_id');
$q->leftJoin('geoTableFossils', '', 'geoTableFossilsItem.fossils_id = geoTableFossils.id');

$q->where(['geoTableItems.year'=>$year]);

$q->sortby('geoTableFossilsItem.fossils_id', 'ASC');
$q->sortby('geoTableLocalItem.region_id', 'ASC');
$q->prepare();
$q->stmt->execute();
$res = $q->stmt->fetchAll(PDO::FETCH_ASSOC);

$regions = [];
$resources = [];
foreach ($res as $item){
    /*Формируем имя ресурса*/
    /*Добавляем к имени имя текущего ресурса если такого имени еще нет*/
    if(!$resources[$item['id']]['fossils_ids']) $resources[$item['id']]['fossils_ids']=[];
    if ( !in_array($item['fossils_id'], $resources[$item['id']]['fossils_ids'])) {
        $resources[$item['id']]['fossils_ids'][]=$item['fossils_id'];
        $resources[$item['id']]['name'] = empty($resources[$item['id']]['name'])? $item['name'] : $resources[$item['id']]['name']. ', ' .$item['name'];
    }

    /*Формируем список id регионов для запроса*/
    if(!in_array($item['region_id'], $regions)) $regions[] = $item['region_id'];

    /*Формируем правельный массив для вывода информации*/
    $resources[$item['id']][$item['region_id']][$item['type']]['count'] = $item['count'];
}

/*Получаем список необходимых регионов*/
$q = $modx->newQuery('geoTableRegions');
$q->select('geoTableRegions.*');
$q->where(['id:IN'=>$regions]);
$q->sortby('id', 'ASC');
$regions = $modx->getCollection('geoTableRegions', $q);

/*Формируем необходимый масив регионов*/
foreach($regions as $region){
    $nameRegion[] = [
        'id'=> $region->get('id'),
        'name' => $region->get('name'),
    ];
}

/*Плейсхолдеры outerTpl*/
$count = count($nameRegion);
$regionName = '';


/*Название регионов в таблице*/
foreach ($nameRegion as $region){
    $regionName .=  $modx->getChunk($regionTpl, $region);
}



$idx = 0;
//Формирование представления
$counts = [
    'type1'=>[],
    'type2'=>[],
    'total'=>[],
];
foreach ($resources as $resource){
    $resourceCount = '';
    $total1 = 0;
    $total2 = 0;
    foreach ($nameRegion as $name){
        //Вывод количества в регионе
        $type1 = isset($resource[$name['id']][1]) && isset($resource[$name['id']]) ? $resource[$name['id']][1]['count']: '';
        $type2 = isset($resource[$name['id']][2]) && isset($resource[$name['id']]) ? $resource[$name['id']][2]['count']: '';


        //Сумирование
        $counts['type1'][$name['id']] += $resource[$name['id']][1]['count'];
        $counts['type1']['total'] += $resource[$name['id']][1]['count'];
        $counts['type2'][$name['id']] += $resource[$name['id']][2]['count'];
        $counts['type2']['total'] += $resource[$name['id']][2]['count'];
        $counts['total'][$name['id']] += $resource[$name['id']][2]['count']+$resource[$name['id']][1]['count'];
        $counts['total']['total'] += $resource[$name['id']][2]['count']+$resource[$name['id']][1]['count'];

        $total1 += $type1;
        $total2 += $type2;
        $resourceCount .= $modx->getChunk($resourceItemTpl, [
            'type1'=> $type1,
            'type2'=> $type2
        ]);
    }
    //Вывод региона
    $itemRow .= $modx->getChunk($resourceRowTpl, [
        'resource'      => $resourceCount,
        'idx'           => ++$idx,
        'resourceName'  => $resource['name'],
        'total'         => $modx->getChunk($resourceItemTpl, [
            'type1'=> $total1 == 0 ? '' : $total1,
            'type2'=> $total2 == 0 ? '' : $total2
        ]),
    ]);


}
/*Итоги*/

foreach ($nameRegion as $name){

    //Разведка
    $resourceCountType1 .= $modx->getChunk($resourceItemTpl, [
        'type1'=> isset($counts['type1'][$name['id']]) && $counts['type1'][$name['id']] > 0 ? $counts['type1'][$name['id']] : 0,
    ]);

    //Добыча
    $resourceCountType2 .= $modx->getChunk($resourceItemTpl, [
        'type2'=> isset($counts['type2'][$name['id']]) && $counts['type2'][$name['id']] > 0 ? $counts['type2'][$name['id']] : 0,
    ]);

    //Всего
    $resourceCountTypeTotal .= $modx->getChunk($resourceItemTpl, [
        'type1'=> isset($counts['total'][$name['id']]) && $counts['total'][$name['id']] > 0 ? $counts['total'][$name['id']] : 0,
    ]);

}

/*Формирование строк итогов*/
$itemRow .= $modx->getChunk($resourceRowTpl, [
    'resource'      => $resourceCountType1,
    'idx'           => '',
    'resourceName'  => 'Разведка',
    'total'         => $modx->getChunk($resourceItemTpl, [
        'type1'=> isset($counts['type1']['total']) && $counts['type1']['total'] > 0 ? $counts['type1']['total'] : 0,
    ]),
]);


$itemRow .= $modx->getChunk($resourceRowTpl, [
    'resource'      => $resourceCountType2,
    'idx'           => '',
    'resourceName'  => 'Добыча',
    'total'         => $modx->getChunk($resourceItemTpl, [
        'type2'=> isset($counts['type2']['total']) && $counts['type2']['total'] > 0 ? $counts['type2']['total'] : 0,
    ]),
]);


$itemRow .= $modx->getChunk($resourceRowTpl, [
    'resource'      => $resourceCountTypeTotal,
    'idx'           => '',
    'resourceName'  => 'Итого',
    'total'         => $modx->getChunk($resourceItemTpl, [
        'type1'=> isset($counts['total']['total']) && $counts['total']['total'] > 0 ? $counts['total']['total'] : 0,
    ]),
]);



//Вывод всей таблицы
$output = $modx->getChunk($outerTpl, [
    'count' => $count,
    'regionName' => $regionName,
    'resources'  =>$itemRow,
]);



return $output;
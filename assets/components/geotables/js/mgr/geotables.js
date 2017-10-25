var geoTables = function (config) {
    config = config || {};
    geoTables.superclass.constructor.call(this, config);
};
Ext.extend(geoTables, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('geotables', geoTables);

geoTables = new geoTables();
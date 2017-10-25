geoTables.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'geotables-panel-home',
            renderTo: 'geotables-panel-home-div'
        }]
    });
    geoTables.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(geoTables.page.Home, MODx.Component);
Ext.reg('geotables-page-home', geoTables.page.Home);
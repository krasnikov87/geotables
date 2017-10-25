geoTables.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'modextra-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('geotables') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('geotables'),
                layout: 'anchor',
                items: [{
                    xtype: 'geotables-grid-items',
                    cls: 'main-wrapper',
                }]
            },{
                title:_('geotables_fossils'),
                layout: 'anchor',
                items: [{
                    xtype: 'geotables-grid-fossils-items',
                    cls: 'main-wrapper',
                }]
            },{
                title: _('geotables_locate'),
                layout: 'anchor',
                items: [{
                    xtype: 'geotables-grid-locate-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    geoTables.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(geoTables.panel.Home, MODx.Panel);
Ext.reg('geotables-panel-home', geoTables.panel.Home);

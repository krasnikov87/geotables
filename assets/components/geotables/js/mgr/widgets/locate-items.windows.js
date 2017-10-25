geoTables.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'geotables-locate-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('geotables_locate_item_create'),
        width: 550,
        autoHeight: true,
        url: geoTables.config.connector_url,
        action: 'mgr/locate/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    geoTables.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(geoTables.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('geotables_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('geotables-locate-window-create', geoTables.window.CreateItem);


geoTables.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'geotables-locate-window-update';
    }
    Ext.applyIf(config, {
        title: _('geotables_item_update'),
        width: 550,
        autoHeight: true,
        url: geoTables.config.connector_url,
        action: 'mgr/locate/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    geoTables.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(geoTables.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('geotables_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('geotables-locate-window-update', geoTables.window.UpdateItem);
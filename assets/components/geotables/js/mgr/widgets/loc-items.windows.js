geoTables.window.locItemsCreate = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'geotables-loc-items-window-create';
    }
    Ext.applyIf(config, {
        title: _('geotables_fossils_item_create'),
        width: 550,
        autoHeight: true,
        url: geoTables.config.connector_url,
        action: 'mgr/itemlocate/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }],
        success: function () {
            Ext.getCmp('addon-grid-addoncategory').refresh();
        }
    });
    geoTables.window.locItemsCreate.superclass.constructor.call(this, config);
};
Ext.extend(geoTables.window.locItemsCreate, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'item_id',
            id: config.id + 'item_id',
            value: config.value,
        }, {
            xtype: 'geotable-combo-item-locate',
            fieldLabel: _('geotables_item_region_name'),
            name: 'region_id',
            id: config.id + '-region_id',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            name: 'count',
            id: config.id+'-id',
            fieldLabel: _('geotables_item_region_count'),
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'geotable-combo-item-types',
            name: 'type',
            id: config.id + 'type',
            fieldLabel: _('geotables_item_region_type'),
            allowBlank: false,
            value: config.value ? config.value : 1,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('geotables-loc-items-window-create', geoTables.window.locItemsCreate);


geoTables.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'geotables-fossils-window-update';
    }
    Ext.applyIf(config, {
        title: _('geotables_item_update'),
        width: 550,
        autoHeight: true,
        url: geoTables.config.connector_url,
        action: 'mgr/itemlocate/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }],
        success: function () {
            Ext.getCmp('addon-grid-addoncategory').refresh();
        }
    });
    geoTables.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(geoTables.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + 'id',
        }, {
            xtype: 'hidden',
            name: 'item_id',
            id: config.id + 'item_id',
            value: config.value,
        }, {
            xtype: 'geotable-combo-item-locate',
            fieldLabel: _('geotables_item_region_name'),
            name: 'region_id',
            id: config.id + '-region_id',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            name: 'count',
            id: config.id+'-id',
            fieldLabel: _('geotables_item_region_count'),
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'geotable-combo-item-types',
            name: 'type',
            id: config.id + 'type',
            fieldLabel: _('geotables_item_region_type'),
            allowBlank: false,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('geotables-loc-items-window-update', geoTables.window.UpdateItem);
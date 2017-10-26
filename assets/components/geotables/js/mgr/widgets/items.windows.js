geoTables.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'geotables-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('geotables_item_create'),
        width: 500,
        autoHeight: true,
        url: geoTables.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }],

        success: function (v1, v2, v3) {

            var res = JSON.parse(v2.response.responseText);

            MODx.Ajax.request({
                url: this.config.url,
                params: {
                    action: 'mgr/item/get',
                    id: res.object.id
                },
                listeners: {
                    success: {
                        fn: function (r) {
                            var w = Ext.getCmp('geotables-item-window-update');
                            if(w){
                                w.close();
                            }
                            w = MODx.load({
                                xtype: 'geotables-item-window-update',
                                id: 'geotables-item-window-update',
                                record: r,
                                listeners: {
                                    success: {
                                        fn: function () {
                                            Ext.getCmp('geotables-grid-items').refresh();
                                        }, scope: this
                                    }
                                }
                            });
                            w.reset();
                            w.setValues(r.object);
                            w.show(Ext.getBody());
                        }, scope: this
                    }
                }
            });
        }

    });
    geoTables.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(geoTables.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            html: '<div class="x-panel panel-desc">'+_('geotables_save_desc')+'</div>'
            ,bodyCssClass: 'panel-desc'
            ,border: false
            ,cls: ''
        }, {
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'geotable-combo-fossils',
            fieldLabel: _('geotables_item_fossils'),
            id: config.id + '-fossils',
            name: 'fossils_id',
            allowBlank: false,
        }, {
            xtype: 'geotable-combo-items-year',
            name: 'year',
            id: config.id + 'year',
            fieldLabel: _('geotables_item_year'),
            allowBlank: false,
            listeners:{
                afterrender:function () {
                    this.setValue(new Date().format('Y'))
                }
            },
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('geotables-item-window-create', geoTables.window.CreateItem);


geoTables.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'geotables-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('geotables_item_update'),
        width: 700,
        autoHeight: true,
        url: geoTables.config.connector_url,
        action: 'mgr/item/update',
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
            xtype: 'geotable-combo-fossils',
            fieldLabel: _('geotables_item_fossils'),
            id: config.id + '-fossils',
            name: 'fossils_id',
            allowBlank: false,
            value: config.record && config.record.object ? config.record.object.fossils_id : ''
        }, {
            xtype: 'geotable-combo-items-year',
            name: 'year',
            id: config.id + 'year',
            fieldLabel: _('geotables_item_year'),
            allowBlank: false,
        }, {
            xtype: (config.record) ? 'geotable-grid-loc-items' : 'hidden'
            ,item_id: (config.record) ? config.record.object.id : 0
            ,fieldLabel: _('geotables_item_regions')
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('geotables-item-window-update', geoTables.window.UpdateItem);


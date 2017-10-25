geoTables.grid.LocItems = function(config) {
    config = config || {};
    Ext.applyIf(config,{
         id: 'addon-grid-addoncategory'
        ,url: geoTables.config.connectorUrl
        ,baseParams: { action: 'mgr/itemlocate/getList', item_id: config.item_id || 0 } /* pass the id from the window to the grid to fill */
        ,tbar: [{
            xtype: 'button',
            text: _('geotables_add_region'),
            handler: function() {
                var w = Ext.getCmp('geotables-loc-items-window-create');
                if(w){
                    w.close();
                }
                win = new geoTables.window.locItemsCreate({
                    record: { item_id: config.item_id},
                    win: this.id
                });
                win.show();
            }
        }]
        ,viewConfig: {
            forceFit: true,
            enableRowBody: true
        }
        ,fields: ['id','item_id','region_id', 'count', 'type', 'actions']
        ,paging: true
        ,remoteSort: true
        ,columns: [{
            header: 'id'
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 100
            ,hidden: true
        },{
            header: _('geotables_item_region_name')
            ,dataIndex: 'region_id'
            ,sortable: true
            ,width: 100
            ,hidden: false
        },{
            header: _('geotables_item_region_count')
            ,dataIndex: 'count'
            ,sortable: true
            ,width: 100
            ,hidden: false
        },{
            header: _('geotables_item_region_type')
            ,dataIndex: 'type'
            ,sortable: true
            ,width: 100
            ,hidden: false
        },{
            header: _('geotables_grid_actions'),
            dataIndex: 'actions',
            renderer: geoTables.utils.renderActions,
            sortable: false,
            width: 50,
            id: 'actions'
        }]


    });
    geoTables.grid.LocItems.superclass.constructor.call(this,config);
};
Ext.extend(geoTables.grid.LocItems,MODx.grid.Grid, {
    windows: {},

    updateItem: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/itemlocate/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = Ext.getCmp('geotables-loc-items-window-update');
                        if(w){
                            w.close();
                        }
                        w = MODx.load({
                            xtype: 'geotables-loc-items-window-update',
                            id: 'geotables-loc-items-window-update',
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    removeItem: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('geotables_items_remove')
                : _('geotables_item_remove'),
            text: ids.length > 1
                ? _('geotables_items_remove_confirm')
                : _('geotables_item_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/itemlocate/remove',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },


    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = geoTables.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },
});
Ext.reg('geotable-grid-loc-items',geoTables.grid.LocItems);
geoTables.combo.Search = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        xtype: 'twintrigger',
        ctCls: 'x-field-search',
        allowBlank: true,
        msgTarget: 'under',
        emptyText: _('search'),
        name: 'query',
        triggerAction: 'all',
        clearBtnCls: 'x-field-search-clear',
        searchBtnCls: 'x-field-search-go',
        onTrigger1Click: this._triggerSearch,
        onTrigger2Click: this._triggerClear,
    });
    geoTables.combo.Search.superclass.constructor.call(this, config);
    this.on('render', function () {
        this.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
            this._triggerSearch();
        }, this);
    });
    this.addEvents('clear', 'search');
};
Ext.extend(geoTables.combo.Search, Ext.form.TwinTriggerField, {

    initComponent: function () {
        Ext.form.TwinTriggerField.superclass.initComponent.call(this);
        this.triggerConfig = {
            tag: 'span',
            cls: 'x-field-search-btns',
            cn: [
                {tag: 'div', cls: 'x-form-trigger ' + this.searchBtnCls},
                {tag: 'div', cls: 'x-form-trigger ' + this.clearBtnCls}
            ]
        };
    },

    _triggerSearch: function () {
        this.fireEvent('search', this);
    },

    _triggerClear: function () {
        this.fireEvent('clear', this);
    },

});
Ext.reg('geotables-combo-search', geoTables.combo.Search);
Ext.reg('geotables-field-search', geoTables.combo.Search);



geoTables.combo.Fossils = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        hiddenName: config.name +'[]'
        , name: config.name +'[]'
        , fields: ['name', 'id']
        , mode: 'remote'
        , displayField: 'name'
        , valueField: 'id'
        , editable: true
        , allowAddNewData: true
        , addNewDataOnBlur: true
        , triggerAction: 'all'
        , extraItemCls: 'x-tag'
        , expandBtnCls: 'x-form-trigger'
        , clearBtnCls: 'x-form-trigger'

        , renderTo: Ext.getBody()
        , listeners: {
            newitem: function (bs, v) {
                bs.addNewItem({value: v});
            },
            beforerender:function(obj){
                if(obj.value && obj.value.length > 0){
                    var val = [];
                    for(var i = 0 ;i<obj.value.length;i++){
                        val.push(obj.value[i]);

                    }
                    val = val.join('|');
                    obj.setValue(val);

                }
            }

        }
        , store: new Ext.data.JsonStore({
            id: 0,
            root: 'results',
            autoLoad: false,
            autoSave: false,
            totalProperty: 'total',
            fields: ['name', 'id'],
            url: geoTables.config.connector_url,
            baseParams: {
                action: config.action || 'mgr/fossils/getlist',
                key: config.name,
                load:true,
            }
        })
    });

    geoTables.combo.Fossils.superclass.constructor.call(this, config);
    config.name+='[]';
    this.getStore().on('load',function(obj){
        obj.baseParams.load = '';
    });
};
Ext.extend(geoTables.combo.Fossils, Ext.ux.form.SuperBoxSelect);
Ext.reg('geotable-combo-fossils', geoTables.combo.Fossils);


geoTables.combo.itemLocate = function (config) {
    config = config || {};
    Ext.apply(config, {
        name: 'name',
        id: config.id + '-name',
        hiddenName: config.name,
        displayField:'name',
        valueField: 'id',
        anchor: '99%',
        fields: ['id', 'name'],
        pagesize: 20,
        typeAhed:false,
        editable:true,
        allowBlank:false,
        url:geoTables.config.connector_url,
        baseParams: {
            action: 'mgr/locate/getlist',
        }
    });
    geoTables.combo.itemLocate.superclass.constructor.call(this, config);
};

Ext.extend(geoTables.combo.itemLocate, MODx.combo.ComboBox);
Ext.reg('geotable-combo-item-locate', geoTables.combo.itemLocate);

geoTables.combo.itemLocate = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        xtype:'combobox',
        hiddenName: config.name,
        store: new Ext.data.ArrayStore({

            id: 0
            ,fields: ['value','display']
            ,data: [
                    [1,_('geotables_item_region_type_main')],
                    [2,_('geotables_item_region_type_extraction')],
                ]
            })
        ,mode: 'local'
        ,displayField: 'display'
        ,valueField: 'value'
    });
    geoTables.combo.itemLocate.superclass.constructor.call(this,config);
};
Ext.extend(geoTables.combo.itemLocate,MODx.combo.ComboBox);
Ext.reg('geotable-combo-item-types',geoTables.combo.itemLocate);

geoTables.combo.year = function(config) {
    var years = [];
    for (var i = 2014; i < Number(new Date().format('Y')) + 3; i++){
        var year = [i, i]
        years.push(year);
    }
    config = config || {};
    Ext.applyIf(config,{
        xtype:'combobox',
        hiddenName: config.name,
        store: new Ext.data.ArrayStore({

            id: 0
            ,fields: ['value','display']
            ,data: years
        })
        ,mode: 'local'
        ,displayField: 'value'
        ,valueField: 'value'
    });
    geoTables.combo.year.superclass.constructor.call(this,config);
};
Ext.extend(geoTables.combo.year,MODx.combo.ComboBox);
Ext.reg('geotable-combo-items-year',geoTables.combo.year);
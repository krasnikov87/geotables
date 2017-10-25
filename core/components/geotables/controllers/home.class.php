<?php

/**
 * The home manager controller for geoTables.
 *
 */
class geoTablesHomeManagerController extends modExtraManagerController
{
    /** @var geoTables $geoTables */
    public $geoTables;


    /**
     *
     */
    public function initialize()
    {
        $path = $this->modx->getOption('geotables_core_path', null,
                $this->modx->getOption('core_path') . 'components/geotables/') . 'model/geotables/';
        $this->geoTables = $this->modx->getService('geotables', 'geoTables', $path);
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('geotables:default');
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('geotables');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->geoTables->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->geoTables->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/geotables.js');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/widgets/locate-items.grid.js');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/widgets/fossils-items.grid.js');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/widgets/fossils-items.windows.js');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/widgets/locate-items.windows.js');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/widgets/loc-items.grid.js');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/widgets/loc-items.windows.js');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->geoTables->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        geoTables.config = ' . json_encode($this->geoTables->config) . ';
        geoTables.config.connector_url = "' . $this->geoTables->config['connectorUrl'] . '";
        Ext.onReady(function() {
            MODx.load({ xtype: "geotables-page-home"});
        });
        </script>
        ');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->geoTables->config['templatesPath'] . 'home.tpl';
    }
}
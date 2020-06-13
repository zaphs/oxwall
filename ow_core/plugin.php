<?php

/**
 * EXHIBIT A. Common Public Attribution License Version 1.0
 * The contents of this file are subject to the Common Public Attribution License Version 1.0 (the “License”);
 * you may not use this file except in compliance with the License. You may obtain a copy of the License at
 * http://www.oxwall.org/license. The License is based on the Mozilla Public License Version 1.1
 * but Sections 14 and 15 have been added to cover use of software over a computer network and provide for
 * limited attribution for the Original Developer. In addition, Exhibit A has been modified to be consistent
 * with Exhibit B. Software distributed under the License is distributed on an “AS IS” basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for the specific language
 * governing rights and limitations under the License. The Original Code is Oxwall software.
 * The Initial Developer of the Original Code is Oxwall Foundation (http://www.oxwall.org/foundation).
 * All portions of the code written by Oxwall Foundation are Copyright (c) 2011. All Rights Reserved.

 * EXHIBIT B. Attribution Information
 * Attribution Copyright Notice: Copyright 2011 Oxwall Foundation. All rights reserved.
 * Attribution Phrase (not exceeding 10 words): Powered by Oxwall community software
 * Attribution URL: http://www.oxwall.org/
 * Graphic Image as provided in the Covered Code.
 * Display of Attribution Information is required in Larger Works which are defined in the CPAL as a work
 * which combines Covered Code or portions thereof with code not governed by the terms of the CPAL.
 */

/**
 * Base plugin object.
 *
 * @author Sardar Madumarov <madumarov@gmail.com>
 * @package ow_core
 * @since 1.0
 */
class OW_Plugin
{
    /**
     * Plugin dir/module name.
     *
     * @var string
     */
    protected $dirName;

    /**
     * Plugin unique key.
     *
     * @var string
     */
    protected $key;

    /**
     * @var boolean
     */
    protected $active;

    /**
     * @var BOL_Plugin
     */
    protected $dto;

    /**
     * Constructor.
     *
     * @param BOL_Plugin $plugin
     */
    public function __construct( BOL_Plugin $plugin )
    {
        $this->dirName = trim($plugin->getModule());
        $this->key = trim($plugin->getKey());
        $this->active = (bool) $plugin->isActive;
        $this->dto = $plugin;
    }

    /**
     * Returns plugin dir/module name.
     *
     * @return string
     */
    public function getDirName()
    {
        return $this->dirName;
    }

    /**
     * Returns plugin unique key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Checks if plugin is active.
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Returns plugin data transfer object.
     *
     * @return BOL_Plugin
     */
    public function getDto()
    {
        return $this->dto;
    }

    /**
     * @return string
     */
    public function getUserFilesDir()
    {
        return OW_DIR_PLUGIN_USERFILES . $this->getDirName() . DS;
    }

    /**
     * @return string
     */
    public function getInnerUserFilesDir()
    {
        return $this->getRootDir() . "userfiles" . DS;
    }

    /**
     * @return string
     */
    public function getUserFilesUrl()
    {
        return OW_URL_PLUGIN_USERFILES . $this->getDirName() . "/";
    }

    /**
     * @return string
     */
    public function getPluginFilesDir()
    {
        return OW_DIR_PLUGINFILES . $this->getDirName() . DS;
    }

    /**
     * @return string
     */
    public function getInnerPluginFilesDir()
    {
        return $this->getRootDir() . "pluginfiles" . DS;
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return ($this->dto->isSystem() ? OW_DIR_SYSTEM_PLUGIN : OW_DIR_PLUGIN) . $this->getDirName() . DS;
    }

    /**
     * @return string
     */
    public function getCliDir()
    {
        return $this->getRootDir() . "cli" . DS;
    }

    /**
     * @return string
     */
    public function getMobileDir()
    {
        return $this->getRootDir() . "mobile" . DS;
    }

    /**
     * @return string
     */
    public function getCmpDir()
    {
        return $this->getRootDir() . "components" . DS;
    }

    /**
     * @return string
     */
    public function getMobileCmpDir()
    {
        return $this->getMobileDir() . "components" . DS;
    }

    /**
     * @return string
     */
    public function getViewDir()
    {
        return $this->getRootDir() . "views" . DS;
    }

    /**
     * @return string
     */
    public function getMobileViewDir()
    {
        return $this->getMobileDir() . "views" . DS;
    }

    /**
     * @return string
     */
    public function getCmpViewDir()
    {
        return $this->getViewDir() . "components" . DS;
    }

    /**
     * @return string
     */
    public function getMobileCmpViewDir()
    {
        return $this->getMobileViewDir() . "components" . DS;
    }

    /**
     * @return string
     */
    public function getCtrlViewDir()
    {
        return $this->getViewDir() . "controllers" . DS;
    }

    /**
     * @return string
     */
    public function getMobileCtrlViewDir()
    {
        return $this->getMobileViewDir() . "controllers" . DS;
    }

    /**
     * @return string
     */
    public function getCtrlDir()
    {
        return $this->getRootDir() . "controllers" . DS;
    }

    /**
     * @return string
     */
    public function getMobileCtrlDir()
    {
        return $this->getMobileDir() . "controllers" . DS;
    }

    /**
     * @return string
     */
    public function getDecoratorDir()
    {
        return $this->getRootDir() . "decorators" . DS;
    }

    /**
     * @return string
     */
    public function getMobileDecoratorDir()
    {
        return $this->getMobileDir() . "decorators" . DS;
    }

    /**
     * @return string
     */
    public function getStaticDir()
    {
        return $this->getRootDir() . "static" . DS;
    }

    /**
     * @return string
     */
    public function getPublicStaticDir()
    {
        return OW_DIR_STATIC_PLUGIN . $this->getModuleName() . DS;
    }

    /**
     * @return string
     */
    public function getBolDir()
    {
        return $this->getRootDir() . "bol" . DS;
    }

    /**
     * @return string
     */
    public function getMobileBolDir()
    {
        return $this->getMobileDir() . "bol" . DS;
    }

    /**
     * @return string
     */
    public function getClassesDir()
    {
        return $this->getRootDir() . "classes" . DS;
    }

    /**
     * @return string
     */
    public function getMobileClassesDir()
    {
        return $this->getMobileDir() . "classes" . DS;
    }

    /**
     * @return string
     */
    public function getStaticJsDir()
    {
        return $this->getStaticDir() . "js" . DS;
    }

    /**
     * @return string
     */
    public function getModuleName()
    {
        return $this->dirName;
    }

    /**
     * @return string
     */
    public function getStaticUrl()
    {
        return OW_URL_STATIC_PLUGINS . $this->getModuleName() . "/";
    }

    /**
     * @return string
     */
    public function getStaticJsUrl()
    {
        return $this->getStaticUrl() . "js/";
    }

    /**
     * @return string
     */
    public function getStaticCssUrl()
    {
        return $this->getStaticUrl() . "css/";
    }

    /**
     * @return string
     */
    public function getApiDir()
    {
        return $this->getRootDir() . "api" . DS;
    }

    /**
     * @return string
     */
    public function getApiBolDir()
    {
        return $this->getApiDir() . "bol" . DS;
    }

    /**
     * @return string
     */
    public function getApiCtrlDir()
    {
        return $this->getApiDir() . "controllers" . DS;
    }

    /**
     * @return string
     */
    public function getApiClassesDir()
    {
        return $this->getApiDir() . "classes" . DS;
    }
}

<?php
declare(strict_types=1);

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
 * The class works with config system.
 *
 * @author  Sardar Madumarov <madumarov@gmail.com>
 * @package ow_core
 * @method static OW_Config getInstance()
 * @since   1.0
 */
class OW_Config
{
    use OW_Singleton;

    /**
     * @var BOL_ConfigService
     */
    private $configService;

    /**
     * @var array
     */
    private $cachedConfigs;

    /**
     * Constructor.
     */
    private function __construct()
    {
        $this->configService = BOL_ConfigService::getInstance();

        $this->generateCache();
    }

    public function generateCache(): void
    {
        $configs = $this->configService->findAllConfigs();

        $this->cachedConfigs = [];

        /* @var BOL_Config $config */
        foreach ($configs as $config) {
            if (!isset($this->cachedConfigs[$config->getKey()])) {
                $this->cachedConfigs[$config->getKey()] = [];
            }

            $this->cachedConfigs[$config->getKey()][$config->getName()] = $config->getValue();
        }
    }

    /**
     * Returns config value for provided plugin key and config name.
     *
     * @param string $key
     * @param string $name
     * @return string|null
     */
    public function getValue(string $key, string $name): ?string
    {
        return $this->cachedConfigs[$key][$name] ?? null;
    }

    /**
     * Returns all config values for plugin key.
     *
     * @param string $key
     * @return array
     */
    public function getValues(string $key): array
    {
        return $this->cachedConfigs[$key] ?? [];
    }

    /**
     * Adds plugin config.
     *
     * @param string $key
     * @param string $name
     * @param mixed  $value
     * @param string $description
     */
    public function addConfig(string $key, string $name, $value, string $description = null): void
    {
        $this->configService->addConfig($key, $name, $value, $description);
        $this->generateCache();
    }

    /**
     * Deletes config by provided plugin key and config name.
     *
     * @param string $key
     * @param string $name
     */
    public function deleteConfig(string $key, string $name): void
    {
        $this->configService->removeConfig($key, $name);
        $this->generateCache();
    }

    /**
     * Removes all plugin configs.
     *
     * @param string $key
     */
    public function deletePluginConfigs(string $key): void
    {
        $this->configService->removePluginConfigs($key);
    }

    /**
     * Checks if config exists.
     *
     * @param string $key
     * @param string $name
     * @return bool
     */
    public function configExists(string $key, string $name): bool
    {
        return array_key_exists($key, $this->cachedConfigs) && array_key_exists($name, $this->cachedConfigs[$key]);
    }

    /**
     * Updates config value.
     *
     * @param string $key
     * @param string $name
     * @param mixed  $value
     */
    public function saveConfig(string $key, string $name, $value): void
    {
        $this->configService->saveConfig($key, $name, $value);
        $this->generateCache();
    }
}
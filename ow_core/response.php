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
 * @author  Sardar Madumarov <madumarov@gmail.com>
 * @package ow_core
 * @method static OW_Response getInstance()
 * @since   1.0
 */
class OW_Response
{
    /**
     * HTTP Header constants
     */
    public const HD_CACHE_CONTROL   = 'Cache-Control';
    public const HD_CNT_DISPOSITION = 'Content-Disposition';
    public const HD_CNT_LENGTH      = 'Content-Length';
    public const HD_CONNECTION      = 'Connection';
    public const HD_PRAGMA          = 'Pragma';
    public const HD_CNT_TYPE        = 'Content-Type';
    public const HD_EXPIRES         = 'Expires';
    public const HD_LAST_MODIFIED   = 'Last-Modified';
    public const HD_LOCATION        = 'Location';

    use OW_Singleton;

    /**
     * Headers to send with response
     *
     * @var array
     */
    private $headers = [];

    /**
     * Document to send
     *
     * @var OW_Document
     */
    private $document;

    /**
     * Rendered markup
     *
     * @var string
     */
    private $markup = '';

    /**
     * @return OW_Document
     */
    public function getDocument(): OW_Document
    {
        return $this->document;
    }

    /**
     * @param OW_Document $document
     */
    public function setDocument(OW_Document $document): void
    {
        $this->document = $document;
    }

    /**
     * Adds headers to response.
     *
     * @param string $name
     * @param string $value
     */
    public function setHeader(string $name, string $value): void
    {
        $this->headers[trim($name)] = trim($value);
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * Clears all headers.
     */
    public function clearHeaders(): void
    {
        $this->headers = [];
    }

    /**
     * Sends all added headers.
     */
    public function sendHeaders(): void
    {
        if (!headers_sent()) {
            foreach ($this->headers as $headerName => $headerValue) {
                if (mb_strtolower(substr($headerName, 0, 4)) === 'http') {
                    header($headerName . ' ' . $headerValue);
                } elseif (mb_strtolower($headerName) === 'status') {
                    header(ucfirst(mb_strtolower($headerName)) . ': ' . $headerValue, true, (int)$headerValue);
                } else {
                    header($headerName . ':' . $headerValue);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getMarkup(): string
    {
        return $this->markup;
    }

    /**
     * @param string $markup
     */
    public function setMarkup(string $markup): void
    {
        $this->markup = $markup;
    }

    /**
     * Sends generated response
     *
     */
    public function respond(): void
    {
        $event = new OW_Event(OW_EventManager::ON_BEFORE_DOCUMENT_RENDER);
        OW::getEventManager()->trigger($event);
        if ($this->document !== null) {
            $renderedMarkup = $this->document->render();

            $event = new BASE_CLASS_EventCollector('base.append_markup');
            OW::getEventManager()->trigger($event);
            $data         = $event->getData();
            $this->markup = str_replace(OW_Document::APPEND_PLACEHOLDER, PHP_EOL . implode(PHP_EOL, $data), $renderedMarkup);
        }

        $event = new OW_Event(OW_EventManager::ON_AFTER_DOCUMENT_RENDER);
        OW::getEventManager()->trigger($event);

        $this->sendHeaders();

        if (OW::getRequest()->isAjax()) {
            exit();
        }

        if (OW_PROFILER_ENABLE || OW_DEV_MODE) {
            UTIL_Profiler::getInstance()->mark('final');
        }

        if (OW_DEBUG_MODE) {
            echo ob_get_clean();
        }

        echo $this->markup;

        $event = new OW_Event('core.exit');
        OW::getEventManager()->trigger($event);
    }
}

<?php
/***************************************************************
 *  Copyright notice
 *  (c) 2013 Georg Ringer <typo3@ringerge.org>
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


namespace GeorgRinger\Newsmostread\Ajax;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Dbal\Database\DatabaseConnection;

/**
 * Count hit of tracking pixel
 *
 * @package TYPO3
 * @subpackage tx_newsmostread
 */
class Eid
{

    protected $configuration = [];

    const LOG_TABLE = 'tx_newsmostread_log';
    const TYPE_GIF = 0;
    const TYPE_PNG = 1;
    const DAYS_CONSIDERED_FOR_VOTE = 35;

    /**
     * pixels
     */
    const PIXEL_GIF = "R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";
    const PIXEL_PNG =
        "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAAZiS0dEAP8A/wD/
		oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9wHDhciLQDTcncAAAAZdEVYdENvbW1lbnQA
		Q3JlYXRlZCB3aXRoIEdJTVBXgQ4XAAAADUlEQVQI12NgYGBgAAAABQABXvMqOgAAAABJRU5ErkJggg==";

    /** @var DatabaseConnection */
    protected $db;
    /** @var integer */
    protected $newsUid;

    public function __construct()
    {
        $this->db = $GLOBALS['TYPO3_DB'];
        $this->newsUid = (int)GeneralUtility::_GET('uid');
        $this->type == ((int)GeneralUtility::_GET('png') === self::TYPE_PNG ? self::TYPE_PNG : self::TYPE_GIF);

        $this->configuration = (array)unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['newsmostread']);
    }

    /**
     * Check if the combination IP + newsid has already be logged,
     * if not, count the hit
     *
     * @return void
     */
    public function count()
    {
        if ($this->newsUid === 0) {
            return;
        }

        $ip = GeneralUtility::getIndpEnv('REMOTE_ADDR');

        $count = null;
        if ((int)$this->configuration['daysForNextVoting'] === 0) {
            $count = 0;
        } else {
            $where = 'ip="' . $this->db->quoteStr($ip,
                    self::LOG_TABLE) . '" AND news=' . $this->newsUid . ' AND log_date >="' . $this->getAllowedTimeFrame() . '"';
            $count = $this->db->exec_SELECTcountRows('*', self::LOG_TABLE, $where);
        }

        if ($count === 0) {
            $this->db->exec_INSERTquery(self::LOG_TABLE, array(
                'ip' => $ip,
                'news' => $this->newsUid,
                'log_date' => $this->getCurrentDate()
            ));

            $maxTimeFrame = $GLOBALS['EXEC_TIME'] - (self::DAYS_CONSIDERED_FOR_VOTE * 86400);
            $where = 'tx_newsmostread_enabled=1 AND uid=' . $this->newsUid . ' AND datetime >= ' . $maxTimeFrame;
            $this->db->sql_query('UPDATE tx_news_domain_model_news SET tx_newsmostread_count=tx_newsmostread_count+1 WHERE ' . $where);
        }
    }

    /**
     * Echo the tracking pixel
     *
     * @return void
     */
    public function getPixel()
    {
        $pixel = '';
        $this->setHeaders();

        if (self::TYPE_PNG == $this->type) {
            $pixel = self::PIXEL_PNG;
        } elseif (self::TYPE_GIF == $this->type) {
            $pixel = self::PIXEL_GIF;
        }
        $out = base64_decode($pixel);
        echo $out;
    }

    /**
     * Set correct headers
     *
     * @return void
     */
    protected function setHeaders()
    {
        header('Cache-Control: no-cache, must-revalidate, post-check=0, pre-check=0');

        if (strstr($_SERVER['HTTP_USER_AGENT'], '')) {
            header('P3P: CP="NOI DSP CURa ADMa DEVa TAIa OUR BUS IND UNI COM NAV INT"');
        }

        if (self::TYPE_PNG === $this->type) {
            header('Content-type: image/png');
            header('Content-length: 242');
        } else {
            header('Content-type: image/gif');
            header('Content-length: 60');
        }
    }

    /**
     * Get current date
     *
     * @return string Formatted date
     */
    protected function getCurrentDate()
    {
        return date('Y-m-d', $GLOBALS['EXEC_TIME']);
    }

    /**
     * @return string Formatted date
     */
    protected function getAllowedTimeFrame()
    {
        $time = 86400 * (int)$this->configuration['daysForNextVoting'];
        return date('Y-m-d', $GLOBALS['EXEC_TIME'] - $time);
    }
}

/** @var \GeorgRinger\Newsmostread\Ajax\Eid $instance */
$instance = GeneralUtility::makeInstance('GeorgRinger\Newsmostread\Ajax\Eid');
$instance->count();
$instance->getPixel();
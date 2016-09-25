<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace GeorgRinger\Newsmostread\Task;

use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Cleanup
 */
class CleanupTask extends AbstractTask
{

    /**
     * Execute cleanup task
     *
     * @return boole
     */
    public function execute()
    {
        $status = true;

        $where = 'log_date <"' . $this->getAllowedTimeFrame() . '"';
        $GLOBALS['TYPO3_DB']->exec_DELETEquery('tx_newsmostread_log', $where);

        return $status;
    }

    /**
     * @return string Formatted date
     */
    protected function getAllowedTimeFrame()
    {
        $configuration = (array)unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['newsmostread']);

        $time = 86400 * ((int)$configuration['daysForNextVoting'] + 1);
        return date('Y-m-d', $GLOBALS['EXEC_TIME'] - $time);
    }

}
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
 * Reset
 */
class ResetCountTask extends AbstractTask
{

    /**
     * Execute reset count task
     *
     * @return boole
     */
    public function execute()
    {
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_newsmostread_log', '1=1', array('tx_newsmostread_count' => 0));

        return true;
    }

}
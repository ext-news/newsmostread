<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// eID script for the ajax request
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['tx_newsmostread'] =
    'EXT:newsmostread/Classes/Ajax/Eid.php';

// CleanupTask
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['GeorgRinger\\Newsmostread\\Task\\CleanupTask'] = array(
    'extension' => $_EXTKEY,
    'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xml:cleanupTask.name',
    'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xml:cleanupTask.description'
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['GeorgRinger\\Newsmostread\\Task\\ResetCountTask'] = array(
    'extension' => $_EXTKEY,
    'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xml:resetCountTask.name',
    'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xml:resetCountTask.description'
);

$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['classes']['Domain/Model/News'][] = $_EXTKEY;
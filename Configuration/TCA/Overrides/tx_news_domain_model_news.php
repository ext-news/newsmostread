<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$tempColumns = [
    'tx_newsmostread_count' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:newsmostread/Resources/Private/Language/locallang_db.xml:tx_news_domain_model_news.tx_newsmostread_count',
        'config' => [
            'type' => 'input',
            'size' => 5,
            'max' => 20,
            'default' => 0,
        ]
    ],
    'tx_newsmostread_enabled' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:newsmostread/Resources/Private/Language/locallang_db.xml:tx_news_domain_model_news.tx_newsmostread_enabled',
        'config' => [
            'type' => 'check',
            'default' => 1,
        ]
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news', $tempColumns, true);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_news_domain_model_news',
    'tx_newsmostread_enabled,tx_newsmostread_count');


$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['orderByNews'] .= ',tx_newsmostread_count';


/***************
 * Default TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('newsmostread', 'Configuration/TypoScript', 'News Most read');
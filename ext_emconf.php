<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Most read news',
    'description' => 'Count how often a news item is read',
    'category' => 'fe',
    'author' => 'Georg Ringer',
    'author_email' => 'typo3@ringerge.org',
    'shy' => '',
    'dependencies' => 'news',
    'conflicts' => '',
    'priority' => '',
    'module' => '',
    'state' => 'beta',
    'internal' => '',
    'uploadfolder' => 0,
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'author_company' => '',
    'version' => '2.0.0',
    'constraints' => array(
        'depends' => array(
            'news' => '4.1.0-4.9.99',
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
    'suggests' => array(),
);
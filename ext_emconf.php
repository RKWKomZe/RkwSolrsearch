<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "rkw_solrsearch"
 *
 * Auto generated by Extension Builder 2023-07-04
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'RKW Solrsearch',
    'description' => 'Extension for website search. Primarily for TYPO3 SOLR.',
    'category' => 'plugin',
    'author' => 'Maximilian Fäßler, Christian Dilger',
    'author_email' => 'maximilian@faesslerweb.de, c.dilger@addorange.de',
    'state' => 'beta',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '10.4.3',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
            'solr' => '11.0.7',
            'rkw_events' => '10.4.0-10.4.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

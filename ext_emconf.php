<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "searchmaster"
 *
 * Auto generated by Extension Builder 2023-07-04
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'Searchmaster',
    'description' => 'Extension for website search. Primarily for TYPO3 SOLR.',
    'category' => 'plugin',
    'author' => 'Maximilian Fäßler',
    'author_email' => 'maximilian@faesslerweb.de',
    'state' => 'alpha',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '9.5.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
            'solr' => '11.0.7'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

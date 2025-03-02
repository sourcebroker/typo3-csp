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

$EM_CONF[$_EXTKEY] = [
  'title' => 'CSP: Content Security Policy',
  'description' => 'Generates the Content-Security-Policy response header based on the content of the page',
  'category' => 'misc',
  'version' => '1.1.2',
  'state' => 'stable',
  'createDirs' => '',
  'clearcacheonload' => true,
  'author' => 'András Ottó',
  'author_email' => 'typo3csp@gmail.com',
  'author_company' => '',
  'constraints' =>
  [
    'depends' =>
    [
      'typo3' => '10.4.0-11.99.999',
    ],
    'conflicts' =>
    [
    ],
    'suggests' =>
    [
    ],
  ],
  'autoload' =>
    [
        'psr-4' => [
            'AndrasOtto\\Csp\\' => 'Classes'
        ]
    ],
  '_md5_values_when_last_written' => '',
];

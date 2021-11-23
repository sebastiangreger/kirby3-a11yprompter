<?php

namespace sgkirby\A11yprompter;

/**
 * Kirby 3 A11yprompter
 *
 * @version   1.0.0
 * @author    Sebastian Greger <msg@sebastiangreger.net>
 * @copyright Sebastian Greger <msg@sebastiangreger.net>
 * @link      https://github.com/sebastiangreger/kirby3-a11yprompter
 * @license   GPLv2
 */

\Kirby::plugin('sgkirby/a11yprompter', [

    'snippets' => [
        'a11yprompter' => __DIR__ . '/snippets/a11yprompter.php'
    ],

]);

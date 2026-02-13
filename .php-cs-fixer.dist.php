<?php
$finder = (new PhpCsFixer\Finder())
    ->in(DIR)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PER-CS' => true,
        '@PHP8x2Migration' => true,
    ])
    ->setFinder($finder)
;
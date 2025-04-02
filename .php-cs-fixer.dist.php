<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('vendor')
    ->exclude(__DIR__.'/src/Kernel.php')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_before_statement' => true,
        'ordered_imports' => [
            'sort_algorithm' => 'length',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'no_unused_imports' => true,
    ])
    ->setFinder($finder)
;

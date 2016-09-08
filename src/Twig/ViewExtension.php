<?php

namespace Etudor\ViewableBundle\Twig;

use Etudor\ViewableBundle\Service\Generator;
use Twig_Extension;
use Twig_SimpleFilter;

class ViewExtension extends Twig_Extension
{
    /**
     * @var Generator
     */
    private $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function getFilters()
    {
        return [
            new Twig_SimpleFilter(
                'view', [
                    $this->generator,
                    'generate'
                ], [
                    'is_safe' => ['html']
                ]
            ),
        ];
    }

    public function getName()
    {
        return 'view_extension';
    }
}

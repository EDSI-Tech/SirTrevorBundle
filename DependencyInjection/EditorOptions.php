<?php

namespace EdsiTech\SirTrevorBundle\DependencyInjection;

/**
 * Class to store all options for the JS Editor
 */
class EditorOptions
{
    /**
     * @var string Twig template used as block theme
     */
    public $blocksTheme;

    /**
     * @var string Twig template used to render blocks
     */
    public $renderTemplate;

    /**
     * @var string path (Assetic-compatible) to a JS file to add
     */
    public $extraJsFile;

    /**
     * @var string[] array of allowed blocks
     */
    public $allowedBlocks;
}

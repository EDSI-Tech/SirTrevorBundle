<?php

namespace EdsiTech\SirTrevorBundle\Twig;

use EdsiTech\SirTrevorBundle\Serializer\BlockSerializer;
use EdsiTech\SirTrevorBundle\Entity\AbstractBlock;

class SirTrevorExtension extends \Twig_Extension
{
    /**
     * @var BlockSerializer
     */
    private $blockSerializer;

    /**
     * @var string
     */
    private $blocksTheme;


    const BLOCK_RENDER_TEMPLATE = 'EdsiTechSirTrevorBundle:Render:base.html.twig';

    const BLOCK_EDIT_TEMPLATE = 'EdsiTechSirTrevorBundle:Edit:base.html.twig';


    public function __construct(BlockSerializer $blockSerializer, $blocksTheme)
    {
        $this->blockSerializer  = $blockSerializer;
        $this->blocksTheme      = $blocksTheme;
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('cms_render', [$this, 'cmsRender'], [
                'needs_context'     => true,
                'needs_environment' => true,
                'is_safe'           => ['html']
            ]),
            new \Twig_SimpleFunction('block_render', [$this, 'blockRender'], [
                'needs_context'     => true,
                'needs_environment' => true,
                'is_safe'           => ['html']
            ])
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('markdown', [$this, 'parseMarkdown'], [
                'is_safe'   => ['html']
            ])
        ];
    }

    /**
     * Render Blocks are editable or not
     *
     * @param \Twig_Environment $environment
     * @param $context
     * @param \Traversable $blocks
     * @return string
     */
    public function cmsRender(\Twig_Environment $environment, $context, $blocks)
    {
        if (isset($context['is_editable']) && $context['is_editable']) {
            return $environment->render(self::BLOCK_EDIT_TEMPLATE, [
                'back_link'     => isset($context['back_link']) ? $context['back_link'] : null,
                'display_flashMessages' => isset($context['display_flashMessages']) ? $context['display_flashMessages'] : true, // by default we display flashes in Edit
                'json_blocks'   => $this->blockSerializer->serializeBlocks($blocks),
                'save_bar_buttons' => isset($context['save_bar_buttons']) ? $context['save_bar_buttons'] : ''
            ]);
        }

        return $environment->render(self::BLOCK_RENDER_TEMPLATE, [
            'blocks' => $blocks
        ]);
    }

    /**
     * Render, display, a Block
     *
     * @param \Twig_Environment $environment
     * @param $context
     * @param AbstractBlock $block
     * @return string
     */
    public function blockRender(\Twig_Environment $environment, $context, AbstractBlock $block)
    {
        // Will take care of caching it properly!
        /** @var \Twig_Template $blocksThemeTemplate */
        $blocksThemeTemplate = $environment->loadTemplate($this->blocksTheme);

        // Resolve block name
        $blockName = 'block_'.$block->getType();

        $vars = array_merge($context, [
            'block' => $block
        ]);

        return $blocksThemeTemplate->renderBlock($blockName, $vars);
    }

    /**
     * @param string $markdownText
     * @return string
     */
    public function parseMarkdown($markdownText)
    {
        return \Parsedown::instance()
            ->setBreaksEnabled(true) // automatic line breaks
            ->setMarkupEscaped(true) // No HTML!
            ->text($markdownText)
        ;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'sir_trevor_extension';
    }
}

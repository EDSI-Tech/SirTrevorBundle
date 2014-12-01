<?php

namespace EdsiTech\SirTrevorBundle\Serializer;

use EdsiTech\SirTrevorBundle\Entity\AbstractBlock;

class BlockSerializer
{
    /**
     * @param \Traversable $blocks
     * @return string JSON
     */
    public function serializeBlocks($blocks)
    {
        $data = ['data' => []];

        /** @var AbstractBlock $block */
        foreach ($blocks as $block) {
            $data['data'][] = [
                'type'  => $block->getType(),
                'data'  => [
                    'id'    => $block->getId() ?: null,
                    'text'  => $block->getContent()
                ]
            ];

        }

        return json_encode($data);
    }
}

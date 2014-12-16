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
            $aData = $block->getRawData();

            // make sure to inject (eventually) database-generated ID
            $aData['id'] = $block->getId();

            $data['data'][] = [
                'type'  => $block->getType(),
                'data'  => $aData
            ];

        }

        return json_encode($data);
    }
}

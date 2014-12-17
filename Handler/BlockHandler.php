<?php

namespace EdsiTech\SirTrevorBundle\Handler;

use EdsiTech\SirTrevorBundle\Model\EditedBlock;
use Symfony\Component\HttpFoundation\Request;

class BlockHandler
{
    /**
     * Returns an array of Blocks from Request, from Edit:base form
     *
     * @param Request $request
     * @return array
     */
    public function handle(Request $request)
    {
        $newData = $this->readFromRequest($request);

        // Like this is easier than with JMS!
        $unserializedBlocks = [];
        $count = count($newData);
        for ($i = 0; $i < $count; $i++) {
            $unserializedBlocks[] = $this->unserializeBlock($newData[$i], $i);
        }

        return $unserializedBlocks;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function readFromRequest(Request $request)
    {
        $data = json_decode($request->request->get('blocks', '{}'), true);

        if (! isset($data['data'])) {
            return [];
        }

        return $data['data'];
    }

    /**
     * @param array $data
     * @param int $position
     * @return EditedBlock
     */
    protected function unserializeBlock(array $data, $position)
    {
        $block = new EditedBlock();

        if (isset($data['data']['id'])) {
            $block->id = $data['data']['id'];

            unset($data['data']['id']);
        }

        $block->type        = $data['type'];
        $block->position    = $position;

        if (isset($data['data']['text'])) {
            $block->textContent = $data['data']['text'];

            unset($data['data']['text']);
        }

        // We store everything else in raw data, as some types have other keys
        $block->rawData = $data['data'];

        return $block;
    }
}

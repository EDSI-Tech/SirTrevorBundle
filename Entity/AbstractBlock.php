<?php

namespace EdsiTech\SirTrevorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractBlock
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="json_array")
     */
    protected $rawData;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="integer")
     */
    protected $position;


    /**
     * @param string $type
     * @param string $content
     * @param int $position
     * @param array $rawData
     */
    public function __construct($type, $content, $position, array $rawData)
    {
        $this->type     = $type;
        $this->content  = $content;
        $this->position = $position;
        $this->rawData  = $rawData;
    }

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get raw data
     *
     * @return array
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Make sure we don't duplicate the entity at save
     */
    public function __clone()
    {
        $this->id = null;
    }
}

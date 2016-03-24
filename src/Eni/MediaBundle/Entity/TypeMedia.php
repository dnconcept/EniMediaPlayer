<?php

namespace Eni\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeMedia
 *
 * @ORM\Table(name="type_media")
 * @ORM\Entity
 */
class TypeMedia
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return TypeMedia
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return TypeMedia
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}

<?php

namespace Eni\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;

/**
 * Genre
 *
 * @ORM\Table(name="genre", indexes={@ORM\Index(name="k_type_media", columns={"type_media"})})
 * @ORM\Entity
 */
class Genre
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
     * @var \TypeMedia
     * @Exclude
     * @ORM\ManyToOne(targetEntity="TypeMedia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_media", referencedColumnName="id")
     * })
     */
    private $typeMedia;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Genre
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
     * @return Genre
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \TypeMedia
     */
    public function getTypeMedia()
    {
        return $this->typeMedia;
    }

    /**
     * @param \TypeMedia $typeMedia
     * @return Genre
     */
    public function setTypeMedia($typeMedia)
    {
        $this->typeMedia = $typeMedia;
        return $this;
    }

}

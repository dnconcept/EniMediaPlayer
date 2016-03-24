<?php

namespace Eni\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ville
 *
 * @ORM\Table(name="ville")
 * @ORM\Entity
 */
class Ville
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
     * @ORM\Column(name="codePostal", type="string", length=5, nullable=false)
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    public function getId()
    {
        return $this->id;
    }

    public function getCodepostal()
    {
        return $this->codepostal;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;
        return $this;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

}

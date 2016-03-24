<?php

namespace Eni\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Exclude;

/**
 * Media
 *
 * @ORM\Table(name="media", indexes={@ORM\Index(name="k_genre", columns={"genre"}), @ORM\Index(name="k_createur", columns={"createur"})})
 * @ORM\Entity(repositoryClass="Eni\MediaBundle\Repository\MediaRepository")
 */
class Media
{

    const WEB_ROOT = '/EniMediaPlayer/web';
    const UPLOAD_DIR = '/upload/medias/';

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
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=3, nullable=false)
     */
    private $extension;

    /**
     * @var \Genre
     *
     * @ORM\ManyToOne(targetEntity="Genre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="genre", referencedColumnName="id")
     * })
     */
    private $genre;

    /**
     * @var \Personne
     *
     * @ORM\ManyToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="createur", referencedColumnName="id")
     * })
     */
    private $createur;

    /** @var UploadedFile */
    private $fileMedia;

    /** @var UploadedFile */
    private $filePochette;

    /**  @Accessor(getter="getMediaPath") */
    private $mediaPath;

    /**  @Accessor(getter="getPochettePath") */
    private $pochettePath;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Media
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
     * @return Media
     */
    public function setName($name)
    {
        $uploadDir = $this->getUploadDir();
        $oldMediaPath = $uploadDir . $this->getMediaName();
        $oldPochettePath = $uploadDir . $this->getPochetteName();
        $this->name = $name;
        if (file_exists($oldMediaPath)){
            @rename($oldMediaPath, $uploadDir . $this->getMediaName());
        }
        if (file_exists($oldPochettePath)){
            @rename($oldPochettePath, $uploadDir . $this->getPochetteName());
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return Media
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return \Genre
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param \Genre $genre
     * @return Media
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * @return \Personne
     */
    public function getCreateur()
    {
        return $this->createur;
    }

    /**
     * @param \Personne $createur
     * @return Media
     */
    public function setCreateur($createur)
    {
        $this->createur = $createur;
        return $this;
    }

    public function getFileMedia()
    {
        return $this->fileMedia;
    }

    public function setFileMedia(UploadedFile $fileMedia)
    {
        $this->fileMedia = $fileMedia;
        return $this;
    }

    public function getFilePochette()
    {
        return $this->filePochette;
    }

    public function setFilePochette(UploadedFile $filePochette)
    {
        $this->filePochette = $filePochette;
        return $this;
    }

    public function getMediaPath()
    {
        return self::WEB_ROOT . self::UPLOAD_DIR . $this->getMediaName();
    }

    public function getMediaName()
    {
        return md5($this->name) . "_media." . $this->extension;
    }

    public function getPochettePath()
    {
        return self::WEB_ROOT . self::UPLOAD_DIR . $this->getPochetteName();
    }

    public function getPochetteName()
    {
        return md5($this->name) . "_vignette";
    }

    public function uploadMedia()
    {
        if ($this->fileMedia == null)
            return;
        $this->setExtension($this->fileMedia->getClientOriginalExtension());
        $this->fileMedia->move($this->getUploadDir(), $this->getMediaName());
    }

    private function getUploadDir()
    {
        return __DIR__ . '/../../../../web' . self::UPLOAD_DIR;
    }

    public function uploadPochette()
    {
        if ($this->filePochette == null)
            return;
        $this->filePochette->move($this->getUploadDir(), $this->getPochetteName());
    }

}

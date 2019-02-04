<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Images
 *
 * @ORM\Table(name="images", uniqueConstraints={@ORM\UniqueConstraint(name="HashName_UNIQUE", columns={"HashName"})})
 * @ORM\Entity
 */
class Images
{
    /**
     * @var string
     *
     * @ORM\Column(name="HashName", type="string", length=32, nullable=false)
     */
    private $hashname;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Please, upload the photo.")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     * @ORM\Column(name="ImgName", type="string", length=50, nullable=false)
     */
    private $imgname;

    /**
     * @var integer
     *
     * @ORM\Column(name="ImageId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $imageid;


    /**
     * Set hashname
     *
     * @param string $hashname
     *
     * @return Images
     */
    public function setHashname($hashname)
    {
        $this->hashname = $hashname;

        return $this;
    }

    /**
     * Get hashname
     *
     * @return string
     */
    public function getHashname()
    {
        return $this->hashname;
    }

    /**
     * Set imgname
     *
     * @param string $imgname
     *
     * @return Images
     */
    public function setImgname($imgname)
    {
        $this->imgname = $imgname;

        return $this;
    }

    /**
     * Get imgname
     *
     * @return string
     */
    public function getImgname()
    {
        return $this->imgname;
    }

    /**
     * Get imageid
     *
     * @return integer
     */
    public function getImageid()
    {
        return $this->imageid;
    }

}

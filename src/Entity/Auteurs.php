<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Auteurs
 *
 * @ORM\Table(name="auteurs", uniqueConstraints={@ORM\UniqueConstraint(name="lenom_UNIQUE", columns={"thelog"})})
 * @ORM\Entity
 */
class Auteurs
{
    /**
     * @var int
     *
     * @ORM\Column(name="idauteurs", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idauteurs;

    /**
     * @var string
     *
     * @ORM\Column(name="thelog", type="string", length=60, nullable=false)
     */
    private $thelog;

    /**
     * @var string
     *
     * @ORM\Column(name="thepwd", type="string", length=120, nullable=false)
     */
    private $thepwd;

    /**
     * @var string
     *
     * @ORM\Column(name="thename", type="string", length=160, nullable=false)
     */
    private $thename;

    public function getIdauteurs(): ?int
    {
        return $this->idauteurs;
    }

    public function getThelog(): ?string
    {
        return $this->thelog;
    }

    public function setThelog(string $thelog): self
    {
        $this->thelog = $thelog;

        return $this;
    }

    public function getThepwd(): ?string
    {
        return $this->thepwd;
    }

    public function setThepwd(string $thepwd): self
    {
        $this->thepwd = $thepwd;

        return $this;
    }

    public function getThename(): ?string
    {
        return $this->thename;
    }

    public function setThename(string $thename): self
    {
        $this->thename = $thename;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getThelog();
    }

}


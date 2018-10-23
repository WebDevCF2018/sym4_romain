<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sections
 *
 * @ORM\Table(name="sections")
 * @ORM\Entity
 */
class Sections
{
    /**
     * @var int
     *
     * @ORM\Column(name="idsections", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsections;

    /**
     * @var string
     *
     * @ORM\Column(name="thesection", type="string", length=120, nullable=false)
     */
    private $thesection;

    /**
     * @var string
     *
     * @ORM\Column(name="thedesc", type="string", length=500, nullable=false)
     */
    private $thedesc;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Articles", mappedBy="sectionssections")
     */
    private $articlesarticles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articlesarticles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdsections(): ?int
    {
        return $this->idsections;
    }

    public function getThesection(): ?string
    {
        return $this->thesection;
    }

    public function setThesection(string $thesection): self
    {
        $this->thesection = $thesection;

        return $this;
    }

    public function getThedesc(): ?string
    {
        return $this->thedesc;
    }

    public function setThedesc(string $thedesc): self
    {
        $this->thedesc = $thedesc;

        return $this;
    }

    /**
     * @return Collection|Articles[]
     */
    public function getArticlesarticles(): Collection
    {
        return $this->articlesarticles;
    }

    public function addArticlesarticle(Articles $articlesarticle): self
    {
        if (!$this->articlesarticles->contains($articlesarticle)) {
            $this->articlesarticles[] = $articlesarticle;
            $articlesarticle->addSectionssection($this);
        }

        return $this;
    }

    public function removeArticlesarticle(Articles $articlesarticle): self
    {
        if ($this->articlesarticles->contains($articlesarticle)) {
            $this->articlesarticles->removeElement($articlesarticle);
            $articlesarticle->removeSectionssection($this);
        }

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getThesection();
    }
}

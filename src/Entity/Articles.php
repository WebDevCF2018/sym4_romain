<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="articles", indexes={@ORM\Index(name="fk_articles_auteurs_idx", columns={"auteurs_idauteurs"})})
 * @ORM\Entity
 */
class Articles
{
    /**
     * @var int
     *
     * @ORM\Column(name="idarticles", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idarticles;

    /**
     * @var string
     *
     * @ORM\Column(name="thetitle", type="string", length=180, nullable=false)
     */
    private $thetitle;

    /**
     * @var string
     *
     * @ORM\Column(name="thetxt", type="text", length=65535, nullable=false)
     */
    private $thetxt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="thedate", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $thedate = 'CURRENT_TIMESTAMP';

    /**
     * @var \Auteurs
     *
     * @ORM\ManyToOne(targetEntity="Auteurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="auteurs_idauteurs", referencedColumnName="idauteurs")
     * })
     */
    private $auteursauteurs;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Sections", inversedBy="articlesarticles")
     * @ORM\JoinTable(name="articles_has_sections",
     *   joinColumns={
     *     @ORM\JoinColumn(name="articles_idarticles", referencedColumnName="idarticles")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="sections_idsections", referencedColumnName="idsections")
     *   }
     * )
     */

    private $sectionssections;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sectionssections = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setThedate(new \DateTime());
    }

    public function getIdarticles(): ?int
    {
        return $this->idarticles;
    }

    public function getThetitle(): ?string
    {
        return $this->thetitle;
    }

    public function setThetitle(string $thetitle): self
    {
        $this->thetitle = $thetitle;

        return $this;
    }

    public function getThetxt(): ?string
    {
        return $this->thetxt;
    }

    public function setThetxt(string $thetxt): self
    {
        $this->thetxt = $thetxt;

        return $this;
    }

    public function getThedate(): ?\DateTimeInterface
    {
        return $this->thedate;
    }

    public function setThedate(?\DateTimeInterface $thedate): self
    {
        $this->thedate = $thedate;

        return $this;
    }

    public function getAuteursauteurs(): ?Auteurs
    {
        return $this->auteursauteurs;
    }

    public function setAuteursauteurs(?Auteurs $auteursauteurs): self
    {
        $this->auteursauteurs = $auteursauteurs;

        return $this;
    }

    /**
     * @return Collection|Sections[]
     */
    public function getSectionssections(): Collection
    {
        return $this->sectionssections;
    }

    public function addSectionssection(Sections $sectionssection): self
    {
        if (!$this->sectionssections->contains($sectionssection)) {
            $this->sectionssections[] = $sectionssection;
        }

        return $this;
    }

    public function removeSectionssection(Sections $sectionssection): self
    {
        if ($this->sectionssections->contains($sectionssection)) {
            $this->sectionssections->removeElement($sectionssection);
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getThetitle();
    }
}

<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Continents::class, inversedBy="test", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $region;

    /**
     * @ORM\OneToMany(targetEntity=Regions::class, mappedBy="nom", orphanRemoval=true)
     */
    private $regions;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection|Regions[]
     */
    private $continents;

    public function getContinents(): ?Continents
    {
        return $this->continents;
    }

    public function setContinents(?Continents $continents): self
    {
        $this->continents = $continents;

        return $this;
    }

    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Regions $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions[] = $region;
            $region->setNom($this);
        }

        return $this;
    }

    public function removeRegion(Regions $region): self
    {
        if ($this->regions->removeElement($region)) {
            // set the owning side to null (unless already changed)
            if ($region->getNom() === $this) {
                $region->setNom(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaysRepository::class)
 */
class Pays
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

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
    /***
     * @ORM\OneToOne(targetEntity=Continent::class, inversedBy="pays")
    *  @ORM\JoinColumn(nullable=false)
     */
    private $continent;

    /***
     * @ORM\OneToMany(targetEntity=Region::class, mappedBy="pays")
     */
    private $region;

    public function __construct()
    {
      $this->region = new ArrayCollection();
    }

    public function getContinent(): ?Continent
    {
        return $this->continent;
    }
    public function setContinent(?Continent $continent): self
    {
        $this->continent = $continent;

        return $this;
    }
    /**
     * @return Collection|Region[]
     */
    public function getRegion(): Collection
    {
        return $this->region;
    }
    public function addRegion(Region $rejion): self
    {
        if (!$this->region->contains($rejion)) {
            $this->region[] = $rejion;
            $rejion->setRegion($this);
        }

        return $this;
    }
    public function removeRegion(Region $rejion): self
    {
        if ($this->region->removeElement($rejion)) {
            // set the owning side to null (unless already changed)
            if ($rejion->getRegion() === $this) {
                $rejion->setRegion(null);
            }
        }

        return $this;
    }

}

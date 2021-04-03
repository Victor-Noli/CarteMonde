<?php

namespace App\Entity;

use App\Repository\ContinentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContinentRepository::class)
 */
class Continent
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
     * @ORM\OneToOne(targetEntity=Pays::class, mappedBy="continent")
     */
    private $pays;

    public function __construct()
    {
        return $this->pays;
    }

    /**
     * @return Collection|Pays[]
     */
    public function getPays(): Collection
    {
        return $this->pays;
    }

    public function addPays(Pays $country): self
    {
        if (!$this->pays->contains($country)) {
            $this->pays[] = $country;
            $country->setContinent($this);
        }

        return $this;
    }

    public function removePays(Pays $country): self
    {
        if ($this->pays->removeElement($country)) {
            if ($country->getContinent() === $this) {
                $country->setContinent(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     message="Merci de renseigner un nom de pays.",
     *     groups={"RegisterCountry"}
     *     )
     *
     * @Assert\Length(
     *     min="3",
     *     minMessage="Merci de renseigner un nom de pays correct.",
     *     groups={"RegisterCountry"}
     *     )
     */
    private $nom;
    /**
     * @ORM\ManyToOne(targetEntity=Ecole::class, inversedBy="classes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $continents;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $regions;

    /**
     * @ORM\OneToMany(targetEntity=Regions::class, mappedBy="nom", orphanRemoval=true)
     */

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



    public function getContinents(): ?Continents
    {
        return $this->continents;
    }

    public function setContinents(?Continents $continents): self
    {
        $this->continents = $continents;

        return $this;
    }

    /**
     * @return Collection|Regions[]
     */


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

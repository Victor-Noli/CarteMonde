<?php

namespace App\Entity;

use App\Repository\ContinentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContinentsRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Continents
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
     *     message="Merci de renseigner un nom de continent.",
     *     groups={"RegisterContinent"}
     *     )
     *
     * @Assert\Length(
     *     min="3",
     *     minMessage="Merci de renseigner un nom de continent correct.",
     *     groups={"RegisterContinent"}
     *     )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Country;

    /**
     * @ORM\OneToOne(targetEntity=Continents::class, mappedBy="continents", cascade={"persist", "remove"})
     */
    private $continents;

    public function __construct()
    {
        $this->continents = new ArrayCollection();
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
    /**
     * @return Collection|Country[]
     */
    public function getCountry(): Collection
    {
        return $this->Country;
    }

    public function addCountry(Country $country): self
    {
        if (!$this->Country->contains($country)) {
            $this->Country[] = $country;
            $country->setContinents($this);
        }

        return $this;
    }
    public function removeCountry(Country $country): self
    {
        if ($this->Country->removeElement($country)) {
            // set the owning side to null (unless already changed)
            if ($country->getContinents() === $this) {
                $country->setContinents(null);
            }
        }

        return $this;
    }

}

<?php

namespace App\Entity;

use App\Repository\ContinentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
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
     * @ORM\OneToMany(targetEntity=Country::class, mappedBy="Continents", cascade="remove")
     */
    private $country;

    public function __construct()
    {
        $this->country = new ArrayCollection();
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
        return $this->country;
    }

    public function addCountry(Country $country): self
    {
        if (!$this->country->contains($country)) {
            $this->country[] = $country;
            $country->setContinents($this);
        }

        return $this;
    }
    public function removeCountry(Country $country): self
    {
        if ($this->country->removeElement($country)) {
            // set the owning side to null (unless already changed)
            if ($country->getContinents() === $this) {
                $country->setContinents(null);
            }
        }

        return $this;
    }

}

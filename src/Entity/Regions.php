<?php

namespace App\Entity;

use App\Repository\RegionsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=RegionsRepository::class)
 */
class Regions
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
     *     message="Merci de renseigner un nom de region.",
     *     groups={"RegisterRegions"}
     *     )
     *
     * @Assert\Length(
     *     min="3",
     *     minMessage="Merci de renseigner un nom de region correct.",
     *     groups={"RegisterRegions"}
     *     )
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="regions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

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

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->continents = $country;

        return $this;
    }

}

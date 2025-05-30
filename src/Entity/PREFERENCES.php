<?php

namespace App\Entity;

use App\Repository\PREFERENCESRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PREFERENCESRepository::class)]
class PREFERENCES
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'preferences', cascade: ['persist', 'remove'])]
    private ?UTILISATEURS $user_id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $duree_concentration = null;

    #[ORM\Column]
    private ?int $type_rappel = null;

    #[ORM\Column]
    private ?int $frequence_rappel = null;

    #[ORM\Column]
    private ?\DateTime $date_creation = null;

    #[ORM\Column]
    private ?\DateTime $date_modification = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?UTILISATEURS
    {
        return $this->user_id;
    }

    public function setUserId(?UTILISATEURS $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getDureeConcentration(): ?\DateTime
    {
        return $this->duree_concentration;
    }

    public function setDureeConcentration(?\DateTime $duree_concentration): static
    {
        $this->duree_concentration = $duree_concentration;

        return $this;
    }

    public function getTypeRappel(): ?int
    {
        return $this->type_rappel;
    }

    public function setTypeRappel(int $type_rappel): static
    {
        $this->type_rappel = $type_rappel;

        return $this;
    }

    public function getFrequenceRappel(): ?int
    {
        return $this->frequence_rappel;
    }

    public function setFrequenceRappel(int $frequence_rappel): static
    {
        $this->frequence_rappel = $frequence_rappel;

        return $this;
    }

    public function getDateCreation(): ?\DateTime
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTime $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateModification(): ?\DateTime
    {
        return $this->date_modification;
    }

    public function setDateModification(\DateTime $date_modification): static
    {
        $this->date_modification = $date_modification;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\HABITUDESNAVIGATIONRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HABITUDESNAVIGATIONRepository::class)]
class HABITUDESNAVIGATION
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'habitudesNavigations')]
    private ?UTILISATEURS $utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?UTILISATEURS
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?UTILISATEURS $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}

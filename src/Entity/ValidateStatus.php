<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ValidateStatusRepository")
 */
class ValidateStatus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $checkstatus=true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheckstatus(): ?bool
    {
        return $this->checkstatus;
    }

    public function setCheckstatus(bool $checkstatus): self
    {
        $this->checkstatus = $checkstatus;

        return $this;
    }
}

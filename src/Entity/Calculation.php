<?php
// src/Entity/Calculation.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'calculations')]
#[ORM\Entity]
class Calculation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    protected string $calculation;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?\DateTimeInterface $dueDate;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCalculation(): string
    {
        return $this->calculation;
    }

    public function setCalculation(string $calculation): void
    {
        $this->calculation = $calculation;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeInterface $dueDate): void
    {
        $this->dueDate = $dueDate;
    }
}

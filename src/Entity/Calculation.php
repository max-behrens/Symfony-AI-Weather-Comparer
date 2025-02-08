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

    #[ORM\Column(type: 'text')]
    protected string $calculations;

    #[ORM\Column(type: 'text')]
    protected string $aiResponse;

    #[ORM\Column(type: 'string', length: 255)]
    protected string $country;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }


    public function getCalculations(): string
    {
        return $this->calculations;
    }

    public function setCalculations(string $calculations): void
    {
        $this->calculations = $calculations;
    }

    public function getAiResponse(): string
    {
        return $this->aiResponse;
    }

    public function setAiResponse(string $aiResponse): void
    {
        $this->aiResponse = $aiResponse;
    }
}
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

    #[ORM\Column(type: 'text', nullable: true)]  // Make it nullable
    protected ?string $calculations = null;  // Nullable string

    #[ORM\Column(type: 'text', nullable: true)]
    protected ?string $aiResponse = null;

    #[ORM\Column(type: 'string', length: 255)]
    protected ?string $country = null;

    public function setAiResponse(string $aiResponse): self
    {
        $this->aiResponse = $aiResponse;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getCalculations(): ?string  // Make it return nullable string
    {
        return $this->calculations;
    }

    public function setCalculations(?string $calculations): void  // Accept nullable string
    {
        $this->calculations = $calculations;
    }

    public function getAiResponse(): ?string
    {
        return $this->aiResponse;
    }
}

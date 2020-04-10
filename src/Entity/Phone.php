<?php declare(strict_types=1);

namespace App\Entity;

use App\Phone\PhoneNumberInterface;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Phone implements PhoneInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;
    /**
     * @ORM\Column(type="phone", unique=true, nullable=false)
     */
    private PhoneNumberInterface $phone;
    /**
     * @ORM\Column(type="datetime", columnDefinition="DATETIME on update CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP", nullable=false)
     */
    private DateTimeInterface $updatedAt;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $country;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $region;
    /**
     * @ORM\Column(type="smallint", length=2, options={"unsigned"=false}, nullable=false)
     */
    private int $timezone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): PhoneNumberInterface
    {
        return $this->phone;
    }

    public function setPhone(PhoneNumberInterface $phone): void
    {
        $this->phone = $phone;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    public function getTimezone(): int
    {
        return $this->timezone;
    }

    public function setTimezone(int $timezone): void
    {
        $this->timezone = $timezone;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function prePersistOrUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }
}

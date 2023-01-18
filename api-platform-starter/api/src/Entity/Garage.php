<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GarageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GarageRepository::class)]
#[ApiResource]
class Garage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'json')]
    private array $coordinates = [];

    #[ORM\Column]
    private ?bool $is_open = null;

    #[ORM\OneToMany(mappedBy: 'garage', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: 'garage', targetEntity: Recovery::class)]
    private Collection $recoveries;

    #[ORM\OneToMany(mappedBy: 'garage', targetEntity: Car::class)]
    private Collection $cars;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->recoveries = new ArrayCollection();
        $this->cars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    public function setCoordinates(array $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    public function isIsOpen(): ?bool
    {
        return $this->is_open;
    }

    public function setIsOpen(bool $is_open): self
    {
        $this->is_open = $is_open;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setGarage($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getGarage() === $this) {
                $order->setGarage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recovery>
     */
    public function getRecoveries(): Collection
    {
        return $this->recoveries;
    }

    public function addRecovery(Recovery $recovery): self
    {
        if (!$this->recoveries->contains($recovery)) {
            $this->recoveries->add($recovery);
            $recovery->setGarage($this);
        }

        return $this;
    }

    public function removeRecovery(Recovery $recovery): self
    {
        if ($this->recoveries->removeElement($recovery)) {
            // set the owning side to null (unless already changed)
            if ($recovery->getGarage() === $this) {
                $recovery->setGarage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
            $car->setGarage($this);
        }

        return $this;
    }

    public function removeCar(Car $car): self
    {
        // set the owning side to null (unless already changed)
        if ($this->cars->removeElement($car) && $car->getGarage() === $this) {
            $car->setGarage(null);
        }

        return $this;
    }
}

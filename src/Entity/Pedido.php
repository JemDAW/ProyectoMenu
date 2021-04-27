<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PedidoRepository::class)
 */
class Pedido
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $mesa;

    /**
     * @ORM\Column(type="float")
     */
    private $precioTotal;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="time")
     */
    private $hora;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMesa(): ?int
    {
        return $this->mesa;
    }

    public function setMesa(int $mesa): self
    {
        $this->mesa = $mesa;

        return $this;
    }

    public function getPrecioTotal(): ?float
    {
        return $this->precioTotal;
    }

    public function setPrecioTotal(float $precioTotal): self
    {
        $this->precioTotal = $precioTotal;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }
}

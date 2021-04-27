<?php

namespace App\Entity;

use App\Repository\PedidoRealizadoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PedidoRealizadoRepository::class)
 */
class PedidoRealizado
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Pedido::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $pedido;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Item::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    public function getPedido(): ?Pedido
    {
        return $this->pedido;
    }

    public function setPedido(?Pedido $pedido): self
    {
        $this->pedido = $pedido;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }
}

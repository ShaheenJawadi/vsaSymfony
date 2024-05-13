<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM; 
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Integer;

#[ORM\Entity]

//#[ORM\Entity(repositoryClass: CartItemsRepository::class)]
#[ORM\Table(name: "cartitems", indexes: [
    new ORM\Index(name: "cartId", columns: ["cartId"]),
    new ORM\Index(name: "productId", columns: ["productId"]),

])]
class CartItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

 

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Carts::class)]
    #[ORM\JoinColumn(name: "cartId", referencedColumnName: "id")]
    private ?Carts $cartId = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Products::class)]
    #[ORM\JoinColumn(name: "productId", referencedColumnName: "id")]
    private ?Products $productId = null;


    #[Assert\NotBlank]
    #[ORM\Column(name: "qty", type: "integer",  nullable: true)]
    private ?string $qty = null;
 

    #[Assert\NotBlank]
    #[ORM\Column(name: "prix", type: "integer",  nullable: true)]
    private ?string $prix = null;
 



    public function getId(): ?int
    {
        return $this->id;
    }
 



    public function getCartId(): ?Carts
    {
        return $this->cartId;
    }

    public function setCartId(?Carts $cartId): static
    {
        $this->cartId = $cartId;

        return $this;
    }

    public function getProductId(): ?Souscategorie
    {
        return $this->productId;
    }

    public function setProductId(?Souscategorie $productId): static
    {
        $this->productId = $productId;

        return $this;
    }

  



    
    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(?int $qty): static
    {
        $this->qty = $qty;

        return $this;
    }
   
   

        
    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }
 
 


  

}

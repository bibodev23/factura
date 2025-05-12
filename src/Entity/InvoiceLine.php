<?php

namespace App\Entity;

use App\Repository\InvoiceLineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InvoiceLineRepository::class)]
#[Vich\Uploadable]
class InvoiceLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $unitPrice = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'invoiceLines')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Invoice $invoice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cmr = null;

    #[Vich\UploadableField(mapping: 'cmrs', fileNameProperty: 'cmr')]
    #[Assert\Image()]
    private ?File $cmrFile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTotal(): ?float
    {
       return $this->getQuantity() * $this->getUnitPrice(); 
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getCmr(): ?string
    {
        return $this->cmr;
    }

    public function setCmr(?string $cmr): static
    {
        $this->cmr = $cmr;

        return $this;
    }

    /**
     * The uploaded file that will be used to set the cmr.
     *
     * @return File|null
     */
    public function getCmrFile(): ?File
    {
        return $this->cmrFile;
    }

    public function setCmrFile(?File $cmrFile): static
    {
        $this->cmrFile = $cmrFile;

        return $this;
    }

}

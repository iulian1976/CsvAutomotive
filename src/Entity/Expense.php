<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Expense
 *
 * @ORM\Entity(repositoryClass="App\Repository\ExpenseRepository")
 * @ORM\Table(name="expense")
 * @ORM\Entity
 */
class Expense
{
    /**
     * @var int
     *
     * @ORM\Column(name="expense_id", type="integer", nullable=true, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $expenseId;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Vehicle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vehicle_id", referencedColumnName="vehicle_id")
     * })
     *
     * @ORM\Column(name="vehicle_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $vehicleId;

    /**
     * @var string
     *
     * @ORM\Column(name="expense_number", type="string", length=64, nullable=false)
     */
    private $expenseNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="invoice_number", type="string", length=255, nullable=false)
     */
    private $invoiceNumber;

    /**
     * @var \DateTime
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     *
     * @ORM\Column(name="issued_on", type="datetime", nullable=false)
     */
    private $issuedOn;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=0, nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="value_te", type="decimal", precision=65, scale=3, nullable=false)
     *
     */
    private $valueTe;

    /**
     * @var string
     *
     * @ORM\Column(name="tax_rate", type="decimal", precision=65, scale=3, nullable=false)
     */
    private $taxRate;

    /**
     * @var string
     *
     * @ORM\Column(name="value_ti", type="decimal", precision=65, scale=3, nullable=false)
     */
    private $valueTi;

    public function getExpenseId(): ?int
    {
        return $this->expenseId;
    }

    public function getVehicleId(): ?int
    {
        return $this->vehicleId;
    }

    public function setVehicleId(int $vehicleId): self
    {
        $this->vehicleId = $vehicleId;

        return $this;
    }

    public function getExpenseNumber(): ?string
    {
        return $this->expenseNumber;
    }

    public function setExpenseNumber(string $expenseNumber): self
    {
        $this->expenseNumber = $expenseNumber;

        return $this;
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(string $invoiceNumber): self
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    public function getIssuedOn(): ?\DateTimeInterface
    {
        return $this->issuedOn;
    }

    public function setIssuedOn(\DateTimeInterface $issuedOn): self
    {
        $this->issuedOn = $issuedOn;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getValueTe(): ?string
    {
        return $this->valueTe;
    }

    public function setValueTe(string $valueTe): self
    {
        $this->valueTe = $valueTe;

        return $this;
    }

    public function getTaxRate(): ?string
    {
        return $this->taxRate;
    }

    public function setTaxRate(string $taxRate): self
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function getValueTi(): ?string
    {
        return $this->valueTi;
    }

    public function setValueTi(string $valueTi): self
    {
        $this->valueTi = $valueTi;

        return $this;
    }


}

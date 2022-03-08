<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GasStation
 *
 * @ORM\Entity(repositoryClass="App\Repository\GasStationRepository")
 * @ORM\Table(name="gas_station", uniqueConstraints={@ORM\UniqueConstraint(name="expense_id", columns={"expense_id"})})
 * @ORM\Entity
 */
class GasStation
{
    /**
     * @var int
     *
     * @ORM\Column(name="gas_station_id", type="integer", nullable=true, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $gasStationId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var point
     *
     * @ORM\Column(name="coordinate", type="point", nullable=false)
     */
    private $coordinate;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Expense")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="expense_id", referencedColumnName="expense_id")
     * })
     * @ORM\Column(name="expense_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $expenseId;

    public function getGasStationId(): ?int
    {
        return $this->gasStationId;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCoordinate()
    {
        return $this->coordinate;
    }

    public function setCoordinate($coordinate): self
    {
        $this->coordinate = $coordinate;

        return $this;
    }

    public function getExpense(): ?int
    {
        return $this->expenseId;
    }

    public function setExpense(int $expenseId): self
    {
        $this->expenseId = $expenseId;

        return $this;
    }

    public function getExpenseId(): ?int
    {
        return $this->expenseId;
    }

    public function setExpenseId(int $expenseId): self
    {
        $this->expenseId = $expenseId;

        return $this;
    }


}

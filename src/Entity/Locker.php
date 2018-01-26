<?php

namespace App\Entity;

use App\Exception\WrongLockerAccessCodeException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LockerRepository")
 * @ORM\Table(uniqueConstraints={
 *   @ORM\UniqueConstraint("locker_number_unique", columns="number"),
 *   @ORM\UniqueConstraint("locker_access_code_unique", columns="access_code")
 * })
 */
class Locker
{
    const FREE = 'free';
    const IN_USE = 'in_use';
    const OUT_OF_ORDER = 'out_of_order';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(length=5)
     */
    private $number;

    /**
     * @ORM\Column(length=20)
     */
    private $status;

    /**
     * @ORM\Column(nullable=true, length=7)
     */
    private $accessCode;

    public function __construct(string $number, string $status = self::FREE)
    {
        $this->number = $number;
        $this->status = $status;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function depositPackage(string $accessCode): void
    {
        if (self::FREE !== $this->status) {
            throw new \LogicException('Locker must be free of packages!');
        }

        $this->status = self::IN_USE;
        $this->accessCode = $accessCode;
    }

    public function pickUpPackage(string $accessCode): void
    {
        if (self::IN_USE !== $this->status) {
            throw new \LogicException('Locker must be in use!');
        }

        if ($this->accessCode !== $accessCode) {
            throw WrongLockerAccessCodeException::forLocker($this);
        }

        $this->accessCode = null;
        $this->status = self::FREE;
    }
}

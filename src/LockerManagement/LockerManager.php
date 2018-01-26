<?php

namespace App\LockerManagement;

use App\Exception\WrongLockerAccessCodeException;
use App\Repository\LockerRepository;
use Doctrine\Common\Persistence\ObjectManager;

class LockerManager
{
    private $repository;
    private $accessCodeGenerator;
    private $entityManager;

    public function __construct(
        LockerRepository $repository,
        AccessCodeGenerator $accessCodeGenerator,
        ObjectManager $entityManager
    ) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->accessCodeGenerator = $accessCodeGenerator;
    }

    public function depositPackage(string $lockerNumber): void
    {
        $locker = $this->repository->findOneBy(['number' => $lockerNumber ]);
        $locker->depositPackage($this->accessCodeGenerator->generate());

        $this->entityManager->flush();
    }

    public function pickUpPackage(string $accessCode): void
    {
        if (!$locker = $this->repository->findOneBy(['accessCode' => $accessCode ])) {
            throw new WrongLockerAccessCodeException('Invalid Access Code!');
        }

        $locker->pickUpPackage($accessCode);

        $this->entityManager->flush();
    }
}
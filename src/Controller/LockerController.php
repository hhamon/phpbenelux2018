<?php

namespace App\Controller;

use App\Entity\Locker;
use App\Exception\WrongLockerAccessCodeException;
use App\LockerManagement\LockerManager;
use App\Repository\LockerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LockerController extends Controller
{
    /**
     * @Route("/lockers", name="locker_list", methods="GET")
     */
    public function index(LockerRepository $repository): Response
    {
        return $this->render('locker/list.html.twig', [
            'lockers' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/lockers/{number}", name="locker_view", methods="GET", requirements={
     *   "number": "[a-zA-Z0-9]+"
     * })
     * @Entity("locker", expr="repository.findInUseLocker(number)")
     */
    public function locker(Locker $locker): Response
    {
        return $this->render('locker/view.html.twig', ['locker' => $locker]);
    }

    /**
     * @Route("/lockers/pick-up", name="locker_pickup", methods="POST")
     */
    public function pickUpPackage(Request $request, LockerManager $lockerManager): Response
    {
        try {
            $lockerManager->pickUpPackage($request->request->get('accessCode'));
            $this->addFlash('success', 'Package was picked-up and locker released!');
        } catch (WrongLockerAccessCodeException $e) {
            $this->addFlash('error', 'Presented access code is invalid!');
        }

        return $this->redirectToRoute('locker_list');
    }
}

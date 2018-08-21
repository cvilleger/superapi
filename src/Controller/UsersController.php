<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class UsersController extends FOSRestController
{
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    public function getUsersAction()
    {
        $users = $this->userRepository->findAll();
        return $this->view($users);
    }

    public function getUserAction(User $user)
    {
        return $this->view($user);
    }

    /**
     * @Rest\Post("/users")
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function postUsersAction(User $user, ConstraintViolationListInterface $validationErrors)
    {
        if ($validationErrors->count() > 0) {
            /** @var ConstraintViolation $constraintViolation */
            foreach ($validationErrors as $constraintViolation){
                $message = $constraintViolation->getMessage(); // Returns the violation message. (Ex. This value should not be blank.)
                $propertyPath = $constraintViolation->getPropertyPath(); // Returns the property path from the root element to the violation. (Ex. lastname)
            }
        }

        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user);
    }

    public function putUserAction(Request $request, int $id)
    {
        // $request->get('firstname')
    }

    public function deleteUserAction($id)
    {} // "delete_user"          [DELETE] /users/{id}
}

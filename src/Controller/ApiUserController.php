<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Form\UserType;
use App\Service\PasswordService;

/**
 * @Route("/api/user", name="api_user_")
 */
class ApiUserController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request)
    {
        $data = $request->request->all();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        // $userRepo = $this->getDoctrine()->getRepository(User::class);
        // $user = $userRepo->findOneBy(['firstname' => 'yoann']);
        // $user->setFirstname('luc');
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($user);
        // $em->flush();
        return $this->json([
            'user' => $user,
            'message' => 'eaj',
            'path' => 'src/Controller/ApiUserController.php',
        ]);
    }

    /**
     * @Route("/{user}/update", name="update", methods={"POST"})
     */
    public function update(Request $request, User $user)
    {
        $data = $request->request->all();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {

            if (!PasswordService::validPassword($user->getPassword())) {
                throw new \Exception('Le mot de passe doit faire au moins 8 caractéres', 409);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->json([
            'user' => $user,
            'message' => 'eaj',
            'path' => 'src/Controller/ApiUserController.php',
        ]);
    }
}

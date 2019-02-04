<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 2018-06-15
 * Time: 12:25
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Userranks;
use AppBundle\Entity\Users;
use AppBundle\Form\LoginType;
use AppBundle\Service\GlobalService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login_action")
     *
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function showLoginFormAction(Request $request, AuthenticationUtils $authenticationUtils)
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        /*$users = new Users();
        $form = $this->createForm(LoginType::class, $users);
        $form->handleRequest($request);*/

        return $this->render("Catering/login.html.twig",
            [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]);
    }

    /**
     * @Route("/register")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new Users();
        $rank = $this->getDoctrine()->getRepository(Userranks::class);

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, 'alamakota');
            $user->setPassword($password);
            $user->setEmail('admin@admin.lc');
            $user->setUsername('admin3');
            $user->setName("Jan");
            $user->setSurname("Nowak");
            $user->setPhonenumber(123432123);
            $user->setRankid($rank->findOneBy(["rankname" => "administrator"]));

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

        $globalservice = $this->get(GlobalService::class);



            return $this->redirectToRoute('login_action');

    }

}
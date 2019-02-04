<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 2018-07-03
 * Time: 12:05
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Aboutcompany;
use AppBundle\Entity\Activityrange;
use AppBundle\Entity\Contactinformation;
use AppBundle\Entity\Meals;
use AppBundle\Entity\Menucategories;
use AppBundle\Entity\Messagescustomers;
use AppBundle\Entity\News;
use AppBundle\Entity\Pagedescription;
use AppBundle\Entity\Pageroutes;
use AppBundle\Entity\Userranks;
use AppBundle\Entity\Users;
use AppBundle\Form\ActivityType;
use AppBundle\Form\ContactFieldsType;
use AppBundle\Form\EntityImageType;
use AppBundle\Form\HomePageFormType;
use AppBundle\Form\MenuCategoryMealType;
use AppBundle\Form\MenuCategoryType;
use AppBundle\Form\NewsType;
use AppBundle\Form\OfferPageType;
use AppBundle\Form\UserProfileType;
use AppBundle\Repository\UsersRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class AdminEditActionsController extends Controller
{
    private $path = 'Catering/Admin/AdminPages/Details/';

    /**
     * @Route("/admin/homepage/details/{id}", name="homepage_description_details")
     *
     * @param Aboutcompany $aboutcompany
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function DescriptionDetailsAction(Aboutcompany $aboutcompany)
    {
        $editform = $this->createFormBuilder()
            ->add("submit", SubmitType::class, ["label" => "Edytuj"])
            ->setAction($this->generateUrl("homepage_description_edit", ["id" => $aboutcompany->getAboutid()]))
            ->setMethod(Request::METHOD_PATCH)
            ->getForm();
        $deleteform = $this->createFormBuilder()
            ->add("submit", SubmitType::class, ["label" => "Usuń"])
            ->setAction($this->generateUrl("homepage_description_delete", ["id" => $aboutcompany->getAboutid()]))
            ->setMethod(Request::METHOD_POST)
            ->getForm();
        $returnform = $this->createFormBuilder()
            ->add("submit", SubmitType::class, ["label" => "Powrót"])
            ->setAction($this->generateUrl("admin_edit_homepage"))
            ->setMethod(Request::METHOD_PATCH)
            ->getForm();

        return $this->render($this->path."detailsdescription.html.twig",[
            "aboutcompany" => $aboutcompany,
            "editform" => $editform->createView(),
            "deleteform" => $deleteform->createView(),
            "returnform" => $returnform->createView()
        ]);
    }

    /**
     * @Route("/admin/homepage/description/create", name="homepage_description_create")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function HomePageDescriptionCreateAction(Request $request)
    {

            $aboutcompany = new Aboutcompany();
            $form = $this->createForm(HomePageFormType::class, $aboutcompany);

            if ($request->isMethod('post')) {
                $form->handleRequest($request);
                $entitymanager = $this->getDoctrine()->getManager();
                $entitymanager->persist($aboutcompany);
                $entitymanager->flush();

                $this->addFlash("success", "Pozycja {$aboutcompany->getAbouttitle()} została dodana.");
                return $this->redirectToRoute('homepage_description_details', ['id' => $aboutcompany->getAboutid()]);
            }
            return $this->render($this->path . 'add.html.twig', [
                "form" => $form->createView(),
                "image" => null
            ]);

    }

    /**
     * @Route("/admin/homepage/edit/{id}", name="homepage_description_edit")
     *
     * @param Aboutcompany $aboutcompany
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function HomePageDescriptionEditAction(Aboutcompany $aboutcompany, Request $request)
    {


            $form = $this->createForm(HomePageFormType::class, $aboutcompany);

            if ($request->isMethod('post')) {

                $form->handleRequest($request);
                $entityManager = $this->getDoctrine()->getManager();


                $entityManager->persist($aboutcompany);
                $entityManager->flush();

                $this->addFlash("success", "Pozycja {$aboutcompany->getAbouttitle()} została zaktualizowana.");
                return $this->redirectToRoute("homepage_description_details", ["id" => $aboutcompany->getAboutid()]);
            }
            return $this->render($this->path . 'edit.html.twig', [
                "form" => $form->createView(),
                "image" => $aboutcompany->getImageid()]);

    }

    /**
     * @Route("/admin/homepage/delete/{id}", name="homepage_description_delete", methods={"POST"})
     *
     * @param Aboutcompany $aboutcompany
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function HomePageDescriptionDeleteAction(Aboutcompany $aboutcompany)
    {
        if($this->parentRoute('admin_edit_homepage', $this->getUser()) === true) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->remove($aboutcompany);
            $entitymanager->flush();

            $this->addFlash("success", "Pozycja {$aboutcompany->getAbouttitle()} została usunięta.");
            return $this->redirectToRoute('admin_edit_homepage');
        }

        return $this->pageErrorInfo();
    }

    /**
     * @Route("/admin/offerpage/description/add", name="offerpage_description_add")
     *
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function offerPageDescriptionAddAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $getPageDescription = $entityManager->getRepository(Pagedescription::class)->findOneBy(["routename" => "view_offer"]);
        $pagedescription = new Pagedescription();

        if($getPageDescription instanceof $pagedescription){
            return $this->redirectToRoute("offerpage_description_edit", ["id" => $getPageDescription->getDescriptionid()]);
        }
        $form = $this->createForm(OfferPageType::class, $pagedescription);

        if($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            $pagedescription->setRoutename("view_offer");
            $entityManager->persist($pagedescription);
            $entityManager->flush();
            $this->addFlash('success', "Dodano opis strony");
        }
        return $this->render($this->path . 'editofferpagedescription.html.twig',[
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/offerpage/description/edit/{id}", name="offerpage_description_edit")
     *
     * @param Request $request
     * @param Pagedescription $pagedescription
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function OfferPageDescriptionEditAction(Request $request, Pagedescription $pagedescription)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(OfferPageType::class, $pagedescription);
        $backbutton = $this->createFormBuilder()
            ->setAction($this->generateUrl("admin_edit_offerpage"))
            ->add('submit', SubmitType::class, ["label" => "powrót"])
            ->getForm();
        if($request->isMethod('post')){
            $form->handleRequest($request);
            $entityManager->persist($pagedescription);
            $entityManager->flush();
            $this->addFlash('success', "Zaktualizowano dane");
        }
        return $this->render($this->path . 'editofferpagedescription.html.twig',[
            "form" => $form->createView(),
            "backbutton" => $backbutton->createView(),
        ]);
    }

    /**
     * @Route("/admin/offerpage/activity/add", name="offerpage_activity_add")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function OfferPageActivityAddAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $activityrange = new Activityrange();
        $form = $this->createForm(ActivityType::class, $activityrange);
        $backbutton = $this->createFormBuilder()
            ->setAction($this->generateUrl("admin_edit_offerpage"))
            ->add('submit', SubmitType::class, ["label" => "powrót"])
            ->getForm();
        if($request->isMethod('post')){
            $form->handleRequest($request);
            $entityManager->persist($activityrange);
            $entityManager->flush();
            $this->addFlash('success', "Dodano nowe dane");
        }
        return $this->render($this->path . 'addactivity.html.twig',[
            "form" => $form->createView(),
            "backbutton" => $backbutton->createView(),
        ]);
    }
    /**
     * @Route("/admin/offerpage/activity/edit/{id}", name="offerpage_activity_edit")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function OfferPageActivityEditAction(Request $request, Activityrange $activityrange)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(ActivityType::class, $activityrange);

        if($request->isMethod('post')){
            $form->handleRequest($request);
            $entityManager->persist($activityrange);
            $entityManager->flush();
            $this->addFlash('success', "Zaktualizowano dane");
        }
        return $this->render($this->path . 'editactivity.html.twig',[
            "form" => $form->createView(),
            "image" => $activityrange,
        ]);
    }

    /**
     * @Route("/admin/menupage/menucategory/add", name="menupage_menucategory_add")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function MenuPageCategoryAddAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $menucategories = new Menucategories();
        $form = $this->createForm(MenuCategoryType::class, $menucategories);

        if($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            $entityManager->persist($menucategories);
            $entityManager->flush();

            $this->addFlash("success", "Doano nową kategorię");

            return $this->redirectToRoute("admin_edit_menupage");
        }

        return $this->render($this->path . 'addmenucategory.html.twig', [
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/menupage/menucategory/edit/{id}", name="menupage_menucategory_edit")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function MenuPageCategoryEditAction(Request $request, Menucategories $menucategories)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(MenuCategoryType::class, $menucategories);

        if($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            $entityManager->persist($menucategories);
            $entityManager->flush();

            $this->addFlash("success", "Zaktualizowano kategorię");

        }

        return $this->render($this->path . 'addmenucategory.html.twig', [
            "form" => $form->createView(),
            "menucategories" => $menucategories,
        ]);
    }

    /**
     * @Route("/admin/menupage/menucategory/show/{id}", name="menupage_menucategory_show")
     *
     * @param Menucategories $menucategories
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function MenuPageCategoryDetails(Menucategories $menucategories)
    {
        $CategoryMeals = $this->getDoctrine()
            ->getRepository(Meals::class)->findBy(["categoryid" => $menucategories->getCategoryid()]);

        return $this->render($this->path . 'menucategorydetails.html.twig',[
            "category" => $CategoryMeals,
            "catid" => $menucategories,
        ]);
    }

    /**
     * @Route("/admin/menupage/menucategory/{id}/meal/add", name="menupage_menucategory_meal_add")
     *
     * @param Request $request
     * @param Menucategories $menucategories
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function MenuPageCategoryMealAddAction(Request $request, Menucategories $menucategories)
    {
        $meals = new Meals();
        $form = $this->createForm(MenuCategoryMealType::class, $meals);

        if($request->isMethod("POST"))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $form->handleRequest($request);
            $meals->setCategoryid($menucategories);
            $entityManager->persist($meals);
            $entityManager->flush();

            $this->addFlash("success", "Dodano nowe danie");
        }

        return $this->render($this->path . 'addmenucategorymeal.html.twig', [
            "form" => $form->createView(),
            "catid" => $menucategories,
        ]);
    }
    /**
     * @Route("/admin/menupage/menucategory/{categoryid}/meal/edit/{mealid}", name="menupage_menucategory_meal_show")
     *
     * @param Request $request
     * @param Menucategories $menucategories
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function MenuPageCategoryMealShowAction(Request $request, Menucategories $menucategories, Meals $meals)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(MenuCategoryMealType::class, $meals);

        if($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            $entityManager->persist($meals);
            $entityManager->flush();

            $this->addFlash("success", "Dodano nowe danie");
        }

        return $this->render($this->path . 'addmenucategorymeal.html.twig', [
            "form" => $form->createView(),
            "catid" => $menucategories,
            "categorymeal" => $meals,
        ]);
    }

    /**
     * @Route("/admin/newspage/description/add", name="newspage_description_add")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function NewsPageDescriptionAddAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $getPageDescription = $entityManager->getRepository(Pagedescription::class)->findOneBy(["routename" => "show_news"]);
        $pagedescription = new Pagedescription();

        if($getPageDescription instanceof $pagedescription){
            return $this->redirectToRoute("offerpage_description_edit", ["id" => $getPageDescription->getDescriptionid()]);
        }
        $form = $this->createForm(OfferPageType::class, $pagedescription);
        if($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            $pagedescription->setRoutename("show_news");
            $entityManager->persist($pagedescription);
            $entityManager->flush();
            $this->addFlash('success', "Dodano opis strony");
        }
        return $this->render($this->path . 'editofferpagedescription.html.twig',[
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/newspage/description/edit/{id}", name="newspage_description_edit")
     *
     * @param Request $request
     * @param Pagedescription $pagedescription
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function NewsPageDescriptionEditAction(Request $request, Pagedescription $pagedescription)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(OfferPageType::class, $pagedescription);
        $backbutton = $this->createFormBuilder()
            ->setAction($this->generateUrl("admin_edit_newspage"))
            ->add('submit', SubmitType::class, ["label" => "powrót"])
            ->getForm();
        if($request->isMethod('post')){
            $form->handleRequest($request);
            $entityManager->persist($pagedescription);
            $entityManager->flush();
            $this->addFlash('success', "Zaktualizowano dane");
        }
        return $this->render($this->path . 'editofferpagedescription.html.twig',[
            "form" => $form->createView(),
            "backbutton" => $backbutton->createView(),
        ]);
    }

    /**
     * @Route("/admin/newspage/news/add", name="newspage_news_add")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function NewsPageNewsAddAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $backbutton = $this->createFormBuilder()
            ->setAction($this->generateUrl("admin_edit_newspage"))
            ->add('submit', SubmitType::class, ["label" => "powrót"])
            ->getForm();
        if($request->isMethod('post')){
            $form->handleRequest($request);
            $entityManager->persist($news);
            $entityManager->flush();
            $this->addFlash('success', "Dodano nowe dane");
        }
        return $this->render($this->path . 'addnews.html.twig',[
            "form" => $form->createView(),
            "backbutton" => $backbutton->createView(),
        ]);
    }
    /**
     * @Route("/admin/newspage/news/edit/{id}", name="newspage_news_edit")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function NewsPageNewsEditAction(Request $request, News $news)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(NewsType::class, $news);
        $backbutton = $this->createFormBuilder()
            ->setAction($this->generateUrl("admin_edit_newspage"))
            ->add('submit', SubmitType::class, ["label" => "powrót"])
            ->getForm();

        if($request->isMethod('post')){
            $form->handleRequest($request);
            $entityManager->persist($news);
            $entityManager->flush();
            $this->addFlash('success', "Zaktualizowano dane");
        }
        return $this->render($this->path . 'addnews.html.twig',[
            "form" => $form->createView(),
            "backbutton" => $backbutton->createView(),
            "image" => $news,
        ]);
    }

    /**
     * @Route("/admin/contactpage/contactfield/add", name="contactpage_contactfield_add")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ContactPageFieldAddAction(Request $request)
    {
        $contactinformation = new Contactinformation();
        $contactform = $this->createForm(ContactFieldsType::class, $contactinformation);

        if($request->isMethod("POST"))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $contactform->handleRequest($request);
            $entityManager->persist($contactinformation);
            $entityManager->flush();

            $this->addFlash("success", "Dodatno nowe pole");

            return $this->redirectToRoute("admin_edit_contactpage");
        }
        return $this->render($this->path . 'addcontactfield.html.twig', [
            "contactform" => $contactform->createView(),
        ]);
    }

    /**
     * @Route("/admin/contactpage/contactfield/edit/{id}", name="contactpage_contactfield_edit")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ContactPageFieldEditAction(Request $request, Contactinformation $contactinformation)
    {
        $contactform = $this->createForm(ContactFieldsType::class, $contactinformation);

        if($request->isMethod("POST"))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $contactform->handleRequest($request);
            $entityManager->persist($contactinformation);
            $entityManager->flush();

            $this->addFlash("success", "Zaktualizowano pole");

            return $this->redirectToRoute("admin_edit_contactpage");
        }
        return $this->render($this->path . 'addcontactfield.html.twig', [
            "contactform" => $contactform->createView(),
        ]);
    }

    /**
     * @Route("/admin/userspage/user/add", name="userspage_user_add")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function UsersPageUserAddAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        $users = new Users();
        $form = $this->createForm(UserProfileType::class, $users);
        $form->add("rankid", EntityType::class, [
            'class' => 'AppBundle:Userranks',
            'choice_label' => 'rankname',
            'label' => 'Ranga',]);
        if($request->isMethod("POST"))
        {
            $pasenctypt = md5(uniqid());
            $password = $passwordEncoder->encodePassword($users, $pasenctypt);
            $users->setPassword($password);

            $form->handleRequest($request);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($users);
            $entityManager->flush();

            $emailMessage = (new \Swift_Message("Rejestracja nowego użytkownika"))
                ->setFrom("eljaszewicz-emil@o2.pl")
                ->setTo("eljaszewicz-emil@o2.pl")
                ->setBody($this->render("Catering/EmailTemplates/emailregisterinfo.html.twig", [
                    "userdata" => $form->getData(),
                    "password" => $pasenctypt,
                ]),
                    'text/html');
            $mailer->send($emailMessage);
            $this->addFlash("success", "Dodano nowego użytkownika");
        }
        return $this->render('Catering/Admin/AdminPages/addnewuser.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/userspage/user/edit/{id}", name="userspage_user_edit")
     */
    public function UsersPageUserEditAction(Request $request, Users $users, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        if($users->getUserid() == $this->getUser()->getUserid()){
            return $this->redirectToRoute("user_edit_userprofile", ["id" => $this->getUser()->getUserid()]);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $PageRoutesRepository = $entityManager->getRepository(Pageroutes::class);
        $UserRoutes = $entityManager->getRepository(Users::class);
        $getUserGrantedRoutes = $this->get('app.userservice')-> createLoggedUserMenu($UserRoutes, $users);
        $getPageRoutes = $this->get('app.userservice')-> createLoggedUserMenu($PageRoutesRepository, $this->getUser());


        $form = $this->createForm(UserProfileType::class, $users)
            ->add('delete', SubmitType::class, ["label" => "Usuń"])
            ->add('resetpassword', SubmitType::class, ["label" => "resetuj"]);
        $form->add("usergrantedroutes", ChoiceType::class, [
            "choices" =>
                ['Strony' => array_column($getPageRoutes["pages"], "id", "name"),
                    'Ustawienia' => array_column($getPageRoutes["settings"], "id", "name")],
            "label" => "Dodaj uprawnienia"
        ]);
        $form->add("rankid", EntityType::class, [
            'class' => 'AppBundle:Userranks',
            'choice_label' => 'rankname',
            'label' => 'Ranga',]);
        $form->handleRequest($request);

        if($request->isMethod("POST"))
        {
            if($form->get('submit')->isClicked()) {
                $userroutesdata = $UserRoutes->findGrantedUserRoute($users, $request->request->get("user_profile")["usergrantedroutes"]);

                $pageroutesdata = $PageRoutesRepository->findOneBy(
                    ["routeid" => $request->request->get("user_profile")["usergrantedroutes"]
                    ]);


                if (sizeof($userroutesdata) == 0) {
                    $users->setRouteid($pageroutesdata);
                }
                $entityManager->persist($users);
                $entityManager->flush();

                $this->addFlash("success", "Zaktualizowano dane użytkownika {$users->getName()} {$users->getSurname()}");

                return $this->redirectToRoute("userspage_user_edit", ["id" => $users->getUserid()]);
            }
            if($form->get('delete')->isClicked()){
                if($users->getUserid() != $this->getUser()->getUserid()) {
                    $entityManager->getRepository(Users::class);
                    $entityManager->remove($users);
                    $entityManager->flush();
                    $this->addFlash("success", "Usunięto użytkownika {$users->getName()} {$users->getSurname()}");
                }
                else {
                    $this->addFlash("error", "Nie możesz usunąć sam siebie");
                }
                return $this->redirectToRoute("admin_edit_userspage");
            }
            if($form->get('resetpassword')->isClicked()) {
                $pasenctypt = md5(uniqid());
                $password = $passwordEncoder->encodePassword($users, $pasenctypt);
                $users->setPassword($password);
                $entityManager->persist($users);
                $entityManager->flush();

                $emailMessage = (new \Swift_Message("Resetowanie hasła użytkownika"))
                    ->setFrom("eljaszewicz-emil@o2.pl")
                    ->setTo("eljaszewicz-emil@o2.pl")
                    ->setBody($this->render("Catering/EmailTemplates/emailchangepasswordinfo.html.twig", [
                        "userdata" => $form->getData(),
                        "password" => $pasenctypt,
                    ]),
                        'text/html');
                $mailer->send($emailMessage);
                $this->addFlash("success", "Hasło zostało zresetowane");
            }
        }


        return $this->render($this->path . 'edituserprofile.html.twig', [
            "form" => $form->createView(),
            "userdata" => $users,
            "usergrantedroutes" => $getUserGrantedRoutes,
        ]);
    }

    /**
     * @Route("/admin/userspage/userroute/delete/{pageroutes}/user/{users}", name="userspage_userroute_delete")
     */
    public function UsersPageUserRouteDeleteAction(Pageroutes $pageroutes, Users $users)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $users->removePageRoutesData($pageroutes);

        $entityManager->persist($users);
        $entityManager->flush();

        return $this->redirectToRoute("userspage_user_edit", ["id" => $users->getUserid()]);
    }

    /**
     * @Route("/admin/userspage/user/delete/{id}", name="userspage_user_delete")
     * @param Users $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function UsersPageUserDeleteAction(Users $user){
        $eM = $this->getDoctrine()->getManager();
        $eM->getRepository(Users::class)->find($user);
        $eM->remove($user);
        $eM->flush();

        $this->addFlash("success", "Użytkownik {$user->getUsername()} został pomyślnie usunięty z bazy");

        return $this->redirectToRoute("admin_edit_userspage");
    }

    /**
     * @Route("admin/show/customermessages/message/{id}", name="customersmessages_message_show")
     * @param Messagescustomers $customerMessage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function GetCustomerMessage(Request $request,Messagescustomers $customerMessage){
        $eM = $this->getDoctrine()->getManager();
        $customerMessage->setReceived(1);
        $eM->persist($customerMessage);
        $eM->flush();

        $removeForm = $this->createFormBuilder($customerMessage)
            ->add('delete',SubmitType::class, ["label" => "Usuń wiadomość"])
            ->getForm();
        $removeForm->handleRequest($request);

        if($request->isMethod("POST")) {
            if ($removeForm->get('delete')->isClicked()) {
                $eM->remove($customerMessage);
                $eM->flush();
                $this->addFlash('success', 'Wiadomość została usunięta');
                return $this->redirectToRoute("admin_show_customermessages");
            }
        }
        return $this->render($this->path."messagereceived.html.twig", [
            "message" => $customerMessage,
            "removeForm" => $removeForm->createView(),
        ]);
    }

    /**
     * @Route("/admin/userranks/rank/add", name="userranks_rank_add")
     */
    public function addUserRank(Request $request){
        $userRanks = new Userranks();
        $form = $this->createFormBuilder($userRanks)
            ->add('rankname', TextType::class, ["label" => "Nazwa rangi"])
            ->add("submit", SubmitType::class, ["label" => "Zapisz"])
            ->getForm();
        $form->handleRequest($request);
        if($form->get('submit')->isClicked()){
            $eM = $this->getDoctrine()->getManager();
            $userRanks->setRankname($form->get('rankname')->getData());
            $eM->persist($userRanks);
            $eM->flush();

            $this->addFlash('success', "Dodano nową rangę użytkownika");
            return $this->redirectToRoute("admin_userranks_show");
        }
        return $this->render($this->path.'adduserrank.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/userranks/rank/edit/{id}", name="userranks_rank_edit")
     */
    public function editUserRank(Request $request, Userranks $userrank){

        $eM = $this->getDoctrine()->getManager();
        $pageRoutesRepository = $this->getDoctrine()->getRepository(Pageroutes::class);
        $allPageRoutes = $pageRoutesRepository->getAllPageRoutes();
        $rankGrantedRoutes = $pageRoutesRepository->findPageRouteRoutePriviliges($userrank->getRankid());

        $allPagePrivileges = $this->get('app.userservice')-> createMenuFromRouteNames($allPageRoutes);
        $rankPrivileges =  $this->get('app.userservice')-> createMenuFromRouteNames($rankGrantedRoutes);

        $form = $this->createFormBuilder(new Pageroutes())
            ->add('submit', SubmitType::class, ["label" => "Dodaj"])
            ->add('delete', SubmitType::class, ["label" => "Usuń rangę"])
            ->add("routeid", ChoiceType::class, [
            "choices" =>
                ['Strony' => array_column($allPagePrivileges["pages"], "id", "name"),
                    'Ustawienia' => array_column($allPagePrivileges["settings"], "id", "name")],
            "label" => "Dodaj uprawnienia"])
            ->getForm();
        $form->handleRequest($request);
        if($form->get('submit')->isClicked()){
            $pageRoutes = $this->getDoctrine()->getRepository(Pageroutes::class)->findOneBy(["routeid" => $form->get('routeid')->getData()]);
            $pageRoutes->setRankid($userrank);
            $eM->persist($pageRoutes);
            $userrank->setRouteid($pageRoutes);
            $eM->flush();

            return $this->redirectToRoute("userranks_rank_edit", ["id" => $userrank->getRankid()]);
        }
        if($form->get('delete')->isClicked()){
            $eM->remove($userrank);
            $eM->flush();

            return $this->redirectToRoute("admin_userranks_show");
        }
        return $this->render($this->path.'editrankprivileges.html.twig', [
            "rankname" => $userrank,
            "rankprivileges" => $rankPrivileges,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/userranks/rankgrantedroute/delete/{pageroutes}/rank/{userranks}", name="userranks_rankgrantedroute_delete")
     */
    public function deleteUserRank( Pageroutes $pageroutes, Userranks $userranks){
        $entityManager = $this->getDoctrine()->getManager();
        $pageroutes->removePageRoutesData($userranks);

        $entityManager->persist($pageroutes);
        $entityManager->flush();
        $this->addFlash('success', 'Uprawnienia zostały usunięte');
        return $this->redirectToRoute("userranks_rank_edit", ["id" => $userranks->getRankid()]);
    }
    private function getEntityManagerRepository($entityclass)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $getEntityRepository = $entityManager->getRepository($entityclass);

        return $getEntityRepository;
    }
}
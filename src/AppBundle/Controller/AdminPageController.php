<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Aboutcompany;
use AppBundle\Entity\Accountroutes;
use AppBundle\Entity\Activityrange;
use AppBundle\Entity\Contactinformation;
use AppBundle\Entity\Menucategories;
use AppBundle\Entity\Messagescustomers;
use AppBundle\Entity\News;
use AppBundle\Entity\Pagedescription;
use AppBundle\Entity\Pageroutes;
use AppBundle\Entity\Userranks;
use AppBundle\Entity\Users;
use AppBundle\Form\OfferPageType;
use AppBundle\Form\UserProfileType;
use AppBundle\Service\GlobalService;
use AppBundle\Service\RouterService;
use AppBundle\Service\ShoppingBasketSrvice;
use AppBundle\Service\UsersService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AdminPageController extends Controller
{
    private $path = 'Catering/Admin/AdminPages/';



    /**
     * @Route("/admin", name="admin_index")
     * @Security("is_granted('edit')")
     *
     * @return Response
     */
    public function adminAction(Request $request)
    {

        return $this->render($this->path."stats.html.twig", [
            "rname" => "danetestowe",
        ]);
    }

    /**
     * @Route("/admin/edit/homepage", name="admin_edit_homepage")
     *@Security("is_granted('edit')")
     *
     * @param Aboutcompany $aboutcompany
     * @return Response
     */
    public function HomePageEditAction()
    {


            $addform = $this->createFormBuilder()
                ->add('submit', SubmitType::class, ['label' => 'Dodaj zawartość'])
                ->setAction($this->generateUrl("homepage_description_create"))
                ->setMethod(Request::METHOD_POST)
                ->getForm();

            return $this->render($this->path . 'homepageedit.html.twig',[
                "aboutcompany" => $this->getEntityManagerRepository(Aboutcompany::class)->findAll(),
                "addform" => $addform->createView(),
            ]);


    }

    /**
     * @Route("/admin/edit/offerpage", name="admin_edit_offerpage")
     *@Security("is_granted('edit')")
     *
     * @param Request $request
     * @return Response
     */
    public function OfferPageEditAction(Request $request)
    {
       // $routename = $request->attributes->get('_route');
        $entityManager = $this->getDoctrine()->getManager();
        $getPageDescription = $entityManager->getRepository(Pagedescription::class)->findOneBy(["routename" => "view_offer"]);
        $getActivityRange = $entityManager->getRepository(Activityrange::class)->findAll();
        $deleteForm = $this->createFormBuilder()
            ->add('deleteDescription', SubmitType::class, ["label" => "usuń"])
            ->getForm();
        return $this->render($this->path . 'offerpageedit.html.twig',[
            "pagedescription" => $getPageDescription,
            "activityrange" => $getActivityRange,
            "deleteform" => $deleteForm->createView(),
        ]);
    }
    /**
     * @Route("/admin/edit/menupage", name="admin_edit_menupage")
     * @Security("is_granted('edit')")
     */
    public function MenuPageEditAction()
    {
        $menycategories = $this->getDoctrine()->getRepository(Menucategories::class)->findAll();

        return $this->render($this->path . 'menupageedit.html.twig', [
            "menucategories" => $menycategories,
        ]);
    }
    /**
     * @Route("/admin/edit/newspage", name="admin_edit_newspage")
     * @Security("is_granted('edit')")
     */
    public function NewsPageEditAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $getPageDescription = $entityManager->getRepository(Pagedescription::class)->findOneBy(["routename" => "newspage"]);
        $getNews = $entityManager->getRepository(News::class)->findAll();

        return $this->render($this->path . 'newspageedit.html.twig',[
            "pagedescription" => $getPageDescription,
            "news" => $getNews,
        ]);
    }
    /**
     * @Route("/admin/edit/contactpage", name="admin_edit_contactpage")
     * @Security("is_granted('edit')")
     */
    public function ContactPageEditAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $getcontactInformation = $entityManager->getRepository(Contactinformation::class)->findAll();
        return $this->render($this->path . 'contactpageedit.html.twig', [
            "companycontact" => $getcontactInformation,
        ]);
    }

    /**
     * @Route("/admin/edit/userspage", name="admin_edit_userspage")
     * @Security("is_granted('edit')")
     *
     * @return Response
     */
    public function UsersPageEditAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $getusers = $entityManager->getRepository(Users::class)->findAll();
        return $this->render($this->path . 'userspageedit.html.twig', [
            "users" => $getusers,
        ]);
    }

    /**
     * @Route("/admin/edit/userprofile/{id}", name="user_edit_userprofile")
     * @param Users $user
     * @return Response
     */
    public function UserProfileEdit(Request $request, Users $user, UserPasswordEncoderInterface $passwordEncoder){
        if($user->getUserid() == $this->getUser()->getUserid()) {
            $form = $this->createForm(UserProfileType::class, $user)
                ->add("changepassword", PasswordType::class, ["label" => "Zmień hasło", 'required' => false,])
                ->add("confirmpassword", PasswordType::class, ["label" => "Powtórz hasło", 'required' => false,]);

            if ($request->isMethod("POST")) {
                $entityManager = $this->getDoctrine()->getManager();
                $form->handleRequest($request);

               if(!$form->get('changepassword')->isEmpty() && !$form->get('confirmpassword')->isEmpty()){
                   if($form->get('changepassword')->getData() == $form->get('confirmpassword')->getData()) {
                       $password = $passwordEncoder->encodePassword($user, $form->get('changepassword')->getData());
                       $user->setPassword($password);
                   }
                   else{
                       $form->get('changepassword')->addError(new FormError("Hasła różnią się od siebie"));

                   }
               }

               if(count($form->get('changepassword')->getErrors()) == 0) {
                   $entityManager->persist($user);
                   $entityManager->flush();
                   $this->addFlash("success", "Profil został zaktualizowany");
               }
            }
        }
        else{
            return $this->redirectToRoute("admin_edit_userprofile", ["id" => $this->getUser()->getUserid()]);
        }
        return $this->render($this->path.'Details/userprofile.html.twig',[
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/show/customermessages", name="admin_show_customermessages")
     * @return Response
     */
    public function showCustomerMessages(){
        $messagesCustomers = $this->getDoctrine()->getRepository(Messagescustomers::class)->findAll();

        return $this->render($this->path.'messageslist.html.twig', [
            "messages" => $messagesCustomers,
        ]);
    }
    /**
     * @Route("/admin/route/actualise", name="admin_route_actualise")
     * @Security("is_granted('edit')")
     */
    public function adminInsertEntityRoutesAction()
    {
            $router = new RouterService();
            $getAdminRoutes = $router->getRouterRoutes($this->get('router'))->filterRoutesByName('admin');


            $entityManager = $this->getDoctrine()->getManager();
            $userentityroutes = $entityManager->getRepository(Pageroutes::class);
            //$getadminrankid = $entityManager->getRepository(Userranks::class)->findOneBy(["rankname" => "administrator"]);
            foreach($getAdminRoutes as $routename => $url)
            {

                $entitydata = $userentityroutes->compareEntityPageRoutes($routename);

                if(empty($entitydata)) {
                    $accountroutes = new Pageroutes();
                    $accountroutes->setRoutename($routename);
                    $entityManager->persist($accountroutes);
                }
                else{
                    continue;
                }

            }
                $entityManager->flush();

$pr = new Pageroutes();
$ur = new Userranks();


        //$Pageroutes = $entityManager->getRepository(Pageroutes::class)->find(53);
        $Userranks = $entityManager->getRepository(Userranks::class)->findOneBy(["rankname" => "administrator"]);


       
        $getallpageroutes = $userentityroutes->findAll();
            foreach($getallpageroutes as $pageroute)
            {
                $entitydata = $userentityroutes->compareEntityRankRoutes($pageroute);

                if(empty($entitydata)) {
                    $Pageroutes = $entityManager->getRepository(Pageroutes::class)->find($pageroute->getRouteid());
                    $Pageroutes->setRankid($Userranks);
                    $Userranks->setRouteid($Pageroutes);

                    $entityManager->persist($Pageroutes);
                    $entityManager->persist($Userranks);
                }
            }
            $entityManager->flush();
            return $this->redirectToRoute('admin_index');

    }

    /**
     * @Route("/admin/userranks/show", name="admin_userranks_show")
     * @param Request $request
     * @return Response
     */
    public function getUserRanks(Request $request){

        $userRanks = $this->getDoctrine()->getRepository(Userranks::class)->findAll();

        return $this->render($this->path.'userranks.html.twig', [
            "userranks" => $userRanks,
        ]);
    }

    private function getEntityManagerRepository($entityclass)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $getEntityRepository = $entityManager->getRepository($entityclass);

        return $getEntityRepository;
    }
    private function getUserRoutePermissions()
    {
        return $this->isGrantedToRoute($this->getUser());
    }
    private function getParentRoutePermissions()
    {
        return $this->isGrantedToRoute($this->getUser());
    }
}
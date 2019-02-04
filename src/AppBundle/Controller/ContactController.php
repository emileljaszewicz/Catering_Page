<?php
namespace AppBundle\Controller;


use AppBundle\Entity\Contactinformation;
use AppBundle\Entity\Messagescustomers;
use AppBundle\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact_form")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactFormAction(Request $request){
        $messageCustomers = new Messagescustomers();
        $contactForm = $this->createForm(ContactFormType::class, $messageCustomers);
        $contactInfo = $this->getDoctrine()->getRepository(Contactinformation::class)->findAll();

        if($request->isMethod('post')){
            $entitymanager = $this->getDoctrine()->getManager();
            $contactForm->handleRequest($request);
            $messageCustomers->setReceived(0);
            $entitymanager->persist($messageCustomers);
            $entitymanager->flush();

            $this->addFlash("success", "Wiadomość została wysłana");
            return $this->redirectToRoute("contact_form");
        }
        return $this->render('Catering/contactform.html.twig', [
            "contactForm" => $contactForm->createView(),
            "contactInformation" => $contactInfo,
        ]);
    }
}
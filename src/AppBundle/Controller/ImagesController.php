<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 07.09.2018
 * Time: 16:23
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Images;
use AppBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ImagesController extends Controller
{
    private $path = 'Catering/Admin/AdminPages/';

    /**
     * @Route("/admin/images/show", name="admin_images_show")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ShowImagesAction(Request $request)
    {
        $buttonsCollection = [];
        $imagesentity = new Images();

        $entityManager = $this->getDoctrine()->getManager();
        $images = $entityManager->getRepository(Images::class);
        $getallpageimages = $images->findAll();

        $form = $this->createForm(ImageType::class, $imagesentity);
        foreach ($getallpageimages as $image) {
            $deleteButton = $this->createFormBuilder($imagesentity)
                ->add("delete", SubmitType::class, ["label" => "usuń"])
                ->getForm();
            $buttonsCollection[$image->getImageid()] = $deleteButton->createView();
        }
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $file = $imagesentity->getImgname();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('brochures_directory'), $filename);
            $imagesentity->setHashname($filename);
            $imagesentity->setImgname($file->getClientOriginalName());
            $entityManager->persist($imagesentity);
            $entityManager->flush();
            $this->addFlash('success','dodano zdjęcie');
            return $this->redirectToRoute("admin_images_show");
        }

        return $this->render($this->path.'showimages.html.twig',[
            "pageimages" => $getallpageimages,
            "imagesform" => $form->createView(),
            "deletebutton" => $buttonsCollection,
        ]);
    }

    /**
     * @Route("/admin/image/delete/{id}", name="image_delete")
     * @param Images $image
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function DeleteImageAction(Images $image){
        $eM = $this->getDoctrine()->getManager();
        $eM->getRepository(Images::class)->find($image);
        $eM->remove($image);
        $eM->flush();
        $this->addFlash("success", "Zdjęcie {$image->getImgname()} zostało poprawnie usunięte");
        return $this->redirectToRoute("admin_images_show");
    }
}
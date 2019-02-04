<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 2018-07-04
 * Time: 17:00
 */

namespace AppBundle\Form;


use AppBundle\Entity\Aboutcompany;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomePageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add("abouttitle", TextType::class, ["label" => "Nagłówek"])
            ->add("aboutdescription", TextareaType::class, ["label" => "Opis"])
            ->add('imageid', EntityType::class, [
                'class' => 'AppBundle:Images',
                'choice_label' => 'imgname',
                'label' => 'Zdjęcie z bazy',])
            ->add('submit', SubmitType::class, ["label" => "Zapisz"]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(["data_class" => Aboutcompany::class]);
    }
}
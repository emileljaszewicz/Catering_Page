<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 10.09.2018
 * Time: 09:25
 */

namespace AppBundle\Form;


use AppBundle\Entity\Activityrange;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("activitytitle", TextType::class, ["label" => "Zakres działalności"])
            ->add("activitydescription", TextareaType::class, ["label" => "Opis działalności"])
            ->add("imageid", EntityType::class, [
                'class' => 'AppBundle:Images',
                'choice_label' => 'imgname',
                'label' => 'Wybierz zdjęcie',
            ])
            ->add("submit", SubmitType::class, ["label" => "Zapisz"])
            ->add("remove", SubmitType::class, ["label" => "Usuń"]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                "data_class" => Activityrange::class
            ]
        );
    }
}
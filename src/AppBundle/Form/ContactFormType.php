<?php
namespace AppBundle\Form;

use AppBundle\Entity\Messagescustomers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add("name", TextType::class, ["label" => "Imię"])
            ->add("email", EmailType::class, ["label" => "Email kontaktowy"])
            ->add("messagetitle", TextType::class, ["label" => "Temat wiadomości"])
            ->add("messagedescription", TextareaType::class, ["label" => "Wiadomość"])
            ->add('submit', SubmitType::class, ["label" => "Wyślij wiadomość"]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(["data_class" => Messagescustomers::class]);
    }
}
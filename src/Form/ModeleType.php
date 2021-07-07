<?php

namespace App\Form;

use App\Entity\Modele;
use App\Entity\Marques;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ModeleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modele')
            ->add('annee')
            ->add('prix')
            ->add('climatisation')
            ->add('marques', EntityType::class, [
                'class' => Marques::class,
                'choice_label' => 'nom',
            ])
            ->add('Envoyer', SubmitType::class)
        ;
    } 

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Modele::class,
        ]);
    }
}

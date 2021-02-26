<?php

namespace App\Form;

use App\Entity\Games;
use App\Repository\CategoriesRepository;
use App\Entity\Categories;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GamesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
            'label' => 'Nombre del juego: ',
            'attr' => ['class' => 'form-control'],
          ])
            ->add('price', TextType::class, [
            'label' => 'Precio del juego: ',
            'attr' => ['class' => 'form-control'],
          ])
            ->add('rating', TextType::class, [
            'label' => 'Valoración del juego: ',
            'attr' => ['class' => 'form-control'],
          ])    
            ->add('description', TextType::class, [
            'label' => 'Descripción del juego: ',
            'attr' => ['class' => 'form-control'],
          ])
            ->add('year', TextType::class, [
            'label' => 'Año de lanzamiento del juego: ',
            'attr' => ['class' => 'form-control'],
          ])
            ->add('image', TextType::class, [
            'label' => 'Portada del juego: ',
            'attr' => ['class' => 'form-control'],
          ])
            ->add('category', EntityType::class, [
            'attr' => ['class' => 'form-control'],
            'class' => Categories::class,
            'mapped' => false,
            'choice_label' => function(Categories $category){
                return $category->getName();
            }
          ])
            ->add('save',SubmitType::class, array(
                'label' => 'Añadir',
                'attr' => array('class'=>'btn btn-primary'))
            );
    }

    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Games'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_games';
    }
}

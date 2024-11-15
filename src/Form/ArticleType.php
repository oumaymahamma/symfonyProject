<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Lc;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('prix')
            ->add('Description')
            ->add('Date', null, [
                'widget' => 'single_text',
            ])
            ->add('Location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'id',
            ])
            ->add('Lc', EntityType::class, [
                'class' => Lc::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

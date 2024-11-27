<?php
namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
{
$builder
->add('name', TextType::class, ['label' => 'Name'])
->add('prix', TextType::class, ['label' => 'Price'])
->add('date', null, ['widget' => 'single_text', 'label' => 'Date'])
->add('photo', FileType::class, [
'label' => 'Photo',
'required' => false,  // Make photo optional
'mapped' => false,    // Not directly mapped to the entity field
])
->add('description', TextareaType::class, ['label' => 'Description']);
}

public function configureOptions(OptionsResolver $resolver): void
{
$resolver->setDefaults([
'data_class' => Article::class,
]);
}
}

<?php

namespace App\Form;

use App\Entity\Autor;
use App\Entity\Editorial;
use App\Entity\Libro;
use App\Entity\Socio;
use App\Repository\AutorRepository;
use App\Repository\EditorialRepository;
use App\Repository\SocioRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LibroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, ['label' => 'Titulo'])
            ->add('anioPublicacion', IntegerType::class, ['label' => 'Año de Publicacion'])
            ->add('paginas', IntegerType::class, ['label' => 'Paginas'])
            ->add('isbn', TextType::class, [
                'label' => 'ISBN',
                'attr' => ['maxlenght' => 13]
            ])
            ->add('precioCompra', MoneyType::class, [
                'label' => 'Precio de Compra',
                'divisor' => 100
            ])
            ->add('editorial', EntityType::class, [
                'class' => Editorial::class,
                'choice_label' => function (Editorial $editorial) {
                    return $editorial->getNombre();
                },
                'query_builder' => function (EditorialRepository $editorialRepository) {
                    return $editorialRepository->createQueryBuilder('e')
                        ->orderBy('e.nombre', 'ASC');
                }
            ])
            ->add('autores', EntityType::class, [
                'class' => Autor::class,
                //'expanded' => true,
                'multiple' => true,
                'choice_label' => function (Autor $autor) {
                    return $autor->getNombre() . " " . $autor->getApellidos();
                },
                'query_builder' => function (AutorRepository $autorRepository) {
                    return $autorRepository->createQueryBuilder('a')
                        ->orderBy('a.nombre', 'ASC');
                }
            ])
            ->add('socio', EntityType::class, [
                'class' => Socio::class,
                'required' => false,
                'placeholder' => 'No prestado',
                'choice_label' => function (Socio $socio) {
                    $nombre = $socio->getApellidos() . " " . $socio->getNombre();
                    if ($socio->isEsDocente()) {
                        $nombre .= " (docente)";
                    }
                    return $nombre;
                },
                'query_builder' => function (SocioRepository $socioRepository) {
                    return $socioRepository->createQueryBuilder('s')
                        ->orderBy('s.apellidos', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Libro::class,
        ]);
    }
}

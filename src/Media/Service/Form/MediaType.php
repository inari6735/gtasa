<?php declare(strict_types=1);

namespace App\Media\Service\Form;

use App\Media\Model\DTO\MediaInput;
use App\Media\Model\Enum\MediaVisibility;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'Upload file',
                'required' => true,
            ])
            ->add('visibility', EnumType::class, [
                'class' => MediaVisibility::class,
                'label' => 'Visibility',
                'required' => true,
                'choice_label' => fn(MediaVisibility $choice) => $choice->name,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MediaInput::class,
        ]);
    }
}

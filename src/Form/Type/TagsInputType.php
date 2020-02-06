<?php 

namespace App\Form\Type;

use App\Form\DataTransformer\TagsArrayToStringTransformer;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagsInputType extends AbstractType
{
     /**
     * @var TagRepository
     */
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {

        $builder
            //transforme une collection doctrine en tableau
            ->addModelTransformer(new CollectionToArrayTransformer(), true)

            //transforme un tableau de tags en chaine de caractéres
            ->addModelTransformer(
                new TagsArrayToStringTransformer($this->tagRepository),
                true
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => [
                'data-role' => 'tagsinput',
            ],
        ]);
        
    }

    public function getParent()
    {
        return TextType::class;
    }
}
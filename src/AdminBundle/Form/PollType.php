<?php

namespace AdminBundle\Form;

use AdminBundle\Entity\Answer;
use AdminBundle\Repository\AnswerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PollType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $questionId = $options['attr']["questionId"];

        $builder
            ->add('person')
//            ->add('question')
            ->add('answer', EntityType::class, array(
                'class' => Answer::CLASS_NAME,
                'query_builder' => function (AnswerRepository $er) use ($questionId) {
                    return $er->createQueryBuilder('a')
                        ->where('a.question = :id')
                        ->setParameter('id', $questionId);
                },
//                'expanded' => false,
//                'multiple' => true
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Poll'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_poll';
    }


}

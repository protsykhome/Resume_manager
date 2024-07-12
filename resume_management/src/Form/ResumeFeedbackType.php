<?php

namespace App\Form;

use App\Entity\ResumeFeedback;
use App\Entity\Resume;
use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResumeFeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('resume', EntityType::class, [
                'class' => Resume::class,
                'choice_label' => 'id',
            ])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name',
            ])
            ->add('feedback_type', ChoiceType::class, [
                'choices' => [
                    'Positive' => 'positive',
                    'Negative' => 'negative',
                ],
            ])
            ->add('sent_at', DateTimeType::class, [
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ResumeFeedback::class,
        ]);
    }
}

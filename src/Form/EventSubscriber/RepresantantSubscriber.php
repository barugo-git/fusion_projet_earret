<?php

namespace App\Form\EventSubscriber;

use App\Form\RepresentantType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class RepresantantSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents() : array
    {
        return [
        FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::POST_SUBMIT => 'onPostSubmit',
    ];

    }

    public function onPreSetData(FormEvent $event): void
    {
        $data = $event->getData();
        $form = $event->getForm();

        $this->modifyForm($form, $data['type'] ?? null);
    }

    public function onPostSubmit(FormEvent $event): void
    {
        $form = $event->getForm();

        // It's important here to fetch $event->getForm()->getData(), as
        // $event->getData() will get you the client data (that is, the ID)
        $type = $form->get('type')->getData();

        // since we've added the listener to the child, we'll have to pass on
        // the parent to the callback function!
        $this->modifyForm($form->getParent(), $type);
    }


    private function modifyForm(FormInterface $form, ?string $type): void
    {
        if ($type === 'moral') {
            $form->add('representants1', RepresentantType::class, [
                'mapped' => false,
                'label' => false,
                'required' => false,
            ]);
        }
    }
}

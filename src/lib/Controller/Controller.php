<?php

namespace Controller;

use Herrera\Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 *
 * @author Ales Zavadsky <zavadskya@gmail.com>
 */
class Controller
{
    /**
     * Renders the large example form.
     *
     * @param Application $app     The application.
     * @param Request     $request The request.
     *
     * @return string The rendered view.
     */
    public static function indexView(Application $app, Request $request)
    {

        $form = $app->form();

        // name
        $form->add(
            'name',
            'text',
            array(
                'attr' => array(
                    'placeholder' => 'Jméno a příjmení',
                    'class' => 'form-control',
                ),
                'constraints' => new NotBlank(),
                'label' => ' '
            )
        );

        // email
        $form->add(
            'email',
            'email',
            array(
                'attr' => array(
                    'placeholder' => 'email',
                    'class' => 'form-control',
                ),
                // 'constraints' => new NotBlank(),
                'label' => ' '
            )
        );

        // phone
        $form->add(
            'phone',
            'integer',
            array(
                'attr' => array(
                    'placeholder' => 'telefon',
                    'class' => 'form-control',
                ),
                'label' => ' '
            )
        );

        // subject
        $form->add(
            'subject',
            'text',
            array(
                'attr' => array(
                    'placeholder' => 'předmět',
                    'class' => 'form-control',
                ),
                'label' => ' '
            )
        );




        // message
        $form->add(
            'message',
            'textarea',
            array(
                'attr' => array(
                    'placeholder' => 'vaše zpráva',
                    'class' => 'form-control',
                    'rows' => '6',
                ),
                // 'constraints' => new NotBlank(),
                'label' => ' '
            )
        );

    

        // submit
        $form->add(
            'submit',
            'submit',
            array(
                'attr' => array(
                    'class' => 'btn btn-primary'
                ),
                'label' => 'Odeslat'
            )
        );

        $form = $form->getForm();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $data = $form->getData();
                var_dump($data);
                // $this->sentEmail($data);
            }
        }


        return $app->render(
            'index.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }


}

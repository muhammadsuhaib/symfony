<?php

namespace AppBundle\Controller;

use AppBundle\Entity\users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class crudController extends Controller
{
    /**
     * @Route("/index", name="index")
     */

    public function MasterAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:users')->findAll();

         return $this->render('Layout/master.html.twig',['data'=>$data]);
    }


    /**
     * @Route("/insert", name="insert")
     */

    public function InsertAction(Request $request )
    {



        $users = new users;
        $form = $this->createFormBuilder($users)
            -> add('name',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('last_name',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('address',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('phone_number',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('city',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('country',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('date_of_birth',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('save',SubmitType::class,array('label'=>'Submit','attr'=>array('class'=>'btn btn-primary')))
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $name = $form['name']->getData();
            $last_name = $form['last_name']->getData();
            $address = $form['address']->getData();
            $phone_number = $form['phone_number']->getData();
            $city = $form['city']->getData();
            $country = $form['country']->getData();
            $date_of_birth = $form['date_of_birth']->getData();

            $users->setName($name);
            $users->setLastName($last_name);
            $users->setAddress($address);
            $users->setPhoneNumber($phone_number);
            $users->setCity($city);
            $users->setCountry($country);
            $users->setDateOfBirth($date_of_birth);


            $em = $this->getDoctrine()->getManager();
            $em->persist($users);
            $em->flush();
            $this->addFlash('message','Data Succesfully Inserted');
            return $this->redirectToRoute('index');

        }

        return $this->render('crud/insert.html.twig',['form'=>$form->createView()
            ]);

    }


    /**
     * @Route("/edit/{id}", name="edit")
     */

    public function EditAction(Request $request,$id)
    {

        $data = $this->getDoctrine()->getRepository('AppBundle:users')->find($id);
        $data->setName($data->getName());
        $data->setLastName($data->getLastName());
        $data->setAddress($data->getAddress());
        $data->setPhoneNumber($data->getPhoneNumber());
        $data->setCity($data->getCity());
        $data->setCountry($data->getCountry());
        $data->setDateOfBirth($data->getDateOfBirth());


        $form = $this->createFormBuilder($data)
            -> add('name',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('last_name',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('address',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('phone_number',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('city',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('country',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('date_of_birth',TextType::class,array('attr'=>array('class'=>'form-control')))
            -> add('save',SubmitType::class,array('label'=>'Submit','attr'=>array('class'=>'btn btn-primary')))
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $name = $form['name']->getData();
            $last_name = $form['last_name']->getData();
            $address = $form['address']->getData();
            $phone_number = $form['phone_number']->getData();
            $city = $form['city']->getData();
            $country = $form['country']->getData();
            $date_of_birth = $form['date_of_birth']->getData();


            $em = $this->getDoctrine()->getManager();
            $data = $em->getRepository('AppBundle:users')->find($id);


            $data->setName($name);
            $data->setLastName($last_name);
            $data->setAddress($address);
            $data->setPhoneNumber($phone_number);
            $data->setCity($city);
            $data->setCountry($country);
            $data->setDateOfBirth($date_of_birth);


            $em->persist($data);
            $em->flush();
            $this->addFlash('message','Data Successfully Updated');
            return $this->redirectToRoute('index');

        }






        return $this->render('crud/edit.html.twig',['form'=>$form->createView()
        ]);

    }



    /**
     * @Route("/view/{id}",name ="view")
     */



    public function ViewAction($id)
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:users')->find($id);

        return $this->render('crud/view.html.twig',['data'=>$data]);
    }


    /**
     * @Route("/delete/{id}", name="delete")
     */

    public function DeleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:users')->find($id);
        $em->remove($users);
        $em->flush();
        $this->addFlash('delete','Deleted Successfuly');
        return $this->redirectToRoute('index');
    }







}

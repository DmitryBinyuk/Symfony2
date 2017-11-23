<?php

namespace Custom\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/users", name="admin-users")
     * @Template()
     */
    public function indexAction()
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->render('CustomAdminBundle:User:index.html.twig', array('users' => $users));
    }

    /**
     * @Route("/users/show/{id}", name="admin-users-show")
     * @Template()
     */
    public function showAction($id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        return $this->render('CustomAdminBundle:User:show.html.twig', array('user' => $user));
    }

    /**
     * @Route("/users/create", name="admin-users-create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();

        $form = $this->createFormBuilder($user)
            ->add('username', 'text')
            ->add('email', 'email')
            ->add('email_canonical', 'email')
            ->add('password', 'password')
            ->add('save', 'submit', array('label' => 'Create User'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $userManager->createUser();
            $user->setUsername($form->get('username')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setEmailCanonical($form->get('email_canonical')->getData());
            $user->setLocked(0); // don't lock the user
            $user->setEnabled(1); // enable the user or enable it later with a confirmation token in the email
            $user->setPlainPassword($form->get('password')->getData());// this method will encrypt the password
            $userManager->updateUser($user);

            return $this->redirectToRoute('admin-users');
        }

        return $this->render('CustomAdminBundle:User:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/users/update/{id}", name="admin-users-update")
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $form = $this->createFormBuilder($user)
            ->add('username', 'text')
            ->add('email', 'email')
            ->add('email_canonical', 'email')
            ->add('password', 'password')
            ->add('save', 'submit', array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setUsername($form->get('username')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setEmailCanonical($form->get('email_canonical')->getData());
            $user->setLocked(0); // don't lock the user
            $user->setEnabled(1); // enable the user or enable it later with a confirmation token in the email
            $user->setPlainPassword($form->get('password')->getData());// this method will encrypt the password
            $userManager->updateUser($user);

            return $this->redirectToRoute('admin-users');
        }

        return $this->render('CustomAdminBundle:User:update.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/users/delete/{id}", name="admin-users-delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $userManager->deleteUser($user);

        return $this->redirectToRoute('admin-users');
    }
}

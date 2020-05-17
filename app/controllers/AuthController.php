<?php


class AuthController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->tag->setTitle('Signup/Login');
    }

    public function signupFormAction()
    {
        $this->view->pick('auth/signup/index');
    }

    public function signupAction()
    {
        $form = new SignupForm();

        if(!$this->isCsrfTokenPosted())
            return $this->response->redirect('signup');
        // Check to see if this is a POST request
        if($this->request->isPost())
        {
            // Validate the form data posted
            if(!$form->isValid($this->request->getPost())){
                // If the form failed validation, add the errors to the flash error message.
                $this->flashEntityErrorMessages($form);
                return $this->response->redirect('signup');
            } else {
                $user = new Users();

                // Form was validated successfully. Lets try to save user
                $data = $this->request->getPost();
                $data['password'] = $this->security->hash($data['password']);
                $success = $user->saveOne($data);

                $this->view->pick('auth/signup/process');

                // passing the result to the view
                if ($success) {
                    $this->flashSession->success('Thanks for registering, please login to save an order');
                    return $this->response->redirect('/');
                } else {
                    $this->flashEntityErrorMessages($user);
                    $this->response->redirect('signup');
                }
            }

        }
        // Send the form to the view.
        $this->view->form = $form;
    }

    public function loginFormAction()
    {
        $this->view->pick('auth/login/index');
    }

    public function loginAction()
    {
        $form = new LoginForm();

        if(!$this->isCsrfTokenPosted())
            return $this->response->redirect('login');
        if($this->request->isPost()) {
            // Validate the form data posted
            if(!$form->isValid($this->request->getPost())){
                // If the form failed validation, add the errors to the flash error message.
                $this->flashEntityErrorMessages($form);
                return $this->response->redirect('login');
            } else {
                // Form was validated successfully. Lets try to login
                $data = $this->request->getPost();
                $user = Users::findFirstByEmail($data['email']);
                if(!$user) {
                    $this->flashSession->error('Email or password is incorrect');
                    return $this->response->redirect('login');
                }
                if($this->security->checkHash($data['password'], $user->password))
                {
                    $this->setUserSessions($user);
                    $this->flashSession->success('Thanks for logging in!');
                    return $this->response->redirect('/');
                }
                $this->flashSession->error('Email or password is incorrect');
                return $this->response->redirect('login');
            }
        }
    }

    public function logoutAction()
    {
        $this->session->remove('role');
        $this->session->remove('user');
        return $this->response->redirect('/');
    }

    private function setUserSessions($user)
    {
        $this->session->set('role', 'user');
        $this->session->set('user', $user);
    }
}
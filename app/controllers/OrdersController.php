<?php


class OrdersController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->tag->setTitle('Orders');
        $this->user = $this->session->get('user');
    }

    public function allAction()
    {
        $this->view->setVars([
            'orders' => $this->user->getOrders()
        ]);
    }

    public function indexAction()
    {

    }

    public function createAction()
    {
        $form = new OrderForm();

        if(!$this->isCsrfTokenPosted())
            return $this->response->redirect('orders');
        // Check to see if this is a POST request
        if($this->request->isPost())
        {
            // Validate the form data posted
            if(!$form->isValid($this->request->getPost())){
                // If the form failed validation, add the errors to the flash error message.
                $this->flashEntityErrorMessages($form);
                return $this->response->redirect('orders');
            } else {
                $order = new Orders();

                // Form was validated successfully. Lets try to save user
                $data = $this->request->getPost();
                $data["user_id"] = $this->user->id;
                $success = $order->saveOne($data);

                // passing the result to the view
                if ($success) {
                    $this->flashSession->success('The order was created successfully!');
                    $this->response->redirect('orders/all');
                } else {
                    $this->flashEntityErrorMessages($order);
                    $this->response->redirect('orders');
                }
            }
        }
    }
}
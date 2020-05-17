<?php


class OrderItemsController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->tag->setTitle('OrderItems');
    }

    public function allAction($id)
    {
        $order = Orders::findFirstById($id);
        $this->view->setVars([
            'items' => $order->getItems(),
            'id' => $id
        ]);
    }
    
    public function indexAction($id)
    {
        $this->view->setVars([
            'id' => $id
        ]);
    }

    public function createAction($id)
    {
        $form = new OrderItemForm();

        if(!$this->isCsrfTokenPosted())
            return $this->response->redirect('orders/'.$id.'/item');
        // Check to see if this is a POST request
        if($this->request->isPost())
        {
            // Validate the form data posted
            if(!$form->isValid($this->request->getPost())){
                // If the form failed validation, add the errors to the flash error message.
                $this->flashEntityErrorMessages($form);
                return $this->response->redirect('orders/'.$id.'/item');
            } else {
                $orderItem = new OrderItems();
                $order = Orders::findFirstById($id);

                // Form was validated successfully. Lets try to save user
                $data = $this->request->getPost();
                $data["order_id"] = $order->id;
                $success = $orderItem->saveOne($data);

                // passing the result to the view
                if ($success) {
                    $this->flashSession->success('The order item was created successfully!');
                    $this->response->redirect('orders/'.$id.'/items');
                } else {
                    $this->flashEntityErrorMessages($orderItem);
                    $this->response->redirect('orders/'.$id.'/item');
                }
            }
        }
    }
}
<?php
namespace Application\Controller;

use Application\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class SessionManagerController extends AbstractCrudController
{
    protected $searchDefaultParams = array('sort' => 'id');
    protected $serviceName = 'Application\Service\SessionManager';
    protected $route = 'admin/session';
    
    public function viewAction()
    {
        $id = (string) $this->params()->fromRoute('id', 0);
    
        $viewModel = new ViewModel(array(
            'session' => $this->getService()->getById($id)
        ));
    
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    public function addAction()
    {
        return $this->redirect()->toRoute($this->getRoute());
    }
    
    public function editAction()
    {
        return $this->redirect()->toRoute($this->getRoute());
    }
}
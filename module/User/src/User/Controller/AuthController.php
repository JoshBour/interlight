<?php
namespace User\Controller;

use Application\Controller\BaseController;
use User\Entity\User;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class AuthController extends BaseController
{
    const CONTROLLER_NAME = "User\Controller\Auth";
    const ROUTE_LOGIN = "login";
    const ROUTE_PRODUCTS = "products";
    const LAYOUT_ADMIN = "layout/admin";

    /**
     * The authentication service.
     *
     * @var AuthenticationService
     */
    private $authService = null;

    /**
     * The authentication storage.
     *
     * @var \User\Model\AuthStorage
     */
    private $authStorage = null;

    /**
     * The login form
     *
     * @var \Zend\Form\Form
     */
    private $loginForm;

    /**
     * The login action
     * Route: /login
     *
     * @return mixed|\Zend\Http\Response|ViewModel
     */
    public function loginAction()
    {

        if (!$this->identity()) {
            $this->layout()->setTemplate(self::LAYOUT_ADMIN);
            $loginForm = $this->getForm('login');
            /**
             * @var $request \Zend\Http\Request
             */
            $request = $this->getRequest();
            if ($request->isPost()) {
                $data = $request->getPost();
                $authService = $this->getAuthService();
                $success = $authService->login($loginForm,$data);
                if($success){
                    return $this->forward()->dispatch(static::CONTROLLER_NAME,array(
                        'action' => 'authenticate',
                        "username" => $data["admin"]["username"],
                        "password" => $data["admin"]["password"],
                        "remember" => $data['admin']['rememberMe'],
                        "redirect" => "login"
                    ));
                }
            }
            return new ViewModel(array(
                'form' => $loginForm,
                "pageTitle" => "Login",
                "noAds" => true,
                "hideHeader" => true
            ));
        } else {
            return $this->redirect()->toRoute(self::ROUTE_PRODUCTS);
        }
    }

    public function authenticateAction(){
        $service = $this->getAuthService();
        $result = $service->authenticate($this->params()->fromRoute('username'),
            $this->params()->fromRoute('password'),
            $this->params()->fromRoute('remember'));
        if($result){
            return $this->redirect()->toRoute(self::ROUTE_PRODUCTS);
        }else{
            return $this->redirect()->toRoute($this->params()->fromRoute("redirect"));
        }

    }

    /**
     * The logout action
     * Route: /logout
     *
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        if ($this->identity()) {
            $this->getAuthStorage()->forgetMe();
            $this->getService('zendAuth')->clearIdentity();
        }
        return $this->redirect()->toRoute(static::ROUTE_LOGIN);
    }

    /**
     * Get the authentication service
     *
     * @return \User\Service\Auth
     */
    public function getAuthService()
    {
        if (null === $this->authService) {
            $this->authService = $this->getService('auth');
        }
        return $this->authService;
    }

    /**
     * Get the auth storage
     *
     * @return \User\Model\AuthStorage
     */
    public function getAuthStorage()
    {
        if (null === $this->authStorage) {
            $this->authStorage = $this->getServiceLocator()->get('authStorage');
        }
        return $this->authStorage;
    }
}

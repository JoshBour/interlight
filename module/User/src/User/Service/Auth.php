<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 30/5/2015
 * Time: 7:06 μμ
 */

namespace User\Service;


use Application\Service\BaseService;
use Doctrine\ORM\EntityRepository;
use User\Entity\User;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

/**
 * Class AuthService
 * @package User\Service
 * @method EntityRepository getUserRepository($namespace)
 */
class Auth extends BaseService{

    private $authStorage;

    private $messages;

    private $zendAuthService;

    /**
     * @param \Zend\Form\Form $form
     * @param $data
     * @return bool
     */
    public function login(&$form,$data){
        $user = new User();
        $form->bind($user);
        $form->setData($data);
        if ($form->isValid()) {
            return true;
        }else{
            return false;
        }
    }

    public function authenticate($username,$password,$remember){
        $authService = $this->getZendAuthService();
        $vocabulary = $this->getVocabulary();
        $translator = $this->getTranslator();
        /**
         * @var $adapter \Zend\Authentication\Adapter\AbstractAdapter
         */
        $adapter = $authService->getAdapter();

        $adapter->setIdentityValue($username);
        $adapter->setCredentialValue($password);
        $authResult = $authService->authenticate();
        if ($authResult->isValid()) {
            if ($remember == 1) {
                $this->getAuthStorage()->setRememberMe(1);
            }
            $identity = $authResult->getIdentity();
            $authService->getStorage()->write($identity);
        } else {
            $this->getFlashMessenger()->addMessage($translator->translate($vocabulary["MESSAGE_INVALID_CREDENTIALS"]));
            return false;
        }
        $this->getFlashMessenger()->addMessage($translator->translate($vocabulary["MESSAGE_WELCOME"]) . ', ' . $username);
        return true;
    }

    public function getMessages(){
        return $this->messages;
    }

    private function getAuthStorage(){
        if(null == $this->authStorage)
            $this->authStorage = $this->getServiceManager()->get('authStorage');
        return $this->authStorage;
    }

    private function getZendAuthService(){
        if(null === $this->zendAuthService)
            $this->zendAuthService = $this->getServiceManager()->get('zendAuthService');
        return $this->zendAuthService;
    }
}
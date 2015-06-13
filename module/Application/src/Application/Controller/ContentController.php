<?php
namespace Application\Controller;

use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;

/**
 * Class PartnerController
 * @package Application\Controller
 * @method string translate($string)
 * @method Request getRequest()
 */
class ContentController extends BaseController
{
    const LAYOUT_ADMIN = "layout/admin";

    public function listAction(){
        if ($this->identity()) {
            $this->layout()->setTemplate(self::LAYOUT_ADMIN);
            return new ViewModel(array(
                "contents" => $this->getRepository('application','content')->findAll(),
            ));
        }
        return $this->notFoundAction();
    }

    public function saveAction(){
        if ($this->getRequest()->isXmlHttpRequest() && $this->identity()) {
            $success = 1;
            $message = $this->translate($this->vocabulary["MESSAGE_CONTENTS_SAVED"]);
            $entities = $this->params()->fromPost('entities');
            if (!$this->getService('content')->save($entities)) {
                $success = 0;
                $message = $this->translate($this->vocabulary["ERROR_CONTENTS_NOT_SAVED"]);
            }
            return new JsonModel(array(
                "success" => $success,
                "message" => $message
            ));
        } else {
            return $this->notFoundAction();
        }
    }
}

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

    public function listAction()
    {
        if ($this->identity()) {
            $this->layout()->setTemplate(self::LAYOUT_ADMIN);
            return new ViewModel(array(
                "contents" => $this->getRepository('application', 'content')->findAll(),
            ));
        }
        return $this->notFoundAction();
    }

    public function saveAction()
    {
        /**
         * @var \Zend\Http\Request $request
         */
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $this->identity()) {
            $contentService = $this->getService('content');
            $data = $request->getPost();
            $success = $contentService->save($data) ? 1 : 0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $contentService->getMessage()
            ));
        } else {
            return $this->notFoundAction();
        }
    }
}

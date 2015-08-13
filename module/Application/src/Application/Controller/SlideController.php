<?php
namespace Application\Controller;

use Zend\Http\Request;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class SlideController
 * @package Application\Controller
 * @method string translate($string)
 * @method Request getRequest()
 */
class SlideController extends BaseController
{
    const LAYOUT_ADMIN = "layout/admin";
    const ROUTE_ADD_SLIDE = "slides/add";

    /**
     * The slide form
     *
     * @var \Zend\Form\Form
     */
    private $slideForm;

    /**
     * The slide service
     *
     * @var \Application\Service\SlideService
     */
    private $slideService;

    public function loadAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $this->identity()) {
            $params = $request->getQuery();

            $service = $this->getSlideService();


            $limit = $params->get("limit", 10);
            $page = $params->get("page", 1);
            $sort = $params->get("sort",null);
            $search = $params->get("search",null);


            $viewModel = new ViewModel(array(
                "paginator" => $service->load($limit, $page, $sort, $search),
            ));
            $viewModel->setTerminal(true);
            return $viewModel;
        }
        return $this->notFoundAction();
    }

    public function listAction()
    {
        if ($this->identity()) {
            $this->layout()->setTemplate(self::LAYOUT_ADMIN);
            return new ViewModel(array(
                "paginator" => $this->getSlideService()->load(),
            ));
        }
        return $this->notFoundAction();
    }

    public function addAction()
    {
        $request = $this->getRequest();
        if ($this->identity()) {
            $this->layout()->setTemplate(self::LAYOUT_ADMIN);
            $form = $this->getSlideForm();
            if ($request->isPost()) {
                $service = $this->getSlideService();
                $data = array_merge_recursive(
                    $request->getPost()->toArray(),
                    $request->getFiles()->toArray()
                );
                if ($service->create($data, $form)) {
                    $this->flashMessenger()->addMessage($service->getMessage());

                    return $this->redirect()->toRoute(self::ROUTE_ADD_SLIDE);
                }
            }
            return new ViewModel(array(
                "form" => $form,
                "activeRoute" => "slides",
                "pageTitle" => "Interlight - Add Slide"
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
            $slideService = $this->getSlideService();
            $data = $request->getPost();
            $success = $slideService->save($data) ? 1 : 0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $slideService->getMessage()
            ));
        } else {
            return $this->notFoundAction();
        }
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isXmlHttpRequest() && $this->identity()) {
            $id = $this->params()->fromPost("entityId");
            $slideService = $this->getSlideService();
            $success = $this->getSlideService()->remove($id) ? 1 : 0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $slideService->getMessage()
            ));
        }
        return $this->notFoundAction();
    }

    /**
     * Get the slide form
     *
     * @return \Zend\Form\Form
     */
    public function getSlideForm()
    {
        if (null === $this->slideForm)
            $this->slideForm = $this->getForm('slide');
        return $this->slideForm;
    }

    /**
     * Get the slide service
     *
     * @return \Application\Service\SlideService
     */
    public function getSlideService()
    {
        if (null === $this->slideService)
            $this->slideService = $this->getService('slide');
        return $this->slideService;
    }
}

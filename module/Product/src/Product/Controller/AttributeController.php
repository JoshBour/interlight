<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 29/6/2014
 * Time: 6:40 μμ
 */

namespace Product\Controller;


use Application\Controller\BaseController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;

/**
 * Class AttributeController
 * @package Product\Controller
 * @method string translate($string)
 * @method Request getRequest()
 */
class AttributeController extends BaseController
{

    const LAYOUT_ADMIN = "layout/admin";
    const ROUTE_ADD_ATTRIBUTE = "attributes/add";

    private $attributeForm;

    private $attributeRepository;

    private $attributeService;

    public function addAction()
    {
        /**
         * @var \Zend\Http\Request $request
         */
        $request = $this->getRequest();
        if ($this->identity()) {
            $this->layout()->setTemplate(self::LAYOUT_ADMIN);
            $form = $this->getAttributeForm();
            if ($request->isPost()) {
                $service = $this->getAttributeService();
                $data = array_merge_recursive(
                    $request->getPost()->toArray(),
                    $request->getFiles()->toArray()
                );
                if ($service->create($data, $form)) {
                    $this->flashMessenger()->addMessage($service->getMessage());

                    return $this->redirect()->toRoute(self::ROUTE_ADD_ATTRIBUTE);
                }
            }
            return new ViewModel(array(
                "form" => $form,
                "activeRoute" => "attributes",
                "pageTitle" => "Interlight - Add Attribute"
            ));
        }
        return $this->notFoundAction();
    }

    public function loadAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $this->identity()) {
            $params = $request->getQuery();

            $service = $this->getAttributeService();


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
                "paginator" => $this->getAttributeService()->load(),
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
            $attributeService = $this->getAttributeService();
            $data = $request->getPost();
            $success = $attributeService->save($data) ? 1 : 0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $attributeService->getMessage()
            ));
        } else {
            return $this->notFoundAction();
        }
    }

    public function deleteAction()
    {
        /**
         * @var \Zend\Http\Request $request
         */
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $this->identity()) {
            $id = $this->params()->fromPost("entityId");
            $service = $this->getAttributeService();
            $success = $service->remove($id) ? 1 : 0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $service->getMessage()
            ));
        }
        return $this->notFoundAction();
    }

    /**
     * @return \Zend\Form\Form
     */
    public function getAttributeForm()
    {
        if (null === $this->attributeForm)
            $this->attributeForm = $this->getForm('attribute');
        return $this->attributeForm;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getAttributeRepository()
    {
        if (null === $this->attributeRepository)
            $this->attributeRepository = $this->getRepository('product', 'attribute');
        return $this->attributeRepository;
    }

    /**
     * @return \Product\Service\AttributeService
     */
    public function getAttributeService()
    {
        if (null === $this->attributeService)
            $this->attributeService = $this->getService('attribute');
        return $this->attributeService;
    }
} 
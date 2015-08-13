<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 30/6/2014
 * Time: 12:04 πμ
 */

namespace Application\Controller;


use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;

/**
 * Class AboutController
 * @package Application\Controller
 * @method string translate($string)
 * @method Request getRequest()
 */
class AboutController extends BaseController
{
    const LAYOUT_ADMIN = "layout/admin";
    const ROUTE_ADD_ABOUT_CATEGORY = "about/add";

    private $aboutCategoryForm;

    private $aboutCategoryRepository;

    private $aboutCategoryService;

    public function indexAction()
    {
        $aboutCategoryRepository = $this->getAboutCategoryRepository();
        $aboutCategories = $aboutCategoryRepository->findAll();
        $category = $this->params()->fromRoute("category");
//        if ($category == "partners") {
//            $aboutCategory = $this->getRepository('application', 'partner')->findAll();
//        } else
        if ($category == 'first') {
            $firstCategory = $aboutCategoryRepository->findBy(array(), array(), 1);
            $aboutCategory = $firstCategory[0];
            $category = $aboutCategory->getUrl();
        } else {
            $aboutCategory = $aboutCategoryRepository->findOneBy(array("url" => $category));
        }
        return new ViewModel(array(
            "aboutCategories" => $aboutCategories,
            "aboutCategory" => $aboutCategory,
            "activeCategory" => $category,
            "bodyClass" => "aboutPage blackLayout",
            "useBlackLayout" => true,
            "pageTitle" => "Interlight - About Us"
        ));
    }

    public function loadAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $this->identity()) {
            $params = $request->getQuery();

            $service = $this->getAboutCategoryService();


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
                "paginator" => $this->getAboutCategoryService()->load(),
            ));
        }
        return $this->notFoundAction();
    }

    public function addAction()
    {
        $request = $this->getRequest();
        if ($this->identity()) {
            $this->layout()->setTemplate(self::LAYOUT_ADMIN);
            $form = $this->getAboutCategoryForm();
            if ($request->isPost()) {
                $service = $this->getAboutCategoryService();
                if ($service->create($request->getPost(), $form)) {
                    $this->flashMessenger()->addMessage($service->getMessage());

                    return $this->redirect()->toRoute(self::ROUTE_ADD_ABOUT_CATEGORY);
                }
            }
            return new ViewModel(array(
                "form" => $form,
                "activeRoute" => "about",
                "pageTitle" => "Interlight - Add About Category"
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
            $aboutService = $this->getAboutCategoryService();
            $data = $request->getPost();
            $success = $aboutService->save($data) ? 1 : 0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $aboutService->getMessage()
            ));
        } else {
            return $this->notFoundAction();
        }
    }

    public function removeAction()
    {
        if ($this->getRequest()->isXmlHttpRequest() && $this->identity()) {
            $id = $this->params()->fromPost("entityId");
            $aboutService = $this->getAboutCategoryService();
            $success = $aboutService->remove($id) ? 1 : 0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $aboutService->getMessage()
            ));
        }
        return $this->notFoundAction();
    }

    /**
     * @return \Zend\Form\Form
     */
    public function getAboutCategoryForm()
    {
        if (null === $this->aboutCategoryForm)
            $this->aboutCategoryForm = $this->getForm('aboutCategory');
        return $this->aboutCategoryForm;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getAboutCategoryRepository()
    {
        if (null === $this->aboutCategoryRepository)
            $this->aboutCategoryRepository = $this->getRepository('application', 'aboutCategory');
        return $this->aboutCategoryRepository;
    }

    /**
     * @return \Application\Service\AboutCategoryService
     */
    public function getAboutCategoryService()
    {
        if (null === $this->aboutCategoryService)
            $this->aboutCategoryService = $this->getService('aboutCategory');
        return $this->aboutCategoryService;
    }
} 
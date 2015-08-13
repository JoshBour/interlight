<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 7/6/2014
 * Time: 4:16 μμ
 */

namespace Product\Controller;


use Application\Controller\BaseController;
use Application\Validator\Image;
use Zend\Http\Request;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class CategoryController
 * @package Product\Controller
 * @method string translate($string)
 * @method Request getRequest()
 */
class CategoryController extends BaseController
{

    const LAYOUT_ADMIN = "layout/admin";
    const ROUTE_ADD_CATEGORY = "categories/add";

    /**
     * The category form
     *
     * @var \Zend\Form\Form
     */
    private $categoryForm;

    /**
     * The category repository
     *
     * @var \Doctrine\ORM\EntityRepository
     */
    private $categoryRepository;

    /**
     * The category service
     *
     * @var \Product\Service\CategoryService
     */
    private $categoryService;

    public function indexAction()
    {
        $url = $this->params()->fromRoute("categoryUrl");
        if ($url) {
            /**
             * @var \Product\Entity\Category $category
             */
            $category = $this->getCategoryRepository()->findOneBy(array('url' => $url));
            if ($category) {
                $categories = array_merge(array($category), $category->getChildren()->toArray());

                if ($category) {
                    return new ViewModel(array(
                        "activeRoute" => "products_index",
                        "activeCategory" => $category,
                        "categories" => $categories,
                        "pageTitle" => "Interlight - " . $category->getName()
                    ));
                }
            }
        }
        return $this->notFoundAction();
    }

    public function loadAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $this->identity()) {
            $params = $request->getQuery();

            $service = $this->getCategoryService();


            $limit = $params->get("limit", 10);
            $page = $params->get("page", 1);
            $sort = $params->get("sort",null);
            $search = $params->get("search",null);


            $viewModel = new ViewModel(array(
                "paginator" => $service->load($limit, $page, $sort, $search),
                "categoriesSelect" => $this->getCategoryRepository()->findNameAndId(),
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
            $categoryRepository = $this->getCategoryRepository();
            return new ViewModel(array(
                "paginator" => $this->getCategoryService()->load(),
                "categoriesSelect" => $categoryRepository->findNameAndId(),
            ));
        }
        return $this->notFoundAction();
    }

    public function addAction()
    {
        $request = $this->getRequest();
        if ($this->identity()) {
            $this->layout()->setTemplate(self::LAYOUT_ADMIN);
            $form = $this->getCategoryForm();
            if ($request->isPost()) {
                $service = $this->getCategoryService();
                $data = array_merge_recursive(
                    $request->getPost()->toArray(),
                    $request->getFiles()->toArray()
                );
                if ($service->create($data, $form)) {
                    $this->flashMessenger()->addMessage($service->getMessage());

                    return $this->redirect()->toRoute(self::ROUTE_ADD_CATEGORY);
                }
            }
            return new ViewModel(array(
                "form" => $form,
                "activeRoute" => "categories",
                "pageTitle" => "Interlight - Add Category"
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
            $categoryService = $this->getCategoryService();
            $data = $request->getPost();
            $success = $categoryService->save($data) ? 1 : 0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $categoryService->getMessage()
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
            $categoryService = $this->getCategoryService();
            $success = $categoryService->remove($id) ? 1 : 0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $categoryService->getMessage()
            ));
        }
        return $this->notFoundAction();
    }

    /**
     * Get the category form
     *
     * @return \Zend\Form\Form
     */
    public function getCategoryForm()
    {
        if (null === $this->categoryForm)
            $this->categoryForm = $this->getForm('category');
        return $this->categoryForm;
    }

    /**
     * Get the category repository
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getCategoryRepository()
    {
        if (null === $this->categoryRepository)
            $this->categoryRepository = $this->getRepository('product', 'category');
        return $this->categoryRepository;
    }

    /**
     * Get the category service
     *
     * @return \Product\Service\CategoryService
     */
    public function getCategoryService()
    {
        if (null === $this->categoryService)
            $this->categoryService = $this->getService('category');
        return $this->categoryService;
    }
} 
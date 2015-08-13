<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 4/6/2014
 * Time: 1:21 πμ
 */

namespace Product\Controller;


use Application\Controller\BaseController;
use Application\Model\FileUtils;
use Doctrine\ORM\EntityRepository;
use Product\Entity\Product;
use Zend\Http\Request;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Product\Controller
 * @method string translate($string)
 * @method Request getRequest()
 */
class IndexController extends BaseController
{
    const LAYOUT_ADMIN = "layout/admin";
    const ROUTE_ADD_PRODUCT = "products/add";

    private $categoryRepository;

    private $productForm;

    private $productRepository;

    private $productService;

    public function indexAction()
    {
        $categories = $this->getCategoryRepository()->findBy(array("parentCategory" => null), array("position" => "ASC"));
        return new ViewModel(array(
            "categories" => $categories,
            "useBlackLayout" => true,
            "bodyClass" => "blackLayout",
            "pageTitle" => "Interlight - Products"
        ));
    }

    public function viewAction()
    {
        $categoryUrl = $this->params()->fromRoute("categoryUrl",null);
        $productNumber = $this->params()->fromRoute("productNumber",null);
        if($productNumber){
            $category = $this->getCategoryRepository()->findOneBy(array("url"=>$categoryUrl));
            $product = $this->getProductRepository()->findOneBy(array("productNumber"=>$productNumber));
            return new ViewModel(array(
                "category" => $category,
                "product" => $product,
                "activeRoute" => "products_index",
                "bodyClass" => "productPage",
                "pageTitle" => "Interlight - " . $product->getName(),
                "tab" => $this->params()->fromRoute("tab")
            ));
        }
        return $this->notFoundAction();
    }

    public function searchAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $viewModel = new ViewModel();
            $viewModel->setTerminal(true);
            $value = $this->params()->fromRoute("value");
            $products = $this->getProductRepository()->searchAll($value);
            $viewModel->setVariable("products",$products );
//            var_dump($products);
            return $viewModel;
        }
        return $this->notFoundAction();
    }

    public function loadAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $this->identity()) {
            $params = $request->getQuery();

            $service = $this->getProductService();


            $limit = $params->get("limit", 10);
            $page = $params->get("page", 1);
            $sort = $params->get("sort",null);
            $search = $params->get("search",null);


            $viewModel = new ViewModel(array(
                "paginator" => $service->load($limit, $page, $sort, $search),
                "categories" => $this->getCategoryRepository()->findNameAndId(),
                "attributes" => $this->getRepository("product","attribute")->findAll(),
                "productsAssoc" => $this->getProductRepository()->findAssoc()
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
            $params = $this->params();
//            $productRepository = $this->getProductRepository();

            $limit = $params->fromRoute("limit", 10);
            $page = $params->fromQuery("page");
            $sort = $params->fromRoute("sort");
            $search = $params->fromRoute("search");

            return new ViewModel(array(
                "attributes" => $this->getRepository('product','attribute')->findAll(),
                "categories" => $this->getCategoryRepository()->findNameAndId(),
                "paginator" => $this->getProductService()->load(),
                "productsAssoc" => $this->getProductRepository()->findAssoc()
            ));
        }
        return $this->notFoundAction();
    }

    public function addAction()
    {
        $request = $this->getRequest();
        if ($this->identity()) {
            $this->layout()->setTemplate(self::LAYOUT_ADMIN);
            $form = $this->getProductForm();

            if ($request->isPost()) {
                $service = $this->getProductService();
                $data = array_merge_recursive(
                    $request->getPost()->toArray(),
                    $request->getFiles()->toArray()
                );

                if ($service->create($data, $form)) {
                    $this->flashMessenger()->addMessage($service->getMessage());

                    return $this->redirect()->toRoute(self::ROUTE_ADD_PRODUCT);
                }
            }
            return new ViewModel(array(
                "form" => $form,
                "encodedAttributes" => isset($data['product']['attributes']) ? $data['product']['attributes'] : array(),
                "activeRoute" => "products",
                "pageTitle" => "Interlight - Add Product"
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
            $productService = $this->getProductService();
            $data = $request->getPost();
            $success = $productService->save($data) ? 1 : 0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $productService->getMessage()
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
            $productService = $this->getProductService();
            $success = $productService->remove($id) ? 1 : 0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $productService->getMessage()
            ));
        }
        return $this->notFoundAction();
    }

    /**
     * Get the category repository
     *
     * @return \Product\Repository\CategoryRepository
     */
    public function getCategoryRepository()
    {
        if (null == $this->categoryRepository)
            $this->categoryRepository = $this->getRepository('product','category');
        return $this->categoryRepository;
    }

    /**
     * Get the product form
     *
     * @return \Zend\Form\Form
     */
    public function getProductForm()
    {
        if (null === $this->productForm)
            $this->productForm = $this->getForm('product');
        return $this->productForm;
    }

    /**
     * Get the product repository
     *
     * @return \Product\Repository\ProductRepository
     */
    public function getProductRepository()
    {
        if (null === $this->productRepository)
            $this->productRepository = $this->getRepository('product','product');
        return $this->productRepository;
    }

    /**
     * Get the product service
     *
     * @return \Product\Service\ProductService
     */
    public function getProductService()
    {
        if (null === $this->productService)
            $this->productService = $this->getService('product');
        return $this->productService;
    }
} 
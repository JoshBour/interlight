<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 4/6/2014
 * Time: 1:21 πμ
 */

namespace Post\Controller;


use Application\Controller\BaseController;
use Zend\Http\Request;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Post\Controller
 * @method string translate($string)
 * @method Request getRequest()
 */
class IndexController extends BaseController
{
    const LAYOUT_ADMIN = "layout/admin";
    const ROUTE_ADD_POST = "posts/add";

    /**
     * The post form
     *
     * @var \Zend\Form\Form
     */
    private $postForm;

    /**
     * Get the post repository
     *
     * @var \Doctrine\ORM\EntityRepository
     */
    private $postRepository;

    /**
     * Get the post service
     *
     * @var \Post\Service\PostService
     */
    private $postService;

    public function indexAction()
    {
        $page = $this->params()->fromRoute("page", 1);
        $posts = new Paginator(new ArrayAdapter($this->getPostRepository()->findBy(array(), array("postDate" => "DESC"))));
        $posts->setCurrentPageNumber($page)
            ->setItemCountPerPage(6);
        return new ViewModel(array(
            "pageTitle" => "Interlight - Latest News",
            "bodyClass" => "postsPage blackLayout",
            "posts" => $posts,
        ));
    }

    public function viewAction()
    {
        $postUrl = $this->params()->fromRoute("postUrl");
        if ($postUrl) {
            $post = $this->getPostRepository()->findOneBy(array("url" => $postUrl));
            if ($post) {
                return new ViewModel(array(
                    "bodyClass" => "blackLayout",
                    "post" => $post,
                    "activeRoute" => "posts_index",
                    "pageTitle" => "Interlight - " . $post->getTitle()
                ));
            }
        }
        return $this->notFoundAction();
    }

    public function loadAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $this->identity()) {
            $params = $request->getQuery();

            $service = $this->getPostService();


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
                "paginator" => $this->getPostService()->load(),
            ));
        }
        return $this->notFoundAction();
    }

    public function addAction()
    {
        $request = $this->getRequest();
        if ($this->identity()) {
            $this->layout()->setTemplate(self::LAYOUT_ADMIN);
            $form = $this->getPostForm();
            if ($request->isPost()) {
                $service = $this->getPostService();
                $data = array_merge_recursive(
                    $request->getPost()->toArray(),
                    $request->getFiles()->toArray()
                );
                if ($service->create($data, $form)) {
                    $this->flashMessenger()->addMessage($service->getMessage());

                    return $this->redirect()->toRoute(self::ROUTE_ADD_POST);
                }
            }
            return new ViewModel(array(
                "form" => $form,
                "activeRoute" => "posts",
                "pageTitle" => "Interlight - Add Post"
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
            $postService = $this->getPostService();
            $data = $request->getPost();
            $success = $postService->save($data) ? 1 : 0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $postService->getMessage()
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
            $postService = $this->getPostService();
            $success = $this->getPostService()->remove($id) ? 1:0;
            return new JsonModel(array(
                "success" => $success,
                "message" => $postService->getMessage()
            ));
        }
        return $this->notFoundAction();
    }

    /**
     * Get the post form
     *
     * @return \Zend\Form\Form
     */
    public function getPostForm()
    {
        if (null === $this->postForm)
            $this->postForm = $this->getForm('post');
        return $this->postForm;
    }

    /**
     * Get the post repository
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getPostRepository()
    {
        if (null === $this->postRepository)
            $this->postRepository = $this->getRepository('post', 'post');
        return $this->postRepository;
    }

    /**
     * Get the post service
     *
     * @return \Post\Service\PostService
     */
    public function getPostService()
    {
        if (null === $this->postService)
            $this->postService = $this->getService('post');
        return $this->postService;
    }
} 
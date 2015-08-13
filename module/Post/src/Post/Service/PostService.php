<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 4/6/2014
 * Time: 1:48 πμ
 */

namespace Post\Service;


use Application\Service\BaseService;
use Application\Service\FileUtils;
use Application\Service\FileUtilService;
use Doctrine\ORM\EntityRepository;
use Post\Entity\Post as PostEntity;
use Zend\Filter\File\Rename;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\Stdlib\ParametersInterface;

/**
 * Class Post
 * @package Post\Service
 */
class PostService extends BaseService{

    private $postRepository;

    /**
     * The current user
     *
     * @var \User\Entity\User
     */
    private $user;

    public function load($limit = 10, $page = 1, $sort = null, $search = null)
    {
        if(!empty($sort)){
            $params = explode(",",$sort);
            $sort = array("column" => $params[0],"type" => strtoupper($params[1]));
        }else{
            $sort = array();
        };
        $postRepository = $this->getPostRepository();
        if (empty($search) || trim($search) == false) {
            // the findby uses a different format
            if(!empty($sort)) $sort = array($sort["column"] => $sort["type"]);

            $products = $postRepository->findBy(array(), $sort);

            $paginator = new Paginator(new ArrayAdapter($products));
            $paginator->setCurrentPageNumber($page)
                ->setDefaultItemCountPerPage($limit);

            return $paginator;
        } else {
            return $postRepository->search($search,$page,$limit,$sort);
        }
    }

    /**
     * Create a new post
     *
     * @param array $data
     * @param \Zend\Form\Form $form
     * @return bool
     */
    public function create($data, &$form){
        $post = new PostEntity();
        $em = $this->getEntityManager();

        $form->bind($post);
        $form->setData($data);
        if (!$form->isValid()) return false;

        // we rename the file with a unique name
        $newName = FileUtilService::rename($data['post']['thumbnail'], 'images/posts', "post");
        $post->setThumbnail($newName);

        $post->setUser($this->getUser());
        $post->setPostDate("now");
        $post->setUrl($this->getPostUrl($post));
        try {
            $em->persist($post);
            $em->flush();
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_POST_CREATED"]);
            return true;
        } catch (\Exception $e) {
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_POST_NOT_CREATED"]);
            return false;
        }
    }

    public function save(ParametersInterface $data)
    {
        $em = $this->getEntityManager();
        $attribute = $data->get('attribute');
        $primaryKey = $data->get('primaryKey');
        $content = $data->get('content') ? $data->get('content') : null;
        $constraints = $data->get('constraints', null);
        $repository = $this->getRepository('post','post');
        if ($constraints)
            $constraints = json_decode(str_replace('\\', '\\\\', $constraints), true);

        if ($primaryKey) {
            $entity = $repository->find($primaryKey);
            if ($entity) {
                $filter = $this->getServiceManager()->get('postFilter')->filter($attribute, $content);
                if ($filter->isValid()) {
                    if (!empty($constraints) && $content) {
                        foreach ($constraints as $constraint) {
                            if ($constraint["type"] == "foreign") {
                                $content = $em->getReference($constraint["target"], $content);
                            }
                        }
                    }
                    $entity->{'set' . ucfirst($attribute)}($content);
                    try {
                        $em->persist($entity);
                        $em->flush();
                        $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_POST_SAVED"]);
                        return true;
                    } catch (\Exception  $e) {
                        $this->message = $this->getTranslator()->translate($this->getVocabulary()["ERROR_POST_NOT_SAVED"]);
                    }
                } else {
                    $this->message = $filter->getMessages()[$attribute];
                }
            }
        }
        return false;
    }


    /**
     * Removes a post from the database
     *
     * @param int $id
     * @return bool
     */
    public function remove($id)
    {
        $em = $this->getEntityManager();
        $post = $this->getPostRepository('post')->find($id);
        if ($post) {
            try {
                if ($thumbnail = $post->getThumbnail())
                    FileUtilService::deleteFile(FileUtilService::getFilePath($thumbnail, 'image', 'posts'));
                $em->remove($post);
                $em->flush();
                $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_POST_REMOVED"]);
                return true;
            } catch (\Exception $e) {
                $this->message = $this->getTranslator()->translate($this->getVocabulary()["ERROR_POST_NOT_REMOVED"]);
                return false;
            }
        }
        return false;
    }

    /**
     * Get the post url
     *
     * @param \Post\Entity\Post $post
     * @return string
     */
    private function getPostUrl($post){
        $encodedUrl = $post->encodeUrl();
        $posts = $this->getPostRepository('post')->findBy(array("url" => $encodedUrl));
        return count($posts) > 0 ? $encodedUrl.'-'.(count($posts)+1):$encodedUrl;
    }

    /**
     * Get the current user
     *
     * @return \User\Entity\User
     */
    public function getUser(){
        if(null === $this->user)
            $this->user = $this->getServiceManager()->get('ControllerPluginManager')->get('user')->getUser();
        return $this->user;
    }

    /**
     * @return \Post\Repository\PostRepository
     */
    private function getPostRepository(){
        if(null === $this->postRepository)
            $this->postRepository = $this->getRepository('post','post');
        return $this->postRepository;
    }
} 
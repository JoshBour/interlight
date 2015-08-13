<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 4/6/2014
 * Time: 1:48 πμ
 */

namespace Application\Service;


use Application\Entity\AboutCategory as AboutCategoryEntity;
use Doctrine\ORM\EntityRepository;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Stdlib\ParametersInterface;

/**
 * Class Slide
 * @package Post\Service
 */
class AboutCategoryService extends BaseService
{
    private $aboutCategoryRepository;

    /**
     * Create a new slide
     *
     * @param array $data
     * @param \Zend\Form\Form $form
     * @return bool
     */
    public function create($data, &$form)
    {
        $aboutCategory = new AboutCategoryEntity();
        $em = $this->getEntityManager();

        $form->bind($aboutCategory);
        $form->setData($data);
        if (!$form->isValid()) return false;
        $aboutCategory->setUrl($this->getUrl($aboutCategory));
        try {
            $em->persist($aboutCategory);
            $em->flush();
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_ABOUT_CATEGORY_CREATED"]);
            return true;
        } catch (\Exception $e) {
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_ABOUT_CATEGORY_NOT_CREATED"]);
            return false;
        }
    }

    public function load($limit = 10, $page = 1, $sort = null, $search = null)
    {
        if(!empty($sort)){
            $params = explode(",",$sort);
            $sort = array("column" => $params[0],"type" => strtoupper($params[1]));
        }else{
            $sort = array();
        };
        $aboutRepository = $this->getAboutCategoryRepository();
        if (empty($search) || trim($search) == false) {
            // the findby uses a different format
            if(!empty($sort)) $sort = array($sort["column"] => $sort["type"]);

            $about = $aboutRepository->findBy(array(), $sort);

            $paginator = new Paginator(new ArrayAdapter($about));
            $paginator->setCurrentPageNumber($page)
                ->setDefaultItemCountPerPage($limit);

            return $paginator;
        } else {
            return $aboutRepository->search($search,$page,$limit,$sort);
        }
    }

    public function save(ParametersInterface $data)
    {
        $em = $this->getEntityManager();
        $attribute = $data->get('attribute');
        $primaryKey = $data->get('primaryKey');
        $content = $data->get('content') ? $data->get('content') : null;
        $constraints = $data->get('constraints', null);
        $repository = $this->getRepository('application','aboutCategory');
        if ($constraints)
            $constraints = json_decode(str_replace('\\', '\\\\', $constraints), true);

        if ($primaryKey) {
            $entity = $repository->find($primaryKey);
            if ($entity) {
                $filter = $this->getServiceManager()->get('aboutCategoryFilter')->filter($attribute, $content);
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

                        $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_ABOUT_CATEGORY_SAVED"]);
                        $em->persist($entity);
                        $em->flush();
                        return true;
                    } catch (\Exception  $e) {
                        $this->message = $this->getTranslator()->translate($this->getVocabulary()["ERROR_ABOUT_CATEGORY_NOT_SAVED"]);
                    }
                } else {
                    $this->message = $filter->getMessages()[$attribute];
                }
            }
        }
        return false;
    }


    /**
     * Removes a about category from the database
     *
     * @param int $id
     * @return bool
     */
    public function remove($id)
    {
        $em = $this->getEntityManager();
        $aboutCategory = $this->getAboutCategoryRepository()->find($id);
        if ($aboutCategory) {
            try {
                $em->remove($aboutCategory);
                $em->flush();
                $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_ABOUT_CATEGORY_REMOVED"]);
                return true;
            } catch (\Exception $e) {
                $this->message = $this->getTranslator()->translate($this->getVocabulary()["ERROR_ABOUT_CATEGORY_NOT_REMOVED"]);
                return false;
            }
        }
        return false;
    }

    /**
     * Get the about category url
     *
     * @param \Application\Entity\AboutCategory $aboutCategory
     * @return string
     */
    private function getUrl($aboutCategory)
    {
        $encodedUrl = $aboutCategory->encodeUrl();
        $posts = $this->getAboutCategoryRepository('application')->findBy(array("url" => $encodedUrl));
        return count($posts) > 0 ? $encodedUrl . '-' . (count($posts) + 1) : $encodedUrl;
    }

    /**
     * @return \Application\Repository\AboutRepository
     */
    private function getAboutCategoryRepository(){
        if(null === $this->aboutCategoryRepository)
            $this->aboutCategoryRepository = $this->getRepository('application','aboutCategory');
        return $this->aboutCategoryRepository;
    }
} 
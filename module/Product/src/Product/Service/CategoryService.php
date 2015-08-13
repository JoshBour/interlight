<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 6/6/2014
 * Time: 3:32 μμ
 */

namespace Product\Service;


use Application\Service\BaseService;
use Application\Service\FileUtilService;
use Doctrine\DBAL\Exception\DriverException;
use Product\Entity\Category as CategoryEntity;
use Product\Model\InvalidArgumentException;
use Zend\Filter\File\Rename;
use Zend\Http\PhpEnvironment\Request;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\Stdlib\ParametersInterface;
use Zend\Validator;
use ZendTest\XmlRpc\Server\Exception;

/**
 * Class Category
 * @package Product\Service
 */
class CategoryService extends BaseService
{
    private $categoryRepository;

    public function load($limit = 10, $page = 1, $sort = null, $search = null)
    {
        if(!empty($sort)){
            $params = explode(",",$sort);
            $sort = array("column" => $params[0],"type" => strtoupper($params[1]));
        }else{
            $sort = array();
        };
        $categoryRepository = $this->getCategoryRepository();
        if (empty($search) || trim($search) == false) {
            // the findby uses a different format
            if(!empty($sort)) $sort = array($sort["column"] => $sort["type"]);

            $categories = $categoryRepository->findBy(array(), $sort);

            $paginator = new Paginator(new ArrayAdapter($categories));
            $paginator->setCurrentPageNumber($page)
                ->setDefaultItemCountPerPage($limit);

            return $paginator;
        } else {
            return $categoryRepository->search($search,$page,$limit,$sort);
        }
    }

    /**
     * Create a new category
     *
     * @param array $data
     * @param \Zend\Form\Form $form
     * @return bool
     */
    public function create($data, &$form)
    {
        $category = new CategoryEntity();
        $em = $this->getEntityManager();

        $form->bind($category);
        $form->setData($data);
        if (!$form->isValid()) return false;
        if (!empty($data['category']['parentCategory'])) {
            if ($parentCategory = $this->getCategoryRepository("product")->find($data['category']['parentCategory']))
                $category->setParentCategory($parentCategory);
        } else {
            $category->setParentCategory(null);
        }

        // we rename the file with a unique name
        $newName = FileUtilService::rename($data['category']['thumbnail'], 'images/categories', "category");
        $category->setThumbnail($newName);

        $category->setUrl($category->encodeUrl());
        try {
            $em->persist($category);
            $em->flush();
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_CATEGORY_CREATED"]);
            return true;
        } catch (\Exception $e) {
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_CATEGORY_NOT_CREATED"]);
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
        $categoryRepository = $this->getCategoryRepository('product');
        if ($constraints)
            $constraints = json_decode(str_replace('\\', '\\\\', $constraints), true);

        if ($primaryKey) {
            $category = $categoryRepository->find($primaryKey);
            if ($category) {
                $filter = $this->getServiceManager()->get('categoryFilter')->filter($attribute, $content);
                if ($filter->isValid()) {
                    if (!empty($constraints) && $content) {
                        foreach ($constraints as $constraint) {
                            if ($constraint["type"] == "foreign") {
                                $content = $em->getReference($constraint["target"], $content);
                            }
                        }
                    }
                    $category->{'set' . ucfirst($attribute)}($content);
                    try {

                        $em->persist($category);
                        $em->flush();
                        $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_CATEGORY_SAVED"]);
                        return true;
                    } catch (Exception  $e) {
                        $this->message = $this->getTranslator()->translate($this->getVocabulary()["ERROR_CATEGORY_NOT_SAVED"]);
                    }
                } else {
                    $this->message = $filter->getMessages()[$attribute];
                }
            }
        }
        return false;
    }

    /**
     * Remove a category from the database
     *
     * @param int $id
     * @return bool
     */
    public function remove($id)
    {
        $em = $this->getEntityManager();
        $category = $this->getCategoryRepository('product')->find($id);
        if ($category) {
            try {
                if ($thumbnail = $category->getThumbnail())
                    FileUtilService::deleteFile(FileUtilService::getFilePath($thumbnail, 'images', 'categories'));
                $em->remove($category);
                $em->flush();
                $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_CATEGORY_REMOVED"]);
                return true;
            } catch (\Exception $e) {
                $this->message = $this->getTranslator()->translate($this->getVocabulary()["ERROR_CATEGORY_NOT_REMOVED"]);
                return false;
            }
        }
        return false;
    }

    /**
     * @return \Product\Repository\CategoryRepository
     */
    private function getCategoryRepository()
    {
        if (null === $this->categoryRepository)
            $this->categoryRepository = $this->getRepository('product', 'category');
        return $this->categoryRepository;
    }

} 
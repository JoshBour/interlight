<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 6/6/2014
 * Time: 3:32 μμ
 */

namespace Product\Service;


use Application\Model\StringUtils;
use Application\Service\BaseService;
use Application\Service\FileUtils;
use Doctrine\ORM\EntityRepository;
use Product\Entity\Attribute as AttributeEntity;
use Zend\Filter\File\Rename;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\Stdlib\ParametersInterface;

/**
 * Class Attribute
 * @package Product\Service
 */
class AttributeService extends BaseService
{

    private $attributeRepository;

    public function load($limit = 10, $page = 1, $sort = null, $search = null)
    {
        if(!empty($sort)){
            $params = explode(",",$sort);
            $sort = array("column" => $params[0],"type" => strtoupper($params[1]));
        }else{
            $sort = array();
        };
        $attributeRepository = $this->getAttributeRepository();
        if (empty($search) || trim($search) == false) {
            // the findby uses a different format
            if(!empty($sort)) $sort = array($sort["column"] => $sort["type"]);

            $attributes = $attributeRepository->findBy(array(), $sort);

            $paginator = new Paginator(new ArrayAdapter($attributes));
            $paginator->setCurrentPageNumber($page)
                ->setDefaultItemCountPerPage($limit);

            return $paginator;
        } else {
            return $attributeRepository->search($search,$page,$limit,$sort);
        }
    }

    /**
     * Create a new product
     *
     * @param array $data
     * @param \Zend\Form\Form $form
     * @return bool
     */
    public function create($data, &$form)
    {
        $attribute = new AttributeEntity();
        $em = $this->getEntityManager();

        $form->bind($attribute);
        $form->setData($data);
        if (!$form->isValid()) return false;
        try {
            $em->persist($attribute);
            $em->flush();
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_ATTRIBUTE_CREATED"]);
            return true;
        } catch (\Exception $e) {
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_ATTRIBUTE_NOT_CREATED"]);
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
        $attributeRepository = $this->getAttributeRepository();
        if ($constraints)
            $constraints = json_decode(str_replace('\\', '\\\\', $constraints), true);

        if ($primaryKey) {
            $attributeEntity = $attributeRepository->find($primaryKey);
            if ($attributeEntity) {
                $filter = $this->getServiceManager()->get('attributeFilter')->filter($attribute, $content);
                if ($filter->isValid()) {
                    if (!empty($constraints) && $content) {
                        foreach ($constraints as $constraint) {
                            if ($constraint["type"] == "foreign") {
                                $content = $em->getReference($constraint["target"], $content);
                            }
                        }
                    }
                    $attributeEntity->{'set' . ucfirst($attribute)}($content);
                    try {
                        $em->persist($attributeEntity);
                        $em->flush();
                        $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_ATTRIBUTE_SAVED"]);
                        return true;
                    } catch (\Exception  $e) {
                        $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_ATTRIBUTE_NOT_SAVED"]);
                    }
                } else {
                    $this->message = $filter->getMessages()[$attribute];
                }
            }
        }else{
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_ATTRIBUTE_NOT_SAVED"]);
        }
        return false;
    }

    /**
     * Removes a product from the database
     *
     * @param int $id
     * @return bool
     */
    public function remove($id)
    {
        $em = $this->getEntityManager();
        $attribute = $this->getAttributeRepository()->find($id);
        if ($attribute) {
            try {
                $em->remove($attribute);
                $em->flush();
                $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_ATTRIBUTE_REMOVED"]);
                return true;
            } catch (\Exception $e) {
                $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_ATTRIBUTE_NOT_REMOVED"]);
                return false;
            }
        }
        return false;
    }

    /**
     * @return \Product\Repository\AttributeRepository
     */
    private function getAttributeRepository(){
        if(null === $this->attributeRepository)
            $this->attributeRepository = $this->getRepository('product','attribute');
        return $this->attributeRepository;
    }

} 
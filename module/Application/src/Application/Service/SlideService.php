<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 4/6/2014
 * Time: 1:48 πμ
 */

namespace Application\Service;


use Application\Entity\Slide as SlideEntity;
use Doctrine\ORM\EntityRepository;
use Zend\Filter\File\Rename;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\Stdlib\ParametersInterface;
use ZendTest\XmlRpc\Server\Exception;

/**
 * Class Slide
 * @package Post\Service
 */
class SlideService extends BaseService
{

    private $slideRepository;

    public function load($limit = 10, $page = 1, $sort = null, $search = null)
    {
        if(!empty($sort)){
            $params = explode(",",$sort);
            $sort = array("column" => $params[0],"type" => strtoupper($params[1]));
        }else{
            $sort = array();
        };
        $slideRepository = $this->getSlideRepository();
        if (empty($search) || trim($search) == false) {
            // the findby uses a different format
            if(!empty($sort)) $sort = array($sort["column"] => $sort["type"]);

            $slides = $slideRepository->findBy(array(), $sort);

            $paginator = new Paginator(new ArrayAdapter($slides));
            $paginator->setCurrentPageNumber($page)
                ->setDefaultItemCountPerPage($limit);

            return $paginator;
        } else {
            return $slideRepository->search($search,$page,$limit,$sort);
        }
    }

    /**
     * Create a new slide
     *
     * @param array $data
     * @param \Zend\Form\Form $form
     * @return bool
     */
    public function create($data, &$form)
    {
        $slide = new SlideEntity();
        $em = $this->getEntityManager();

        $form->bind($slide);
        $form->setData($data);
        if (!$form->isValid()) return false;

        // we rename the file with a unique name
        $newName = FileUtilService::rename($data['slide']['thumbnail'],'images/slides',"slide");
        $slide->setThumbnail($newName);

        try {
            $em->persist($slide);
            $em->flush();
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_SLIDE_CREATED"]);
            return true;
        } catch (\Exception $e) {
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_SLIDE_NOT_CREATED"]);
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
        $repository = $this->getRepository('application', 'slide');
        if ($constraints)
            $constraints = json_decode(str_replace('\\', '\\\\', $constraints), true);

        if ($primaryKey) {
            $entity = $repository->find($primaryKey);
            if ($entity) {
                $filter = $this->getServiceManager()->get('slideFilter')->filter($attribute, $content);
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
                        $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_SLIDE_SAVED"]);
                        return true;
                    } catch (\Exception  $e) {
                        $this->message = $this->getTranslator()->translate($this->getVocabulary()["ERROR_SLIDE_NOT_SAVED"]);
                    }
                } else {
                    $this->message = $filter->getMessages()[$attribute];
                }
            }
        }
        return false;
    }


    /**
     * Removes a slide from the database
     *
     * @param int $id
     * @return bool
     */
    public function remove($id)
    {
        $em = $this->getEntityManager();
        $slide = $this->getSlideRepository('application')->find($id);
        if ($slide) {
            try {
                if ($thumbnail = $slide->getThumbnail())
                    FileUtilService::deleteFile(FileUtilService::getFilePath($thumbnail, 'images', 'slides'));
                $em->remove($slide);
                $em->flush();
                $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_SLIDE_REMOVED"]);
                return true;
            } catch (\Exception $e) {
                $this->message = $this->getTranslator()->translate($this->getVocabulary()["ERROR_SLIDE_NOT_REMOVED"]);
                return false;
            }
        }
        return false;
    }

    private function getSlideRepository()
    {
        if (null === $this->slideRepository)
            $this->slideRepository = $this->getRepository('application', 'slide');
        return $this->slideRepository;
    }
} 
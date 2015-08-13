<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 19/5/2014
 * Time: 6:42 μμ
 */

namespace User\Service;


use Application\Service\BaseService;
use Doctrine\ORM\EntityRepository;
use User\Entity\User as UserEntity;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Stdlib\ParametersInterface;

/**
 * Class User
 * @package User\Service
 */
class UserService extends BaseService implements ServiceManagerAwareInterface
{
    private $userRepository;

    public function load($limit = 10, $page = 1, $sort = null, $search = null)
    {
        if(!empty($sort)){
            $params = explode(",",$sort);
            $sort = array("column" => $params[0],"type" => strtoupper($params[1]));
        }else{
            $sort = array();
        };
        $repository = $this->getUserRepository();
        if (empty($search) || trim($search) == false) {
            // the findby uses a different format
            if(!empty($sort)) $sort = array($sort["column"] => $sort["type"]);

            $users = $repository->findBy(array(), $sort);

            $paginator = new Paginator(new ArrayAdapter($users));
            $paginator->setCurrentPageNumber($page)
                ->setDefaultItemCountPerPage($limit);

            return $paginator;
        } else {
            return $repository->search($search,$page,$limit,$sort);
        }
    }

    /**
     * Create a new user
     *
     * @param array $data
     * @param \Zend\Form\Form $form
     * @return bool
     */
    public function create($data, &$form)
    {
        $user = new UserEntity();
        $em = $this->getEntityManager();

        $form->bind($user);
        $form->setData($data);
        if (!$form->isValid()) return false;
        $user->setPassword(UserEntity::hashPassword($user->getPassword()));
        $user->setCreateTime("now");
        try {
            $em->persist($user);
            $em->flush();
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_USER_CREATED"]);
            return true;
        } catch (\Exception $e) {
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_USER_NOT_CREATED"]);
            return false;
        }
    }

    /**
     * Update and save the user
     *
     * @param $data
     * @return bool
     */
    public function save(ParametersInterface $data)
    {
        $em = $this->getEntityManager();
        $attribute = $data->get('attribute');
        $primaryKey = $data->get('primaryKey');
        $content = $data->get('content') ? $data->get('content') : null;
        $constraints = $data->get('constraints', null);
        $repository = $this->getRepository('user','user');
        if ($constraints)
            $constraints = json_decode(str_replace('\\', '\\\\', $constraints), true);

        if ($primaryKey) {
            $entity = $repository->find($primaryKey);
            if ($entity) {
                $filter = $this->getServiceManager()->get('userFilter')->filter($attribute, $content);
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
                        return true;
                    } catch (\Exception  $e) {
                        $this->message = "Something went wrong, please try again.";
                    }
                } else {
                    $this->message = $filter->getMessages()[$attribute];
                }
            }
        }
        return false;
    }

    /**
     * Remove an user from the database.
     *
     * @param int $id
     * @return bool
     */
    public function remove($id)
    {
        $em = $this->getEntityManager();
        $user = $this->getUserRepository('user')->find($id);
        try {
            $em->remove($user);
            $em->flush();
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @return \User\Repository\UserRepository
     */
    private function getUserRepository(){
        if(null === $this->userRepository)
            $this->userRepository = $this->getRepository('user','user');
        return $this->userRepository;
    }
}
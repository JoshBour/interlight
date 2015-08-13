<?php
namespace User\Filter;

use Application\Filter\BaseFilter;
use DoctrineModule\Validator\ObjectExists;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;

/**
 * Class CategoryFilter
 * @package Product\Filter
 */
class UserFilter extends BaseFilter
{
    public function getMergedFilters(){
        return array_merge($this->getUsernameFilters(),$this->getPasswordFilters(),$this->getEmailFilters());
    }

    protected function getUsernameFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            "username" => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_USERNAME_EMPTY"])
                            )
                        )
                    ),
                    array(
                        'name' => 'StringLength',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'min' => 4,
                            'max' => 15,
                            'messages' => array(
                                StringLength::TOO_SHORT => $this->getTranslator()->translate($vocabulary["ERROR_USERNAME_INVALID_LENGTH"]),
                                StringLength::TOO_LONG => $this->getTranslator()->translate($vocabulary["ERROR_USERNAME_INVALID_LENGTH"])
                            )
                        )
                    ),
                    array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'object_repository' => $this->getEntityManager()->getRepository('User\Entity\User'),
                            'fields' => 'username',
                            'messages' => array(
                                'objectFound' => $this->getTranslator()->translate($vocabulary["ERROR_USERNAME_EXISTS"])
                            )
                        )
                    ),
                    array(
                        'name' => 'regex',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'pattern' => '/^[a-zA-Z0-9_]{4,16}$/',
                            'messages' => array(
                                Regex::NOT_MATCH => $this->getTranslator()->translate($vocabulary["ERROR_USERNAME_INVALID_PATTERN"])
                            )
                        )
                    )
                ),
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                )
            ));
    }

    public function getPasswordFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            "password" => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_PASSWORD_EMPTY"])
                            )
                        )
                    ),
                    array(
                        'name' => 'StringLength',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'min' => 4,
                            'max' => 20,
                            'messages' => array(
                                StringLength::TOO_SHORT => $this->getTranslator()->translate($vocabulary["ERROR_PASSWORD_INVALID_LENGTH"]),
                                StringLength::TOO_LONG => $this->getTranslator()->translate($vocabulary["ERROR_PASSWORD_INVALID_LENGTH"])
                            )
                        )
                    ),
                ),
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                )
            )
        );
    }

    public function getEmailFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            "email" => array(
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'EmailAddress',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                EmailAddress::INVALID_FORMAT => $this->getTranslator()->translate($vocabulary["ERROR_EMAIL_INVALID"]),
                                EmailAddress::INVALID => $this->getTranslator()->translate($vocabulary["ERROR_EMAIL_INVALID"]),
                                EmailAddress::INVALID_HOSTNAME => $this->getTranslator()->translate($vocabulary["ERROR_EMAIL_INVALID"]),
                                EmailAddress::INVALID_LOCAL_PART => $this->getTranslator()->translate($vocabulary["ERROR_EMAIL_INVALID"]),
                            )
                        )
                    ),
                    array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'object_repository' => $this->getEntityManager()->getRepository('User\Entity\User'),
                            'fields' => 'email',
                            'messages' => array(
                                'objectFound' => $this->getTranslator()->translate($vocabulary["ERROR_EMAIL_EXISTS"])
                            )
                        )
                    ),
                ),
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                )
            )
        );
    }

}
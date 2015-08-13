<?php
namespace Product\Validator;

//use Application\Validator\FileValidatorInterface;
use Zend\Validator\File\Extension;
use Zend\File\Transfer\Adapter\Http;
use Zend\Validator\File\FilesSize;
use Zend\Filter\File\Rename;
use Zend\Validator\File\MimeType;
use Zend\Validator\AbstractValidator;

class Attribute extends AbstractValidator
{
    const EMPTY_ATTRIBUTES = 'emptyAttributes';
    const INVALID_POSITION = 'invalidPosition';
    const POSITION_NAN = 'positionNan';
    const EMPTY_POSITION = 'emptyPosition';
    const EMPTY_VALUE = 'emptyValue';
    const INVALID_ATTRIBUTES = 'invalidAttributes';
    const DUPLICATE_ATTRIBUTE = "duplicateAttribute";

    protected $messageTemplates = array(
        self::EMPTY_ATTRIBUTES => "The attributes can't be empty.",
        self::INVALID_POSITION => "The attribute position must be a valid integer between 1-999.",
        self::POSITION_NAN => "The attribute position must be an integer.",
        self::EMPTY_POSITION => "Some attributes have empty positions, please check them and try again.",
        self::EMPTY_VALUE => "Some attributes have empty values, please check them and try again.",
        self::INVALID_ATTRIBUTES => "Something went wrong when decoding the attributes.",
        self::DUPLICATE_ATTRIBUTE => "You have duplicate attributes included when you can only have one entry per attribute type."
    );

    protected $validators;

    protected $filters;

    public function __construct($options = array())
    {
        parent::__construct($options);
    }

    public function isValid($attributes)
    {
        if(!is_array($attributes)) $attributes = json_decode($attributes,true);


        if ($attributes === null) {
            $this->error(self::INVALID_ATTRIBUTES);
            return false;
        }

        if (empty($attributes)) {
            $this->error(self::EMPTY_ATTRIBUTES);
            return false;
        }

        $error = false;
        $includedAttributes = [];
        foreach ($attributes as $attribute) {
            if(in_array($attribute['attributeId'],$includedAttributes)){
                $this->error(self::DUPLICATE_ATTRIBUTE, $this->messageTemplates[self::DUPLICATE_ATTRIBUTE]);
                $error = true;
                continue;
            }else {
                $includedAttributes[] = $attribute['attributeId'];
            }

            // we don't return false in this one so that we can check the position as well
            if (empty($attribute['value'])) {
                $this->error(self::EMPTY_VALUE, $this->messageTemplates[self::EMPTY_VALUE]);
                $error = true;
            }

            if (empty($attribute['position'])) {
                $this->error(self::EMPTY_POSITION, $this->messageTemplates[self::EMPTY_POSITION]);
                $error = true;
                continue;
            }

            if (!is_int((int)$attribute['position'])) {
                $this->error(self::POSITION_NAN, $this->messageTemplates[self::POSITION_NAN]);
                $error = true;
                continue;
            }

            if ($attribute['position'] < 1 || $attribute['position'] > 999) {
                $this->error(self::INVALID_POSITION, $this->messageTemplates[self::INVALID_POSITION]);
                $error = true;
                continue;
            }
        }

        return !$error;
    }

}
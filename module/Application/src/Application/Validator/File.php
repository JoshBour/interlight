<?php
namespace Application\Validator;

//use Application\Validator\FileValidatorInterface;
use Zend\Filter\FilterChain;
use Zend\Validator\File\Extension;
use Zend\File\Transfer\Adapter\Http;
use Zend\Validator\File\FilesSize;
use Zend\Filter\File\Rename;
use Zend\Validator\AbstractValidator;
use Zend\Validator\ValidatorChain;

class File extends AbstractValidator
{
    const FILE_EXTENSION_ERROR = 'invalidFileExtention';
    const FILE_NAME_ERROR = 'invalidFileName';
    const FILE_INVALID = 'invalidFile';
    const FALSE_EXTENSION = 'fileExtensionFalse';
    const NOT_FOUND = 'fileExtensionNotFound';
    const TOO_BIG = 'fileFilesSizeTooBig';
    const TOO_SMALL = 'fileFilesSizeTooSmall';
    const NOT_READABLE = 'fileFilesSizeNotReadable';


    public $minSize = 2;  //KB
    public $maxSize = 10240; //KB
    public $extensions = array('jpg', 'png', 'gif', 'jpeg');

    protected $messageTemplates = array(
        self::FILE_EXTENSION_ERROR => "The file is invalid or not an image. Only jpeg, png and gif formats are allowed.",
        self::FILE_NAME_ERROR => "File name is not correct",
        self::FILE_INVALID => "File is not valid",
        self::FALSE_EXTENSION => "File has an incorrect extension",
        self::NOT_FOUND => "File is not readable or does not exist",
        self::TOO_BIG => "The file is too big, please upload a bigger file.",
        self::TOO_SMALL => "The file is too small, please upload a smaller file",
        self::NOT_READABLE => "One or more files can not be read",
    );

    protected $validators;

//    protected $filters;

    public function __construct($options)
    {
//        $this->filters = new FilterChain();
        $this->validators = new ValidatorChain();
        parent::__construct($options);
    }

    public function isValid($fileInput)
    {
        $options = $this->getOptions();
        $minSize = $this->minSize;
        $maxSize = $this->maxSize;

        if (array_key_exists('minSize', $options)) {
            $minSize = $options['minSize'];
        }
        if (array_key_exists('maxSize', $options)) {
            $maxSize = $options['maxSize'];
        }
        $fileName = $fileInput['name'];
        $fileSizeOptions = null;
//        if ($minSize) {
//            $fileSizeOptions['min'] = $minSize * 1024;
//        }
        if ($maxSize) {
            $fileSizeOptions['max'] = $maxSize * 1024;
        }
        if ($fileSizeOptions) {
            $this->validators->attach(new FilesSize($fileSizeOptions));
        }
        //    $this->validators[] = new Extension(array('extension' => $extensions));
        if (!preg_match('/^[a-z0-9-_]+[a-z0-9-_\.]+$/i', $fileName)) {
            $this->error(self::FILE_NAME_ERROR);
            return false;
        }


        if ($this->validators->isValid($fileInput)) {
            return true;
        } else {
            foreach ($this->validators->getMessages() as $key => $value) {
                $this->error($key, $value);
            }
            return false;
        }
    }

}
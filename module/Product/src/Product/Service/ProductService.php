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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use DoctrineModule\Paginator\Adapter\Collection;
use Product\Entity\Attribute;
use Product\Entity\Product as ProductEntity;
use Product\Entity\ProductAttribute;
use Product\Entity\ProductVariation;
use Product\Entity\RelatedProduct;
use Zend\Form\Form;
use Zend\Filter\File\Rename;
use Zend\Form\FormInterface;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\Stdlib\ParametersInterface;

/**
 * Class Product
 * @package Product\Service
 */
class ProductService extends BaseService
{

    private $attributeRepository;

    private $categoryRepository;

    private $productRepository;

    public function load($limit = 10, $page = 1, $sort = null, $search = null)
    {
        if (!empty($sort)) {
            $params = explode(",", $sort);
            $sort = array("column" => $params[0], "type" => strtoupper($params[1]));
        } else {
            $sort = array();
        };
        $productRepository = $this->getProductRepository();

        return $productRepository->findByFilters(array(
            "sort" => $sort,
            "search" => $search,
            "limit" => $limit,
            "page" => $page,
        ));

//        if (empty($search) || trim($search) == false) {
//            // the findby uses a different format
//            if (!empty($sort)) $sort = array($sort["column"] => $sort["type"]);
//
//            $products = $productRepository->findBy(array(), $sort);
//
//            $paginator = new Paginator(new ArrayAdapter($products));
//            $paginator->setCurrentPageNumber($page)
//                ->setDefaultItemCountPerPage($limit);
//
//            return $paginator;
//        } else {
//            return $productRepository->search($search, $page, $limit, $sort);
//        }
    }


    /**
     * Create a new product
     *
     * @param array $data
     * @param Form $form
     * @return bool
     */
    public function create($data, &$form)
    {
        $product = new ProductEntity();
        $productRepository = $this->getProductRepository();
        $attributeRepository = $this->getRepository('product', 'attribute');
        $em = $this->getEntityManager();

        if (isset($data['product']['attributes'])) {
            $data['product']['attributes'] = json_decode($data['product']['attributes'], true);
        }

        $form->bind($product);
        $form->setData($data);
        $form->setBindOnValidate(Form::BIND_MANUAL);
        if (!$form->isValid()) {
            return false;
        };

        $product->setName($data['product']['name']);
        $product->setProductNumber($data['product']['productNumber']);
        $product->setDescription($data['product']['description']);

        // we set the category if its not empty
        if (!empty($data['product']['category'])) {
            if ($category = $this->getRepository("product", "category")->find($data['product']['category']))
                $product->setCategory($category);
        }

        // we upload and rename the datasheet
        if (isset($data['product']['datasheet']) && !empty($data['product']['datasheet']['name'])) {
            $newName = FileUtilService::rename($data['product']['datasheet'], 'data/datasheets', "datasheet");
            $product->setDatasheet($newName);
        }

        // we upload and rename the thumbnail
        if (isset($data['product']['thumbnail']) && !empty($data['product']['thumbnail']['name'])) {
            $newName = FileUtilService::rename($data['product']['thumbnail'], 'images/products', "product");
            $product->setThumbnail($newName);
        }

        // we upload and rename the specifications
        if (isset($data['product']['specifications']) && !empty($data['product']['specifications']['name'])) {
            $newName = FileUtilService::rename($data['product']['specifications'], 'images/products', "specifications");
            $product->setSpecifications($newName);
        }

        foreach ($data['product']['attributes'] as $attribute) {
            $attributeEntity = $attributeRepository->find($attribute['attributeId']);
            if ($attributeEntity) {
                $productAttribute = new ProductAttribute($attribute['value'], $attribute['position']);
                $attributeEntity->addProduct($productAttribute);
                $product->addAttributes($productAttribute);
                $em->persist($attributeEntity);
            }
        }

        if (isset($data['product']['relatedProducts'])) {
            foreach ($data['product']['relatedProducts'] as $relatedProduct) {
                $product->addRelatedProducts($productRepository->find($relatedProduct));
            }
        }

        if (isset($data['product']['productVariations'])) {
            foreach ($data['product']['productVariations'] as $productVariation) {
                $product->addProductVariations($productRepository->find($productVariation));
            }
        }

        try {
            $em->persist($product);
            $em->flush();
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_PRODUCT_CREATED"]);
            return true;
        } catch (\Exception $e) {
            $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_PRODUCT_NOT_CREATED"]);
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
        $productRepository = $this->getProductRepository();
        $skipAssign = false;
        if ($constraints)
            $constraints = json_decode(str_replace('\\', '\\\\', $constraints), true);

        if ($primaryKey) {
            /**
             * @var ProductEntity $product
             */
            $product = $productRepository->find($primaryKey);
            if ($product) {
                $filter = $this->getServiceManager()->get('productFilter')->filter($attribute, $content);
                if ($filter->isValid()) {
                    if (!empty($constraints) && $content) {
                        foreach ($constraints as $constraint) {
                            if ($constraint["type"] == "foreign") {
                                if ($attribute == "productVariations") {
                                    $values = json_decode($content, true);
                                    $product->clearProductVariations();
                                    foreach ($values as $value) {
                                        $variation = $productRepository->find($value);
                                        if ($variation) {
                                            $product->addProductVariations($variation);
                                        } else {
                                            return false;
                                        }
                                    }
                                    $skipAssign = true;
                                } else if ($attribute == "relatedProducts") {
                                    $values = json_decode($content, true);
                                    $product->clearRelatedProducts();
                                    foreach ($values as $value) {
                                        $related = $productRepository->find($value);
                                        if ($related) {
                                            $product->addRelatedProducts($related);
                                        } else {
                                            return false;
                                        }
                                    }
                                    $skipAssign = true;
                                } else {
                                    $content = $em->getReference($constraint["target"], $content);
                                }
                            }
                        }
                    }

                    if ($attribute == "attributes") {
                        $attributes = json_decode($content, true);
                        $product->clearAttributes();
                        $skipAssign = true;
                        foreach ($attributes as $attributeDetails) {
                            $attributeEntity = $this->getAttributeRepository()->find($attributeDetails["attributeId"]);
                            $productAttribute = $this->getRepository('product', 'productAttribute')->findOneBy(array("product" => $product, "attribute" => $attributeEntity));
                            if (!$productAttribute) {
                                $productAttribute = new ProductAttribute($attributeDetails['value'], $attributeDetails['position']);
                                $attributeEntity->addProduct($productAttribute);
//                                $em->persist($attributeEntity);
                            }else{
                                $productAttribute->setValue($attributeDetails['value']);
                                $productAttribute->setPosition($attributeDetails['position']);
                            }
                            $product->addAttributes($productAttribute);
                            $em->persist($productAttribute);

                        }
                    }

                    if ($attribute == "thumbnail" && ($thumbnail = $product->getThumbnail()))
                        FileUtilService::deleteFile(FileUtilService::getFilePath($thumbnail, 'images', 'products'));

                    if ($attribute == "specifications" && ($specifications = $product->getSpecifications()))
                        FileUtilService::deleteFile(FileUtilService::getFilePath($specifications, 'images', 'products'));

                    if ($attribute == "datasheet" && ($datasheet = $product->getDatasheet()))
                        FileUtilService::deleteFile(FileUtilService::getFilePath($datasheet, 'data', 'datasheets'));

                    if (!$skipAssign)
                        $product->{'set' . ucfirst($attribute)}($content);
                    try {
                        $em->persist($product);
                        $em->flush();
                        $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_PRODUCT_SAVED"]);
                        return true;
                    } catch (\Exception  $e) {
                        var_dump($e->getMessage());
                        $this->message = $this->getTranslator()->translate($this->getVocabulary()["ERROR_PRODUCT_NOT_SAVED"]);
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
        $product = $this->getProductRepository()->find($id);
        if ($product) {
            try {
                if ($thumbnail = $product->getThumbnail())
                    FileUtilService::deleteFile(FileUtilService::getFilePath($thumbnail, 'images', 'products'));
                if ($specifications = $product->getSpecifications())
                    FileUtilService::deleteFile(FileUtilService::getFilePath($specifications, 'images', 'products'));
                if ($datasheet = $product->getDatasheet())
                    FileUtilService::deleteFile(FileUtilService::getFilePath($datasheet, 'data', 'datasheets'));

                $em->remove($product);
                $em->flush();
                $this->message = $this->getTranslator()->translate($this->getVocabulary()["MESSAGE_PRODUCT_REMOVED"]);
                return true;
            } catch (\Exception $e) {
                $this->message = $this->getTranslator()->translate($this->getVocabulary()["ERROR_PRODUCT_NOT_REMOVED"]);
                return false;
            }
        }
        return false;
    }

    private function getAttributeRepository()
    {
        if (null === $this->attributeRepository)
            $this->attributeRepository = $this->getRepository('product', 'attribute');
        return $this->attributeRepository;
    }

    private function getCategoryRepository()
    {
        if (null === $this->categoryRepository)
            $this->categoryRepository = $this->getRepository('product', 'category');
        return $this->categoryRepository;
    }

    /**
     * @return \Product\Repository\ProductRepository
     */
    private function getProductRepository()
    {
        if (null === $this->productRepository)
            $this->productRepository = $this->getRepository('product', 'product');
        return $this->productRepository;
    }


} 
<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 4/6/2014
 * Time: 5:55 μμ
 */

namespace Product\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @package Product\Entity
 * @ORM\Entity(repositoryClass="Product\Repository\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product
{

    /**
     * @ORM\OneToMany(targetEntity="ProductAttribute", mappedBy="product", cascade={"persist", "remove"}, orphanRemoval=TRUE)
     */
    private $attributes;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", length=11, name="product_id")
     */
    private $productId;

    /**
     * @ORM\Column(type="string", length=100, name="product_number")
     */
    private $productNumber;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $datasheet = null;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $thumbnail = null;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $specifications = null;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="relatedToProducts", cascade={"remove"})
     */
    private $relatedProducts;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     */
    private $category = null;

    /**
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="relatedProduct")
     * @ORM\JoinTable(name="related_products",
     *      joinColumns={@ORM\JoinColumn(name="related_product_id", referencedColumnName="product_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="product_id")}
     * )
     */
    private $relatedToProducts;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="variationToProducts", cascade={"remove"})
     */
    private $productVariations;

    /**
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="productVariations")
     * @ORM\JoinTable(name="products_variations",
     *      joinColumns={@ORM\JoinColumn(name="product_variation_id", referencedColumnName="product_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="product_id")}
     * )
     */
    private $variationToProducts;

    public function __construct()
    {
        $this->relatedProducts = new ArrayCollection();
        $this->relatedToProducts = new ArrayCollection();
        $this->productVariations = new ArrayCollection();
        $this->variationToProducts = new ArrayCollection();
        $this->attributes = new ArrayCollection();
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    public function addAttributes(ProductAttribute $attribute)
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes->add($attribute);
            $attribute->setProduct($this);
        }
    }

    public function clearAttributes()
    {
        foreach($this->attributes as $attribute){
            $this->attributes->removeElement($attribute);
            $attribute->setProduct(null);
        }
    }

    public function removeAttributes(ProductAttribute $attribute)
    {

        if ($this->attributes->contains($attribute)) {
            $this->attributes->removeElement($attribute);
            $attribute->setProduct(null);
        }
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $datasheet
     */
    public function setDatasheet($datasheet)
    {
        $this->datasheet = $datasheet;
    }

    /**
     * @return mixed
     */
    public function getDatasheet()
    {
        return $this->datasheet;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param mixed $productNumber
     */
    public function setProductNumber($productNumber)
    {
        $this->productNumber = $productNumber;
    }

    /**
     * @return mixed
     */
    public function getProductNumber()
    {
        return $this->productNumber;
    }

    public function addProductVariations(Product $product)
    {

        if (!$this->productVariations->contains($product)) {
            $this->productVariations->add($product);
            $product->addVariationToProducts($this);
        }
    }

    public function removeProductVariations(Product $product)
    {
        if ($this->productVariations->contains($product)) {
            $this->productVariations->removeElement($product);
            $product->removeVariationToProducts($this);
        }
    }

    public function clearProductVariations()
    {
        foreach($this->productVariations as $variation){
            $this->productVariations->removeElement($variation);
            $variation->removeVariationToProducts($this);
        }
    }

    /**
     * @param mixed $productVariations
     */
    public function setProductVariations($productVariations)
    {
        $this->productVariations = $productVariations;
    }

    /**
     * @return mixed
     */
    public function getProductVariations()
    {
        return $this->productVariations;
    }

    public function getProductVariationsAssoc(){
        $assoc = array();
        foreach($this->productVariations as $product){
            $assoc[$product->getProductId()] = $product->getProductNumber();
        }
        return $assoc;
    }

    public function getPrice()
    {
        foreach ($this->attributes as $attribute) {
            if ($attribute->getAttribute()->getName() == "Price")
                return $attribute->getValue();
        }
        return false;
    }

    public function addRelatedProducts(Product $product)
    {
        if (!$this->relatedProducts->contains($product)) {
            $this->relatedProducts->add($product);
            $product->addRelatedToProducts($this);
        }
    }

    public function removeRelatedProducts(Product $product)
    {
        if ($this->relatedProducts->contains($product)) {
            $this->relatedProducts->removeElement($product);
            $product->removeRelatedToProducts($this);
        }
    }

    public function clearRelatedProducts()
    {
        foreach($this->relatedProducts as $related){
            $this->relatedProducts->removeElement($related);
            $related->removeRelatedToProducts($this);
        }
    }

    /**
     * @param mixed $relatedProducts
     */
    public function setRelatedProducts($relatedProducts)
    {
        $this->relatedProducts = $relatedProducts;
    }

    public function getRelatedProductsList()
    {
        return array_map(function ($relatedProduct) {
            return $relatedProduct->getRelated();

        }, $this->relatedProducts->toArray());
    }

    /**
     * @return ArrayCollection
     */
    public function getRelatedProducts()
    {
        return $this->relatedProducts;
    }

    public function getRelatedProductsAssoc(){
        $assoc = array();
        foreach($this->relatedProducts as $product){
            $assoc[$product->getProductId()] = $product->getProductNumber();
        }
        return $assoc;
    }

    /**
     * @param mixed $relatedToProducts
     */
    public function setRelatedToProducts($relatedToProducts)
    {
        $this->relatedToProducts = $relatedToProducts;
    }

    /**
     * @return mixed
     */
    public function getRelatedToProducts()
    {
        return $this->relatedToProducts;
    }

    public function addRelatedToProducts(Product $product)
    {
        if (!$this->relatedToProducts->contains($product)) {
            $this->relatedToProducts->add($product);
        }
    }

    public function removeRelatedToProducts(Product $product)
    {
        if ($this->relatedToProducts->contains($product)) {
            $this->relatedToProducts->removeElement($product);
        }
    }

    /**
     * @param mixed $specifications
     */
    public function setSpecifications($specifications)
    {
        $this->specifications = $specifications;
    }

    /**
     * @param bool $useDefault
     * @return string
     */
    public function getSpecifications($useDefault = true)
    {
        return !$this->specifications && $useDefault ? "../default-light.png" : $this->specifications;
    }

    /**
     * @param mixed $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @param bool $useDefault
     * @return string
     */
    public function getThumbnail($useDefault = true)
    {

        return !$this->thumbnail && $useDefault ? "../default-light.png" : $this->thumbnail;
    }

    /**
     * @param mixed $variationToProducts
     */
    public function setVariationToProducts($variationToProducts)
    {
        $this->variationToProducts = $variationToProducts;
    }

    /**
     * @return mixed
     */
    public function getVariationToProducts()
    {
        return $this->variationToProducts;
    }

    public function addVariationToProducts(Product $product)
    {
        if (!$this->variationToProducts->contains($product)) {
            $this->variationToProducts->add($product);
        }
    }

    public function removeVariationToProducts(Product $product)
    {
        if ($this->variationToProducts->contains($product)) {
            $this->variationToProducts->removeElement($product);
        }
    }

} 
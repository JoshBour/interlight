<?php
namespace Product;

return array(
    'doctrine' => array(
        'driver' => array(
            'entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => 'entity',
                ),
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'attributes' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/admin/attributes',
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . '\Controller\Attribute',
                        'action' => 'list',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'load' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/load[?page=:page&limit=:limit&search=:search&sort=:sort]',
                            'defaults' => array(
                                'action' => 'load'
                            )
                        )
                    ),
                    'save' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/save',
                            'defaults' => array(
                                'action' => 'save'
                            )
                        )
                    ),
                    'add' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'action' => 'add'
                            )
                        )
                    ),
                    'delete' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/delete',
                            'defaults' => array(
                                'action' => 'delete'
                            )
                        )
                    )
                )
            ),
            'products_index' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/products',
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . '\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'product_categorised' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/:categoryUrl/:productNumber[/:tab]',
                            'defaults' => array(
                                'action' => 'view',
                                'tab' => 'description'
                            ),
                            'constraints' => array(
                                'tab' => 'description|specifications'
                            )
                        )
                    ),
                    'product_uncategorised' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/view/:productNumber[/:tab]',
                            'defaults' => array(
                                'action' => 'view',
                                'tab' => 'description'
                            ),
                            'constraints' => array(
                                'tab' => 'description|specifications'
                            )
                        )
                    ),
                    'category' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/:categoryUrl',
                            'defaults' => array(
                                'controller' => __NAMESPACE__ . '\Controller\Category',
                                'action' => 'index'
                            )
                        )
                    ),
                    'search' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/search/:value',
                            'defaults' => array(
                                'action' => 'search'
                            )
                        )
                    ),
                )
            ),
            'products' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/products',
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . '\Controller\Index',
                        'action' => 'list',
                        'page' => 1,
                        'limit' => 10,
                    ),
                    'constraints' => array(
//                        'page' => '\d{1,}',
//                        'limit' => '-1|5|10|25|50|100',
//                        'sort' => '[a-zA-Z0-9_]+,asc|desc|ASC|DESC'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'load' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/load[?page=:page&limit=:limit&search=:search&sort=:sort]',
                            'defaults' => array(
                                'action' => 'load'
                            )
                        )
                    ),
                    'save' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/save',
                            'defaults' => array(
                                'action' => 'save'
                            )
                        )
                    ),
                    'add' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'action' => 'add'
                            )
                        )
                    ),
                    'delete' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/delete',
                            'defaults' => array(
                                'action' => 'delete'
                            )
                        )
                    )
                )
            ),
            'categories' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin/categories',
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . '\Controller\Category',
                        'action' => 'list',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'load' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/load[?page=:page&limit=:limit&search=:search&sort=:sort]',
                            'defaults' => array(
                                'action' => 'load'
                            )
                        )
                    ),
                    'save' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/save',
                            'defaults' => array(
                                'action' => 'save'
                            )
                        )
                    ),
                    'add' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'action' => 'add'
                            )
                        )
                    ),
                    'delete' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/delete',
                            'defaults' => array(
                                'action' => 'delete'
                            )
                        )
                    )
                )
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'productForm' => __NAMESPACE__ . '\Factory\ProductFormFactory',
            'categoryForm' => __NAMESPACE__ . '\Factory\CategoryFormFactory',
            'attributeForm' => __NAMESPACE__ . '\Factory\AttributeFormFactory',
        ),
        'invokables' => array(
            'productService' => __NAMESPACE__ . '\Service\ProductService',
            'categoryService' => __NAMESPACE__ . '\Service\CategoryService',
            'attributeService' => __NAMESPACE__ . '\Service\AttributeService',
            'categoryFilter' => __NAMESPACE__ . '\Filter\CategoryFilter',
            'productFilter' => __NAMESPACE__ . '\Filter\ProductFilter',
            'attributeFilter' => __NAMESPACE__ . '\Filter\AttributeFilter'
        )
    ),
    'view_helpers' => array(
        'invokables' => array(
            'formAttributeSelect' => __NAMESPACE__ . '\Form\Helper\AttributeSelect',
            'attributeSelect' => __NAMESPACE__ . '\View\Helper\AttributeSelect',
            'productSelect' => __NAMESPACE__ . '\View\Helper\ProductSelect',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            __NAMESPACE__ . '\Controller\Index' => __NAMESPACE__ . '\Controller\IndexController',
            __NAMESPACE__ . '\Controller\Category' => __NAMESPACE__ . '\Controller\CategoryController',
            __NAMESPACE__ . '\Controller\Attribute' => __NAMESPACE__ . '\Controller\AttributeController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array(
            'product' => __DIR__ . '/../view/partial/product.phtml',
            'admin_product' => __DIR__ . '/../view/partial/admin_product.phtml',
            'category' => __DIR__ . '/../view/partial/category.phtml',
            'attribute' => __DIR__ . '/../view/partial/attribute.phtml',
        ),
        'strategies' => array(
            'ViewJsonStrategy'
        ),
    ),
);

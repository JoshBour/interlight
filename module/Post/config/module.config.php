<?php
namespace Post;

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
            'post_view' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/news/:postUrl',
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . '\Controller\Index',
                        'action' => 'view',
                    ),
                ),
            ),
            'posts_index' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/news[/:page]',
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . '\Controller\Index',
                        'action' => 'index',
                        'page' => 1
                    ),
                    'constraints' => array(
                        'page' => '[0-9]+'
                    )
                ),
            ),
            'posts' =>   array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin/posts',
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . '\Controller\Index',
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
            'postForm' => __NAMESPACE__ . '\Factory\PostFormFactory',
        ),
        'invokables' => array(
            'postService' => __NAMESPACE__ . '\Service\PostService',
            'postFilter' => __NAMESPACE__ . '\Filter\PostFilter',
        )
    ),
    'controllers' => array(
        'invokables' => array(
            __NAMESPACE__ . '\Controller\Index' => __NAMESPACE__ . '\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator' => __DIR__ . '/../view/partial/paginator.phtml',
            'post' => __DIR__ . '/../view/partial/post.phtml',
        ),
        'strategies' => array(
            'ViewJsonStrategy'
        ),
    ),
);

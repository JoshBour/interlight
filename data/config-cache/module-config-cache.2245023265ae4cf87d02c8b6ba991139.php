<?php
return array (
  'view_manager' => 
  array (
    'template_path_stack' => 
    array (
      'zenddevelopertools' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\vendor\\zendframework\\zend-developer-tools\\config/../view',
      0 => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\User\\config/../view',
      1 => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Application\\config/../view',
      2 => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Post\\config/../view',
      3 => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Product\\config/../view',
    ),
    'template_map' => 
    array (
      'zend-developer-tools/toolbar/doctrine-orm-queries' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\vendor\\doctrine\\doctrine-orm-module\\config/../view/zend-developer-tools/toolbar/doctrine-orm-queries.phtml',
      'zend-developer-tools/toolbar/doctrine-orm-mappings' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\vendor\\doctrine\\doctrine-orm-module\\config/../view/zend-developer-tools/toolbar/doctrine-orm-mappings.phtml',
      'layout/layout' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Application\\config/../view/layout/layout.phtml',
      'layout/admin' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Application\\config/../view/layout/admin-layout.phtml',
      'error/404' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Application\\config/../view/error/404.phtml',
      'error/index' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Application\\config/../view/error/index.phtml',
      'header' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Application\\config/../view/partial/header.phtml',
      'header_admin' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Application\\config/../view/partial/header-admin.phtml',
      'footer' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Application\\config/../view/partial/footer.phtml',
      'footer_admin' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Application\\config/../view/partial/footer-admin.phtml',
      'paginator' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Post\\config/../view/partial/paginator.phtml',
      'product' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Product\\config/../view/partial/product.phtml',
    ),
    'strategies' => 
    array (
      0 => 'ViewJsonStrategy',
      1 => 'ViewJsonStrategy',
      2 => 'ViewJsonStrategy',
      3 => 'ViewJsonStrategy',
    ),
    'display_not_found_reason' => true,
    'display_exceptions' => true,
    'doctype' => 'HTML5',
    'not_found_template' => 'error/404',
    'exception_template' => 'error/index',
  ),
  'doctrine' => 
  array (
    'cache' => 
    array (
      'apc' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\ApcCache',
        'namespace' => 'DoctrineModule',
      ),
      'array' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\ArrayCache',
        'namespace' => 'DoctrineModule',
      ),
      'filesystem' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\FilesystemCache',
        'directory' => 'data/DoctrineModule/cache',
        'namespace' => 'DoctrineModule',
      ),
      'memcache' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\MemcacheCache',
        'instance' => 'my_memcache_alias',
        'namespace' => 'DoctrineModule',
      ),
      'memcached' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\MemcachedCache',
        'instance' => 'my_memcached_alias',
        'namespace' => 'DoctrineModule',
      ),
      'predis' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\PredisCache',
        'instance' => 'my_predis_alias',
        'namespace' => 'DoctrineModule',
      ),
      'redis' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\RedisCache',
        'instance' => 'my_redis_alias',
        'namespace' => 'DoctrineModule',
      ),
      'wincache' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\WinCacheCache',
        'namespace' => 'DoctrineModule',
      ),
      'xcache' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\XcacheCache',
        'namespace' => 'DoctrineModule',
      ),
      'zenddata' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\ZendDataCache',
        'namespace' => 'DoctrineModule',
      ),
    ),
    'authentication' => 
    array (
      'odm_default' => 
      array (
      ),
      'orm_default' => 
      array (
        'objectManager' => 'doctrine.entitymanager.orm_default',
        'object_manager' => 'Doctrine\\ORM\\EntityManager',
        'identity_class' => 'User\\Entity\\User',
        'identity_property' => 'username',
        'credential_property' => 'password',
        'credential_callable' => 'User\\Entity\\User::verifyPassword',
      ),
    ),
    'authenticationadapter' => 
    array (
      'odm_default' => true,
      'orm_default' => true,
    ),
    'authenticationstorage' => 
    array (
      'odm_default' => true,
      'orm_default' => true,
    ),
    'authenticationservice' => 
    array (
      'odm_default' => true,
      'orm_default' => true,
    ),
    'connection' => 
    array (
      'orm_default' => 
      array (
        'configuration' => 'orm_default',
        'eventmanager' => 'orm_default',
        'params' => 
        array (
          'host' => 'localhost',
          'port' => '3306',
          'user' => 'interlig_root',
          'password' => '79346037/Liv',
          'dbname' => 'interlig_main',
          'driverOptions' => 
          array (
            1002 => 'SET NAMES utf8',
          ),
        ),
        'driverClass' => 'Doctrine\\DBAL\\Driver\\PDOMySql\\Driver',
      ),
    ),
    'configuration' => 
    array (
      'orm_default' => 
      array (
        'metadata_cache' => 'array',
        'query_cache' => 'array',
        'result_cache' => 'array',
        'hydration_cache' => 'array',
        'driver' => 'orm_default',
        'generate_proxies' => true,
        'proxy_dir' => 'data/DoctrineORMModule/Proxy',
        'proxy_namespace' => 'DoctrineORMModule\\Proxy',
        'filters' => 
        array (
        ),
        'datetime_functions' => 
        array (
        ),
        'string_functions' => 
        array (
        ),
        'numeric_functions' => 
        array (
        ),
        'second_level_cache' => 
        array (
        ),
      ),
    ),
    'driver' => 
    array (
      'orm_default' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\DriverChain',
        'drivers' => 
        array (
          'User\\Entity' => 'entity',
          'Application\\Entity' => 'entity',
          'Post\\Entity' => 'entity',
          'Product\\Entity' => 'entity',
        ),
      ),
      'entity' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'paths' => 
        array (
          0 => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\User\\config/../src/User/Entity',
          1 => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Application\\config/../src/Application/Entity',
          2 => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Post\\config/../src/Post/Entity',
          3 => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Product\\config/../src/Product/Entity',
        ),
      ),
    ),
    'entitymanager' => 
    array (
      'orm_default' => 
      array (
        'connection' => 'orm_default',
        'configuration' => 'orm_default',
      ),
    ),
    'eventmanager' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'sql_logger_collector' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'mapping_collector' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'formannotationbuilder' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'entity_resolver' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'migrations_configuration' => 
    array (
      'orm_default' => 
      array (
        'directory' => 'data/DoctrineORMModule/Migrations',
        'name' => 'Doctrine Database Migrations',
        'namespace' => 'DoctrineORMModule\\Migrations',
        'table' => 'migrations',
      ),
    ),
    'migrations_cmd' => 
    array (
      'generate' => 
      array (
      ),
      'execute' => 
      array (
      ),
      'migrate' => 
      array (
      ),
      'status' => 
      array (
      ),
      'version' => 
      array (
      ),
      'diff' => 
      array (
      ),
      'latest' => 
      array (
      ),
    ),
  ),
  'doctrine_factories' => 
  array (
    'cache' => 'DoctrineModule\\Service\\CacheFactory',
    'eventmanager' => 'DoctrineModule\\Service\\EventManagerFactory',
    'driver' => 'DoctrineModule\\Service\\DriverFactory',
    'authenticationadapter' => 'DoctrineModule\\Service\\Authentication\\AdapterFactory',
    'authenticationstorage' => 'DoctrineModule\\Service\\Authentication\\StorageFactory',
    'authenticationservice' => 'DoctrineModule\\Service\\Authentication\\AuthenticationServiceFactory',
    'connection' => 'DoctrineORMModule\\Service\\DBALConnectionFactory',
    'configuration' => 'DoctrineORMModule\\Service\\ConfigurationFactory',
    'entitymanager' => 'DoctrineORMModule\\Service\\EntityManagerFactory',
    'entity_resolver' => 'DoctrineORMModule\\Service\\EntityResolverFactory',
    'sql_logger_collector' => 'DoctrineORMModule\\Service\\SQLLoggerCollectorFactory',
    'mapping_collector' => 'DoctrineORMModule\\Service\\MappingCollectorFactory',
    'formannotationbuilder' => 'DoctrineORMModule\\Service\\FormAnnotationBuilderFactory',
    'migrations_configuration' => 'DoctrineORMModule\\Service\\MigrationsConfigurationFactory',
    'migrations_cmd' => 'DoctrineORMModule\\Service\\MigrationsCommandFactory',
  ),
  'service_manager' => 
  array (
    'invokables' => 
    array (
      'DoctrineModule\\Authentication\\Storage\\Session' => 'Zend\\Authentication\\Storage\\Session',
      'doctrine.dbal_cmd.runsql' => '\\Doctrine\\DBAL\\Tools\\Console\\Command\\RunSqlCommand',
      'doctrine.dbal_cmd.import' => '\\Doctrine\\DBAL\\Tools\\Console\\Command\\ImportCommand',
      'doctrine.orm_cmd.clear_cache_metadata' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\ClearCache\\MetadataCommand',
      'doctrine.orm_cmd.clear_cache_result' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\ClearCache\\ResultCommand',
      'doctrine.orm_cmd.clear_cache_query' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\ClearCache\\QueryCommand',
      'doctrine.orm_cmd.schema_tool_create' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\SchemaTool\\CreateCommand',
      'doctrine.orm_cmd.schema_tool_update' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\SchemaTool\\UpdateCommand',
      'doctrine.orm_cmd.schema_tool_drop' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\SchemaTool\\DropCommand',
      'doctrine.orm_cmd.convert_d1_schema' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\ConvertDoctrine1SchemaCommand',
      'doctrine.orm_cmd.generate_entities' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\GenerateEntitiesCommand',
      'doctrine.orm_cmd.generate_proxies' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\GenerateProxiesCommand',
      'doctrine.orm_cmd.convert_mapping' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\ConvertMappingCommand',
      'doctrine.orm_cmd.run_dql' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\RunDqlCommand',
      'doctrine.orm_cmd.validate_schema' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\ValidateSchemaCommand',
      'doctrine.orm_cmd.info' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\InfoCommand',
      'doctrine.orm_cmd.ensure_production_settings' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\EnsureProductionSettingsCommand',
      'doctrine.orm_cmd.generate_repositories' => '\\Doctrine\\ORM\\Tools\\Console\\Command\\GenerateRepositoriesCommand',
      'userService' => 'User\\Service\\User',
      'authStorage' => 'User\\Model\\AuthStorage',
      'authService' => 'User\\Service\\Auth',
      'partnerService' => 'Application\\Service\\Partner',
      'aboutCategoryService' => 'Application\\Service\\AboutCategory',
      'slideService' => 'Application\\Service\\Slide',
      'contentService' => 'Application\\Service\\Content',
      'fileUtilService' => 'Application\\Service\\FileUtils',
      'postService' => 'Post\\Service\\Post',
      'productService' => 'Product\\Service\\Product',
      'categoryService' => 'Product\\Service\\Category',
    ),
    'factories' => 
    array (
      'doctrine.cli' => 'DoctrineModule\\Service\\CliFactory',
      'Doctrine\\ORM\\EntityManager' => 'DoctrineORMModule\\Service\\EntityManagerAliasCompatFactory',
      'userForm' => 'User\\Factory\\UserFormFactory',
      'loginForm' => 'User\\Factory\\LoginFormFactory',
      'Zend\\Authentication\\AuthenticationService' => 'User\\Factory\\AuthFactory',
      'partnerForm' => 'Application\\Factory\\PartnerFormFactory',
      'aboutCategoryForm' => 'Application\\Factory\\AboutCategoryFormFactory',
      'slideForm' => 'Application\\Factory\\SlideFormFactory',
      'contactForm' => 'Application\\Factory\\ContactFormFactory',
      'Zend\\Session\\SessionManager' => 'Application\\Factory\\SessionManagerFactory',
      'postForm' => 'Post\\Factory\\PostFormFactory',
      'productForm' => 'Product\\Factory\\ProductFormFactory',
      'categoryForm' => 'Product\\Factory\\CategoryFormFactory',
    ),
    'abstract_factories' => 
    array (
      'DoctrineModule' => 'DoctrineModule\\ServiceFactory\\AbstractDoctrineServiceFactory',
      0 => 'Zend\\Cache\\Service\\StorageCacheAbstractServiceFactory',
      1 => 'Zend\\Log\\LoggerAbstractServiceFactory',
    ),
    'aliases' => 
    array (
      'zendAuthService' => 'Zend\\Authentication\\AuthenticationService',
      'translator' => 'MvcTranslator',
    ),
  ),
  'controllers' => 
  array (
    'factories' => 
    array (
      'DoctrineModule\\Controller\\Cli' => 'DoctrineModule\\Service\\CliControllerFactory',
    ),
    'invokables' => 
    array (
      'User\\Controller\\Index' => 'User\\Controller\\IndexController',
      'User\\Controller\\Auth' => 'User\\Controller\\AuthController',
      'Application\\Controller\\Index' => 'Application\\Controller\\IndexController',
      'Application\\Controller\\About' => 'Application\\Controller\\AboutController',
      'Application\\Controller\\Slide' => 'Application\\Controller\\SlideController',
      'Application\\Controller\\Partner' => 'Application\\Controller\\PartnerController',
      'Application\\Controller\\Content' => 'Application\\Controller\\ContentController',
      'Post\\Controller\\Index' => 'Post\\Controller\\IndexController',
      'Product\\Controller\\Index' => 'Product\\Controller\\IndexController',
      'Product\\Controller\\Category' => 'Product\\Controller\\CategoryController',
      'Product\\Controller\\Attribute' => 'Product\\Controller\\AttributeController',
    ),
    'initializers' => 
    array (
      'entityManager' => 'Application\\Factory\\EntityManagerInitializer',
      'vocabulary' => 'Application\\Factory\\VocabularyInitializer',
    ),
  ),
  'route_manager' => 
  array (
    'factories' => 
    array (
      'symfony_cli' => 'DoctrineModule\\Service\\SymfonyCliRouteFactory',
    ),
  ),
  'console' => 
  array (
    'router' => 
    array (
      'routes' => 
      array (
        'doctrine_cli' => 
        array (
          'type' => 'symfony_cli',
        ),
      ),
    ),
  ),
  'form_elements' => 
  array (
    'aliases' => 
    array (
      'objectselect' => 'DoctrineModule\\Form\\Element\\ObjectSelect',
      'objectradio' => 'DoctrineModule\\Form\\Element\\ObjectRadio',
      'objectmulticheckbox' => 'DoctrineModule\\Form\\Element\\ObjectMultiCheckbox',
    ),
    'factories' => 
    array (
      'DoctrineModule\\Form\\Element\\ObjectSelect' => 'DoctrineORMModule\\Service\\ObjectSelectFactory',
      'DoctrineModule\\Form\\Element\\ObjectRadio' => 'DoctrineORMModule\\Service\\ObjectRadioFactory',
      'DoctrineModule\\Form\\Element\\ObjectMultiCheckbox' => 'DoctrineORMModule\\Service\\ObjectMultiCheckboxFactory',
    ),
  ),
  'hydrators' => 
  array (
    'factories' => 
    array (
      'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject' => 'DoctrineORMModule\\Service\\DoctrineObjectHydratorFactory',
    ),
  ),
  'router' => 
  array (
    'routes' => 
    array (
      'doctrine_orm_module_yuml' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/ocra_service_manager_yuml',
          'defaults' => 
          array (
            'controller' => 'DoctrineORMModule\\Yuml\\YumlController',
            'action' => 'index',
          ),
        ),
      ),
      'users' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/admin/users',
          'defaults' => 
          array (
            'controller' => 'User\\Controller\\Index',
            'action' => 'list',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'save' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/save',
              'defaults' => 
              array (
                'action' => 'save',
              ),
            ),
          ),
          'add' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/add',
              'defaults' => 
              array (
                'action' => 'add',
              ),
            ),
          ),
          'remove' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/remove',
              'defaults' => 
              array (
                'action' => 'remove',
              ),
            ),
          ),
        ),
      ),
      'login' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/admin[/[login]]',
          'defaults' => 
          array (
            'controller' => 'User\\Controller\\Auth',
            'action' => 'login',
          ),
        ),
      ),
      'authenticate' => 
      array (
        'type' => 'Literal',
        'options' => 
        array (
          'route' => '/admin/authenticate',
          'defaults' => 
          array (
            'controller' => 'User\\Controller\\Auth',
            'action' => 'authenticate',
          ),
        ),
      ),
      'logout' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/admin/logout',
          'defaults' => 
          array (
            'controller' => 'User\\Controller\\Auth',
            'action' => 'logout',
          ),
        ),
      ),
      'change_language' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/change-language/:lang',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\Index',
            'action' => 'change-language',
            'lang' => 'el',
          ),
        ),
      ),
      'about' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/admin/about',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\About',
            'action' => 'list',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'save' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/save',
              'defaults' => 
              array (
                'action' => 'save',
              ),
            ),
          ),
          'add' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/add',
              'defaults' => 
              array (
                'action' => 'add',
              ),
            ),
          ),
          'remove' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/remove',
              'defaults' => 
              array (
                'action' => 'remove',
              ),
            ),
          ),
        ),
      ),
      'partners' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/admin/partners',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\Partner',
            'action' => 'list',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'save' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/save',
              'defaults' => 
              array (
                'action' => 'save',
              ),
            ),
          ),
          'add' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/add',
              'defaults' => 
              array (
                'action' => 'add',
              ),
            ),
          ),
          'remove' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/remove',
              'defaults' => 
              array (
                'action' => 'remove',
              ),
            ),
          ),
        ),
      ),
      'slides' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/admin/slides',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\Slide',
            'action' => 'list',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'save' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/save',
              'defaults' => 
              array (
                'action' => 'save',
              ),
            ),
          ),
          'add' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/add',
              'defaults' => 
              array (
                'action' => 'add',
              ),
            ),
          ),
          'remove' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/remove',
              'defaults' => 
              array (
                'action' => 'remove',
              ),
            ),
          ),
        ),
      ),
      'contents' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/admin/contents',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\Content',
            'action' => 'list',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'save' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/save',
              'defaults' => 
              array (
                'action' => 'save',
              ),
            ),
          ),
        ),
      ),
      'home' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\Index',
            'action' => 'home',
          ),
        ),
      ),
      'sitemap_direct' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/sitemap.xml',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\Index',
            'action' => 'sitemap',
          ),
        ),
      ),
      'sitemap' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/sitemap[/:type[/:index]]',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\Index',
            'action' => 'sitemap',
          ),
        ),
      ),
      'upload-file' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/upload-file',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\Index',
            'action' => 'upload-file',
          ),
        ),
      ),
      'download-file' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/download/:fileName',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\Index',
            'action' => 'download-file',
          ),
        ),
      ),
      'about_index' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/about[/:category]',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\About',
            'action' => 'index',
            'category' => 'first',
          ),
        ),
      ),
      'contact' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/contact',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\Index',
            'action' => 'contact',
          ),
        ),
      ),
      'post_view' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/news/:postUrl',
          'defaults' => 
          array (
            'controller' => 'Post\\Controller\\Index',
            'action' => 'view',
          ),
        ),
      ),
      'posts_index' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/news[/:page]',
          'defaults' => 
          array (
            'controller' => 'Post\\Controller\\Index',
            'action' => 'index',
            'page' => 1,
          ),
          'constraints' => 
          array (
            'page' => '[0-9]+',
          ),
        ),
      ),
      'posts' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/admin/posts',
          'defaults' => 
          array (
            'controller' => 'Post\\Controller\\Index',
            'action' => 'list',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'save' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/save',
              'defaults' => 
              array (
                'action' => 'save',
              ),
            ),
          ),
          'add' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/add',
              'defaults' => 
              array (
                'action' => 'add',
              ),
            ),
          ),
          'remove' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/remove',
              'defaults' => 
              array (
                'action' => 'remove',
              ),
            ),
          ),
        ),
      ),
      'attributes' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/admin/attributes',
          'defaults' => 
          array (
            'controller' => 'Product\\Controller\\Attribute',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'add' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/add',
              'defaults' => 
              array (
                'action' => 'add',
              ),
            ),
          ),
          'save' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/update',
              'defaults' => 
              array (
                'action' => 'update',
              ),
            ),
          ),
        ),
      ),
      'products_index' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/products',
          'defaults' => 
          array (
            'controller' => 'Product\\Controller\\Index',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'product_categorised' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/:categoryUrl/:productNumber[/:tab]',
              'defaults' => 
              array (
                'action' => 'view',
                'tab' => 'description',
              ),
              'constraints' => 
              array (
                'tab' => 'description|specifications',
              ),
            ),
          ),
          'product_uncategorised' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/view/:productNumber[/:tab]',
              'defaults' => 
              array (
                'action' => 'view',
                'tab' => 'description',
              ),
              'constraints' => 
              array (
                'tab' => 'description|specifications',
              ),
            ),
          ),
          'category' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/:categoryUrl',
              'defaults' => 
              array (
                'controller' => 'Product\\Controller\\Category',
                'action' => 'index',
              ),
            ),
          ),
          'search' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/search/:value',
              'defaults' => 
              array (
                'action' => 'search',
              ),
            ),
          ),
        ),
      ),
      'products' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/admin/products',
          'defaults' => 
          array (
            'controller' => 'Product\\Controller\\Index',
            'action' => 'list',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'save' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/save',
              'defaults' => 
              array (
                'action' => 'save',
              ),
            ),
          ),
          'add' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/add',
              'defaults' => 
              array (
                'action' => 'add',
              ),
            ),
          ),
          'remove' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/remove',
              'defaults' => 
              array (
                'action' => 'remove',
              ),
            ),
          ),
        ),
      ),
      'categories' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/admin/categories',
          'defaults' => 
          array (
            'controller' => 'Product\\Controller\\Category',
            'action' => 'list',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'save' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/save',
              'defaults' => 
              array (
                'action' => 'save',
              ),
            ),
          ),
          'add' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/add',
              'defaults' => 
              array (
                'action' => 'add',
              ),
            ),
          ),
          'remove' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/remove',
              'defaults' => 
              array (
                'action' => 'remove',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'zenddevelopertools' => 
  array (
    'profiler' => 
    array (
      'collectors' => 
      array (
        'doctrine.sql_logger_collector.orm_default' => 'doctrine.sql_logger_collector.orm_default',
        'doctrine.mapping_collector.orm_default' => 'doctrine.mapping_collector.orm_default',
      ),
      'enabled' => false,
      'strict' => true,
      'flush_early' => false,
      'cache_dir' => 'data/cache',
      'matcher' => 
      array (
      ),
    ),
    'toolbar' => 
    array (
      'entries' => 
      array (
        'doctrine.sql_logger_collector.orm_default' => 'zend-developer-tools/toolbar/doctrine-orm-queries',
        'doctrine.mapping_collector.orm_default' => 'zend-developer-tools/toolbar/doctrine-orm-mappings',
      ),
      'enabled' => false,
      'auto_hide' => false,
      'position' => 'bottom',
      'version_check' => false,
    ),
    'events' => 
    array (
      'enabled' => false,
      'collectors' => 
      array (
      ),
      'identifiers' => 
      array (
      ),
    ),
  ),
  'controller_plugins' => 
  array (
    'factories' => 
    array (
      'user' => 'User\\Factory\\UserPluginFactory',
      'translate' => 'Application\\Factory\\TranslatePluginFactory',
    ),
  ),
  'view_helpers' => 
  array (
    'factories' => 
    array (
      'user' => 'User\\Factory\\UserViewHelperFactory',
      'routeName' => 'Application\\Factory\\ActionNameHelperFactory',
      'showMessages' => 'Application\\Factory\\ShowMessagesHelperFactory',
    ),
    'invokables' => 
    array (
      'mobile' => 'Application\\View\\Helper\\Mobile',
    ),
  ),
  'translator' => 
  array (
    'locale' => 'en_US',
    'translation_file_patterns' => 
    array (
      0 => 
      array (
        'type' => 'gettext',
        'base_dir' => 'C:\\webserver\\Apache24\\htdocs\\interlight\\module\\Application\\config/../language',
        'pattern' => '%s.mo',
      ),
    ),
  ),
  'static_pages' => 
  array (
    0 => '/products',
    1 => '/about',
    2 => '/news',
    3 => '/',
    4 => '/contact',
  ),
  'session' => 
  array (
    'config' => 
    array (
      'class' => 'Zend\\Session\\Config\\SessionConfig',
      'options' => 
      array (
        'name' => 'interlight',
        'use_cookies' => true,
        'cookie_httponly' => true,
        'gc_maxlifetime' => 2419200,
        'cookie_lifetime' => 2419200,
      ),
    ),
    'storage' => 'Zend\\Session\\Storage\\SessionArrayStorage',
    'validators' => 
    array (
      0 => 'Zend\\Session\\Validator\\RemoteAddr',
      1 => 'Zend\\Session\\Validator\\HttpUserAgent',
    ),
  ),
  'vocabulary' => 
  array (
    'MESSAGE_USER_CREATED' => 'The user has been created successfully.',
    'MESSAGE_USER_REMOVED' => 'The user has been removed successfully.',
    'MESSAGE_USER_SAVED' => 'The users have been saved successfully',
    'ERROR_USER_NOT_REMOVED' => 'There was a problem when removing the user, please try again.',
    'ERROR_USER_NOT_SAVED' => 'Something went wrong when saving the users, please try again.',
    'ERROR_USERNAME_EMPTY' => 'The username can\'t be empty.',
    'ERROR_USERNAME_INVALID_LENGTH' => 'The username length must be between between 4-15 characters long.',
    'ERROR_USERNAME_EXISTS' => 'The username already exists, please try another one.',
    'ERROR_USERNAME_INVALID_PATTERN' => 'The name can only contain letters, numbers, underscores and no spaces between.',
    'ERROR_PASSWORD_EMPTY' => 'The password can\'t be empty.',
    'ERROR_PASSWORD_INVALID_LENGTH' => 'The password length must be between between 4-20 characters long.',
    'MESSAGE_USERS_SAVED' => 'The users have been saved successfully',
    'ERROR_USERS_NOT_SAVED' => 'Something went wrong when saving the users, please try again.',
    'MESSAGE_INVALID_CREDENTIALS' => 'The username/password combination is invalid.',
    'MESSAGE_ALREADY_LOGGED' => 'You are already logged in!',
    'MESSAGE_WELCOME' => 'Welcome back',
    'PLACEHOLDER_USERNAME' => 'Enter your username..',
    'PLACEHOLDER_PASSWORD' => 'Enter your password..',
    'LABEL_USERNAME' => 'Username:',
    'LABEL_PASSWORD' => 'Password:',
    'LABEL_REMEMBER_ME' => 'Remember Me:',
    'ERROR_USERNAME_INVALID' => 'The username is invalid.',
    'ERROR_PASSWORD_INVALID' => 'The password is invalid.',
    'MESSAGE_EXCEPTION_CREATED' => 'The exception has been created successfully.',
    'MESSAGE_EXCEPTION_REMOVED' => 'The exception has been removed successfully.',
    'MESSAGE_EXCEPTIONS_SAVED' => 'The exceptions have been saved successfully.',
    'ERROR_EXCEPTION_REMOVE' => 'There was a problem when removing the exception, please try again.',
    'ERROR_EXCEPTIONS_NOT_SAVED' => 'There was a problem when saving the exceptions, please try again.',
    'MESSAGE_ENTRY_CREATED' => 'The entry has been created successfully.',
    'MESSAGE_ENTRIES_SAVED' => 'The entries have been saved successfully.',
    'ERROR_ENTRIES_NOT_SAVED' => 'There was an error when saving the entries, please try again.',
    'ERROR_START_TIME_EMPTY' => 'The start time can\'t be empty',
    'ERROR_END_TIME_EMPTY' => 'The end time can\'t be empty',
    'LABEL_EXCEPTION' => 'Exception:',
    'LABEL_START_TIME' => 'Start Time:',
    'LABEL_END_TIME' => 'End Time:',
    'ERROR_NAME_EMPTY' => 'The name can\'t be empty',
    'ERROR_COLOR_EMPTY' => 'The color can\'t be empty',
    'MESSAGE_WORKER_CREATED' => 'The worker has been created successfully.',
    'MESSAGE_WORKER_REMOVED' => 'The worker has been removed successfully.',
    'MESSAGE_WORKER_SAVED' => 'The workers have been saved successfully',
    'ERROR_WORKER_NOT_REMOVED' => 'There was a problem when removing the worker, please try again.',
    'ERROR_WORKER_NOT_SAVED' => 'Something went wrong when saving the workers, please try again.',
    'ERROR_SURNAME_EMPTY' => 'The surname can\'t be empty.',
    'ERROR_EMAIL_INVALID' => 'The email has invalid format.',
    'EMPTY_OPTION' => 'None',
    'ERROR_PRODUCT_NUMBER_EMPTY' => 'The product number can\'t be empty.',
    'ERROR_DESCRIPTION_EMPTY' => 'The description can\'t be empty.',
    'ERROR_PRODUCT_SPECIFICATIONS_EMPTY' => 'The product specification can\'t be empty.',
    'ERROR_PRODUCT_DATASHEET_EMPTY' => 'The product datasheet can\'t be empty.',
    'ERROR_THUMBNAIL_EMPTY' => 'The thumbnail can\'t be empty',
    'ERROR_THUMBNAIL_FILE_TOO_BIG' => 'The thumbnail size is too big.',
    'ERROR_PRODUCT_PRICE_EMPTY' => 'The product price can\'t be empty',
    'MESSAGE_PRODUCT_CREATED' => 'The product has been created successfully.',
    'MESSAGE_PRODUCT_REMOVED' => 'The product has been removed successfully.',
    'ERROR_PRODUCT_NOT_REMOVED' => 'There was a problem when removing the product, please try again.',
    'MESSAGE_PRODUCTS_SAVED' => 'The products have been saved successfully',
    'ERROR_PRODUCTS_NOT_SAVED' => 'Something went wrong when saving the products, please try again.',
    'ERROR_PRICE_INVALID' => 'The price must be a valid float number, for example 10.0, 35.13 etc',
    'MESSAGE_CATEGORY_CREATED' => 'The category has been created successfully.',
    'MESSAGE_CATEGORY_REMOVED' => 'The category has been removed successfully.',
    'ERROR_CATEGORY_NOT_REMOVED' => 'There was a problem when removing the category, please try again.',
    'MESSAGE_CATEGORIES_SAVED' => 'The categories have been saved successfully',
    'ERROR_CATEGORY_EXISTS' => 'The category name already exists, try a new one.',
    'ERROR_CATEGORIES_NOT_SAVED' => 'Something went wrong when saving the categories, please try again.',
    'ERROR_POST_TITLE_EMPTY' => 'The post title can\'t be empty.',
    'ERROR_POST_TITLE_INVALID_LENGTH' => 'The post title must be between 4-50 characters long.',
    'ERROR_POST_CONTENT_EMPTY' => 'The post content can\'t be empty',
    'MESSAGE_POST_CREATED' => 'The post has been created successfully.',
    'MESSAGE_POST_REMOVED' => 'The post has been removed successfully.',
    'ERROR_POST_NOT_REMOVED' => 'There was a problem when removing the post, please try again.',
    'MESSAGE_POSTS_SAVED' => 'The posts have been saved successfully',
    'ERROR_POSTS_NOT_SAVED' => 'Something went wrong when saving the posts, please try again.',
    'ERROR_POST_EXISTS' => 'A post with the same title already exists, please update the post title.',
    'ERROR_PRODUCT_NUMBER_EXISTS' => 'A product with the same product number exists, please try a new one.',
    'ERROR_POST_TITLE_INVALID' => 'The post title must contain at least one word with 4 letters or more.',
    'ERROR_WEBSITE_EMPTY' => 'The website can\'t be empty.',
    'MESSAGE_PARTNER_CREATED' => 'The partner has been created successfully.',
    'MESSAGE_PARTNER_REMOVED' => 'The partner has been removed successfully.',
    'ERROR_PARTNER_NOT_REMOVED' => 'There was a problem when removing the partner, please try again.',
    'MESSAGE_PARTNERS_SAVED' => 'The partners have been saved successfully',
    'ERROR_PARTNERS_NOT_SAVED' => 'Something went wrong when saving the partners, please try again.',
    'ERROR_POSITION_EMPTY' => 'The position can\'t be empty.',
    'ERROR_CAPTION_EMPTY' => 'The caption can\'t be empty.',
    'MESSAGE_SLIDE_CREATED' => 'The slide has been created successfully.',
    'MESSAGE_SLIDE_REMOVED' => 'The slide has been removed successfully.',
    'ERROR_SLIDE_NOT_REMOVED' => 'There was a problem when removing the slide, please try again.',
    'MESSAGE_SLIDES_SAVED' => 'The slides have been saved successfully',
    'ERROR_SLIDES_NOT_SAVED' => 'Something went wrong when saving the slides, please try again.',
    'MESSAGE_CONTENTS_SAVED' => 'The contents have been saved successfully',
    'ERROR_CONTENTS_NOT_SAVED' => 'Something went wrong when saving the contents, please try again.',
    'EMAIL_ERROR' => 'The message failed to be submitted, please try again.',
    'EMAIL_SUCCESS' => 'Your message has been sent successfully.',
    'PLACEHOLDER_SENDER' => 'Enter your email..',
    'PLACEHOLDER_SUBJECT' => 'Enter the subject..',
    'PLACEHOLDER_BODY' => 'Enter your message..',
    'LABEL_SENDER' => 'From (Email):',
    'LABEL_SUBJECT' => 'Subject:',
    'LABEL_BODY' => 'Body:',
    'ERROR_SUBJECT_EMPTY' => 'The subject can\'t be empty.',
    'ERROR_SUBJECT_INVALID_LENGTH' => 'The subject length must be between between 10-30 characters long.',
    'ERROR_BODY_EMPTY' => 'The body can\'t be empty.',
    'ERROR_BODY_INVALID_LENGTH' => 'The body length must be at least 20 characters long.',
    'ERROR_SENDER_EMPTY' => 'The sender email can\'t be empty.',
    'ERROR_SENDER_INVALID' => 'The sender email is invalid.',
    'ERROR_POSITION_INVALID' => 'The position must be a valid integer between 1-999',
    'ERROR_TITLE_EMPTY' => 'The title can\'t be empty.',
    'ERROR_CONTENT_EMPTY' => 'The content can\'t be empty.',
    'MESSAGE_ABOUT_CATEGORIES_SAVED' => 'The about categories have been saved successfully',
    'ERROR_ABOUT_CATEGORIES_NOT_SAVED' => 'Something went wrong when saving the about categories, please try again.',
    'MESSAGE_ABOUT_CATEGORY_REMOVED' => 'The about category has been removed successfully.',
    'ERROR_ABOUT_CATEGORY_NOT_REMOVED' => 'There was a problem when removing the about category, please try again.',
  ),
);
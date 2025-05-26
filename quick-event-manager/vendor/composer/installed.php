<?php return array(
    'root' => array(
        'name' => 'fullworks/quick-event-manager',
        'pretty_version' => 'dev-master',
        'version' => 'dev-master',
        'reference' => 'c2558d14b52783889811c0040c44e633a55669bc',
        'type' => 'wordpress-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'alanef/fullworks-template-loader-lib' => array(
            'pretty_version' => 'dev-master',
            'version' => 'dev-master',
            'reference' => 'af25c1e55f01e55964e60eaab88281a7ee9c7e80',
            'type' => 'library',
            'install_path' => __DIR__ . '/../alanef/fullworks-template-loader-lib',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
        'composer/installers' => array(
            'pretty_version' => 'v1.0.12',
            'version' => '1.0.12.0',
            'reference' => '4127333b03e8b4c08d081958548aae5419d1a2fa',
            'type' => 'composer-installer',
            'install_path' => __DIR__ . '/./installers',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'freemius/wordpress-sdk' => array(
            'pretty_version' => '2.12.0',
            'version' => '2.12.0.0',
            'reference' => 'db6f35a2b3d318a53330409dbeab49156ee76dd8',
            'type' => 'library',
            'install_path' => __DIR__ . '/../freemius/wordpress-sdk',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'fullworks/quick-event-manager' => array(
            'pretty_version' => 'dev-master',
            'version' => 'dev-master',
            'reference' => 'c2558d14b52783889811c0040c44e633a55669bc',
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'shama/baton' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '*',
            ),
        ),
    ),
);

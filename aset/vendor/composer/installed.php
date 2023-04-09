<?php return array(
    'root' => array(
        'name' => '__root__',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => NULL,
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        '__root__' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => NULL,
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'twbs/bootstrap' => array(
            'pretty_version' => 'v5.3.0-alpha1',
            'version' => '5.3.0.0-alpha1',
            'reference' => 'cf9454caa00872899215603e5e036d9a824b1b11',
            'type' => 'library',
            'install_path' => __DIR__ . '/../twbs/bootstrap',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'twbs/bootstrap-icons' => array(
            'pretty_version' => 'v1.10.3',
            'version' => '1.10.3.0',
            'reference' => '817d780a476dbb24b269a89ba56ff1d0d4125132',
            'type' => 'library',
            'install_path' => __DIR__ . '/../twbs/bootstrap-icons',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'twitter/bootstrap' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => 'v5.3.0-alpha1',
            ),
        ),
    ),
);

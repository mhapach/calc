<?php

return [
    'fileables' => [
        'calculation' => 'Calc\Model\Calculation',
        'order'       => 'Calc\Model\Order',
    ],
//    'allowedExtensions' => ['jpeg','png','zip','rar','pdf','doc','docx','gif','bmp','mp4','avi'],
    'date_format' => 'd.m.Y',
    'aliases' => [
        'AuthController'                       => 'Controller\AuthController',
        'DashboardController'                  => 'Controller\DashboardController',
        'ManagersController'                   => 'Controller\ManagersController',
        'CalculationController'                => 'Controller\CalculationController',
        'OrdersController'                     => 'Controller\OrdersController',
        'ContractorsController'                => 'Controller\ContractorsController',
        'ClientsController'                    => 'Controller\ClientsController',
        'PartsController'                      => 'Controller\PartsController',
        'CoefficientsController'               => 'Controller\CoefficientsController',
        'ProfileController'                    => 'Controller\ProfileController',
        'MakeOrderController'                  => 'Controller\MakeOrderController',
        'ElementsController'                   => 'Controller\ElementsController',

        // Api Controllers
        'Api\ManagersController'               => 'Controller\Api\ManagersController',
        'Api\CalculationsController'           => 'Controller\Api\CalculationsController',
        'Api\OrdersController'                 => 'Controller\Api\OrdersController',
        'Api\ContractorsController'            => 'Controller\Api\ContractorsController',
        'Api\ClientsController'                => 'Controller\Api\ClientsController',
        'Api\PartsController'                  => 'Controller\Api\PartsController',
        'Api\CoefficientsController'           => 'Controller\Api\CoefficientsController',
        'Api\AdditionalCoefficientsController' => 'Controller\Api\AdditionalCoefficientsController',
        'Api\ConstructorsRatesController'      => 'Controller\Api\ConstructorsRatesController',
        'Api\GroupsPartsController'            => 'Controller\Api\GroupsPartsController',
        'Api\VariablesController'              => 'Controller\Api\VariablesController',
        'Api\HelpersController'                => 'Controller\Api\HelpersController',
        'Api\FilesController'                  => 'Controller\Api\FilesController',
        'Api\ElementsController'               => 'Controller\Api\ElementsController',

        // Presenters
        'UserPresenter'                        => 'Presenters\UserPresenter',
        'ClientPresenter'                      => 'Presenters\ClientPresenter',
        'ContractorPresenter'                  => 'Presenters\ContractorPresenter',
        'PartPresenter'                        => 'Presenters\PartPresenter',
    ],
    'repositories' => [
        'calculations' => 'Repo\CalculationRepo',
        'calculation_subjects' => 'Repo\CalculationSubjectRepo',
        'clients' => 'Repo\ClientRepo',
        'contractors' => 'Repo\ContractorRepo',
        'files' => 'Repo\FileRepo',
        'orders' => 'Repo\OrderRepo',
        'part_groups' => 'Repo\PartGroupRepo',
        'parts' => 'Repo\PartRepo',
        'subject_elements' => 'Repo\SubjectElementRepo',
        'users' => 'Repo\UserRepo',
        'elements' => 'Repo\ElementsRepo',
    ],
];

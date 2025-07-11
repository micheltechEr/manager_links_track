<?php
return [
    '' => 'HomeController@index',
    'register' => 'UserController@showSignUpPage',
    'registerUser' => 'UserController@registerUser', // <- rota que trata o POST
    'login' => 'UserController@showLoginPage',
    'loginUser' => 'UserController@loginUser',
    'logout' => 'UserController@logoutUser',
    'dashboard' => 'DashboardController@index',
    'profilePage' => 'UserController@showProfilePage',
    'changePassword' => 'UserController@changePassword',
    'updateUserInfo' => 'UserController@updateUserInfo',
    'deleteUserAccount' => 'UserController@deleteUserAccount',
    'linkControllerPage' => 'LinksController@showLinkController',
    'saveLinks' => 'LinksController@saveLinks',
    'listLinks' => 'LinksController@listLinks',
    'editLinks' => 'LinksController@editLinks',
    'removeLinks' => 'LinksController@removeLinks',
];

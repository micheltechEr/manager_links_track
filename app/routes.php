<?php
return [
    '' => 'HomeController@index',
    'register' => 'UserController@showSignUpPage',
    'registerUser' => 'UserController@registerUser', // <- rota que trata o POST
    'login' => 'UserController@showLoginPage',
    'loginUser' => 'UserController@loginUser',
    'logout' => 'UserController@logoutUser',
    'dashboard' => 'DashboardController@index',
    'profilePage' => 'UserController@showProfilePage'
];

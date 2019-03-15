<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['api', 'cu'], 'namespace' => 'ContactUser', 'prefix' => 'v1/cu'], function () {
    // Assignments
    Route::post('/assignments',                 'AssignmentsController@store');
    Route::get('/assignments/{id}',             'AssignmentsController@show');
    Route::patch('/assignments/{id}',           'AssignmentsController@update');
    Route::delete('/assignments/{id}',          'AssignmentsController@destroy');
    Route::get('/assignments/{id}/finished',    'AssignmentsController@assignmentFinished');
    Route::get('/assignments/{id}/declined',    'AssignmentsController@assignmentDeclined');

    // Assignment Categories
    Route::get('/assignmentcategories', 'AssignmentCategoriesController@index');

    // Assignment Forms
    Route::get('/assignmentforms', 'AssignmentFormsController@index');

    // Assignment Statuses
    Route::get('/assignmentstatuses', 'AssignmentStatusesController@index');

    // Assignment Templates
    Route::get('/assignmenttemplates', 'AssignmentTemplatesController@index');

    // Chats
    Route::get('/chats',                    'ChatsController@index');
    Route::get('/chats/{id}/chatmessages',  'ChatsController@chatMessages');
    Route::post('/chats/{id}/chatmessages', 'ChatsController@storeChatMessages');

    // Chat Statuses
    Route::get('/chatstatuses', 'ChatStatusesController@index');

    // Chat Message Statuses
    Route::get('/chatmessagestatuses', 'ChatMessageStatusesController@index');

    // Evaluations
    Route::get('/evaluations/{id}/evaluationanswers', 'EvaluationsController@getEvaluationAnswers');
    Route::post('/evaluations/{id}/evaluationanswers', 'EvaluationsController@storeEvaluationAnswers');

    // Evaluation Answers
    Route::post('/evaluationanswers',           'EvaluationAnswersController@store');
    Route::patch('/evaluationanswers/{id}',     'EvaluationAnswersController@update');
    Route::delete('/evaluationanswers/{id}',    'EvaluationAnswersController@destroy');

    // Evaluation Answer Categories
    Route::get('/evaluationanswercategories', 'EvaluationAnswerCategoriesController@index');

    // Evaluation Statuses
    Route::get('/evaluationstatuses', 'EvaluationStatusesController@index');

    // FAQs
    Route::get('/faqs',         'FaqsController@index');
    Route::post('/faqs',        'FaqsController@store');
    Route::get('/faqs/{id}',    'FaqsController@show');
    Route::patch('/faqs/{id}',  'FaqsController@update');
    Route::delete('/faqs/{id}', 'FaqsController@destroy');

    // FAQ Categories
    Route::get('/faqcategories', 'FaqCategoriesController@index');

    // Goals
    Route::post('/goals',                     'GoalsController@store');
    Route::get('/goals/{id}',                 'GoalsController@show');
    Route::patch('/goals/{id}',               'GoalsController@update');
    Route::delete('/goals/{id}',              'GoalsController@destroy');
    Route::get('/goals/{id}/finished',        'GoalsController@goalFinished');
    Route::patch('/goals/{id}/updateenddate',  'GoalsController@updateGoalEndDate');

    // Goal Categories
    Route::get('/goalcategories', 'GoalCategoriesController@index');

    // Goal Statuses
    Route::get('/goalstatuses', 'GoalStatusesController@index');

    // Goal Templates
    Route::get('/goaltemplates', 'GoalTemplatesController@index');

    // Users
    Route::get('/users',                                    'UsersController@index');
    Route::post('/users',                                   'UsersController@store');
    Route::get('/users/me',                                 'UsersController@me');
    Route::get('/users/globalstatuses',                     'UsersController@globalStatuses');
    Route::get('/users/{id}',                               'UsersController@show');
    Route::patch('/users/{id}/userdetails',                 'UsersController@update');
    Route::patch('/users',                                  'UsersController@updateMe');
    Route::delete('/users',                                 'UsersController@destroyMe');
    Route::delete('/users/{id}',                            'UsersController@destroy');
    Route::get('/users/{user_id}/assignments',              'UsersController@assignments');
    Route::get('/users/{user_id}/plans',                    'UsersController@plans');
    Route::get('/users/{user_id}/goals',                    'UsersController@goals');
    Route::get('/users/{user_id}/evaluations',              'UsersController@evaluations');
    Route::get('/users/{user_id}/chats',                    'UsersController@chats');
    Route::patch('/users/userconfigurations',               'UsersController@updateUserConfigurations');
    Route::get('/users/{user_id}/goals/{goal_id}/finished', 'UsersController@finishedGoals');

    // User Relationships
    Route::get('/userrelationships',    'UserRelationshipsController@index');
    Route::post('/userrelationships',   'UserRelationshipsController@store');
    Route::delete('/userrelationships/{id}', 'UserRelationshipsController@destroy');

    // User Roles
    Route::get('/userroles', 'UserRolesController@index');
});

Route::group(['middleware' => ['api', 'au'], 'namespace' => 'AdolescentUser', 'prefix' => 'v1/au'], function () {
    // Assignments
    Route::get('/assignments',                  'AssignmentsController@index');
    Route::post('/assignments/{id}/done',    'AssignmentsController@assignmentDone');

    // Chats
    Route::get('/chats',                    'ChatsController@index');
    Route::get('/chats/{id}/chatmessages',  'ChatsController@chatMessages');
    Route::post('/chats/{id}/chatmessages', 'ChatsController@storeChatMessages');

    // Chat Messages
    Route::post('/chatmessages', 'ChatMessagesController@store');

    // Evaluations
    Route::get('/evaluations', 'EvaluationsController@index');

    // Faqs
    Route::get('/faqs', 'FaqsController@index');

    // Feedback
    Route::post('/feedback', 'FeedbackController@store');

    // Feedback Categories
    Route::get('/feedbackcategories', 'FeedbackCategoriesController@index');

    // Users
    Route::get('/users/me',                     'UsersController@me');
    Route::patch('/users/me/userdetails',       'UsersController@updateUserDetails');
    Route::delete('/users/me',                  'UsersController@destroyMe');
    Route::patch('/users/userconfigurations',   'UsersController@updateUserConfigurations');
    Route::get('/users/{id}/chats',             'UsersController@chats');
    Route::get('/users/globalstatuses',         'UsersController@globalStatuses');
    Route::get('/users/plans',                  'UsersController@plans');
});

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function () {
    // Devices
    Route::post('/devices', 'DevicesController@store');
    Route::delete('/devices', 'DevicesController@destroy');

    // Files
    Route::post('/files/images/base64',  'FilesController@base64Image');
    Route::post('/files/images/file',    'FilesController@imageFile');
    Route::post('/files/images/url',     'FilesController@imageUrl');

    Route::get('/pushnotifications/test/me', 'PushNotificationsController@testToMe');
});

Route::group(['middleware' => 'auth', 'namespace' => 'Auth', 'prefix' => 'v1/auth'], function () {
    // Authentications
    Route::post('/login',       'AuthenticationsController@login');
    Route::get('/logout',       'AuthenticationsController@logout');
    Route::get('/refreshtoken', 'AuthenticationsController@refreshToken');
});

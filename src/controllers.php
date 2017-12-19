<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
//Request::setTrustedProxies(array('127.0.0.1'));

// Set / Modify Password page
$routePwd = $app->match('/password/{token}', "Controller\UserController::modifyPwdAction") ;
$routePwd->bind('password') ;

// Login page
$routeLogin = $app->match('/', "Controller\UserController::loginAction") ;
$routeLogin->bind('login') ;

// Home page
$routeHome = $app->get('/home', "Controller\UserController::homeAction") ;
$routeHome->bind('home') ;

// Profile page
$routeProfile = $app->get('/profile', "Controller\UserController::profileAction") ;
$routeProfile->bind('profile') ;

// My activities page
$routeMyActivities = $app->get('/myactivities', "Controller\ActivityController::getAllUserActivitiesAction") ;
$routeMyActivities->bind('myActivities') ;

// Organization activities page
$routeMyActivities = $app->get('/activities/all', "Controller\ActivityController::getAllOrganizationActivitiesAction") ;
$routeMyActivities->bind('allActivities') ;

// Activity creation : parameters page
$routeActivityCreationParameters = $app->match('/activity/create/parameters', "Controller\ActivityController::addCriterionAction") ;
$routeActivityCreationParameters->bind('activityCreationParameters') ;

// Activity creation : users page
$routeActivityCreationParticipants = $app->get('/activity/create/participants/{actId}', "Controller\ActivityController::addParticipantsAction") ;
$routeActivityCreationParticipants->bind('activityCreationParticipants') ;

// Activity modify page
$routeActivityGrade = $app->match('/activity/{actId}/modify', "Controller\ActivityController::modifyAction") ;
$routeActivityGrade->bind('activityModify') ;

// Activity grade page
$routeActivityGrade = $app->get('/activity/{actId}/grade', "Controller\ActivityController::gradeAction") ;
$routeActivityGrade->bind('activityGrade') ;



// Activity view page
$routeActivityView = $app->get('/activity/view', "Controller\ActivityController::viewAction") ;
$routeActivityView->bind('activityView') ;

// Activity results page
$routeActivityResults = $app->get('/activity/results', "Controller\ActivityController::resultsAction") ;
$routeActivityResults->bind('activityResults') ;

// Settings organization page
$routeSettingsOrganization = $app->get('/settings/organization', "Controller\OrganizationController::addOrganizationAction") ;
$routeSettingsOrganization->bind('settingsOrganization') ;

// Settings users page
$routeSettingsUser = $app->get('/settings/users', sprintf('%s::getAllUsersAction', \Controller\UserController::class)) ;
$routeSettingsUser->bind('settingsUsers') ;

// Settings users page
$routeSettingsUser = $app->match('/settings/users/create', sprintf('%s::addUserAction', \Controller\UserController::class)) ;
$routeSettingsUser->bind('createUser') ;

// Settings position page
$routeSettingsPosition = $app->get('/settings/position-weight', "Controller\UserController::positionWeightAction") ;
$routeSettingsPosition->bind('settingsPositionWeight') ;

/* AJAX */
$routeAjaxUserGet = $app->get('/ajax/user/{id}', "Controller\UserController::findById") ;
$routeAjaxUserGet->bind('ajaxUserGet');

$routeAjaxUserAdd = $app->post('/ajax/user', "Controller\UserController::addUserAction") ;
$routeAjaxUserAdd->bind('ajaxUserAdd');

$routeAjaxActivityAdd = $app->post('/ajax/activity/{actId}', "Controller\ActivityController::insertParticipantsAction") ;
$routeAjaxActivityAdd->bind('ajaxActivityAdd');

$routeAjaxUserModifiy = $app->post('/ajax/user/{id}', "Controller\UserController::modifyUserAction") ;
$routeAjaxUserModifiy->bind('ajaxUserModify');

$routeAjaxUserDelete = $app->delete('/ajax/user/{id}', "Controller\UserController::deleteUserAction") ;
$routeAjaxUserDelete->bind('ajaxUserDelete') ;

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});

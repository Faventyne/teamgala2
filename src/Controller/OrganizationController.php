<?php
/**
 * Created by IntelliJ IDEA.
 * User: Etudiant
 * Date: 12/12/2017
 * Time: 16:49
 */
namespace Controller;

use Form\UserForm;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Model\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Model\Activity;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class OrganizationController extends \MasterController
{
    //Adds organization (limited to root master)
    public function addOrganizationAction(Request $request, Application $app){

    }

    //Modifies organization (limited to root master)
    public function modifyOrganizationAction(Request $request, Application $app){

    }

    //Deletes organization (limited to root master)
    public function deleteOrganizationAction(Request $request, Application $app){

    }
}
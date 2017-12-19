<?php
/**
 * Created by IntelliJ IDEA.
 * User: Faventyne
 * Date: 05/12/2017
 * Time: 00:49
 */
namespace Controller;

use Doctrine\Common\Collections\Criteria;
use Form\AddActivityCriteriaForm;
use Form\AddActivityParticipantsForm;
use Form\UserForm;
use Form\GradeForm;
use Model\Activity;
use Model\ActivityUser;
use Model\Grade;
use Model\Stage;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Model\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Model\Criterion;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ActivityController extends MasterController
{


    //ACTIVITY CREATION

    // 1st step - criterion definition (limited to activity manager)

    public function addCriterionAction(Request $request, Application $app){

        $criterion = new Criterion() ;
        $activity = new Activity();
        $entityManager=$this->getEntityManager($app);
        $formFactory = $app['form.factory'] ;
        $criterionForm = $formFactory->create(AddActivityCriteriaForm::class, $criterion , ['standalone'=>true]) ;
        $criterionForm->handleRequest($request);

        if ($criterionForm->isSubmitted()){
            if ($criterionForm->isValid()){

                //Settings activity parameters before inserting ("forcing") foreign key act_id in criterion
                $activity->setDeadline($criterionForm->get('deadline')->getData());
                $activity->setVisibility($criterionForm->get('visibility')->getData());
                $activity->setObjectives($criterionForm->get('objectives')->getData());
                $activity->setName($criterionForm->get('name')->getData());
                $entityManager->persist($activity);
                $entityManager->flush();
                $activityId = $activity->getId();
                $criterion->setActId($activityId);
                $entityManager->persist($criterion);
                $entityManager->flush();
                $_SESSION['created_act_id']=$activityId;

                return $app->redirect($app['url_generator']->generate('activityCreationParticipants',['actId' => $activityId]));




                /*
                //Subrequest to get to participants and keep param values with post method
                // as activity will not be inserted in DB till act mgr does not finish activity creation
                $subrequest = Request::create($app['url_generator']->generate('activityCreationParticipants'), 'POST', $_POST, $_COOKIE, $_FILES, $_SERVER);
                $app->handle($subrequest,HttpKernelInterface::SUB_REQUEST);
                */
            //return $app->redirect($app['url_generator']->generate('activityCreationParticipants'));
            } else {
                return $criterionForm->getErrors();
            }
        }

        return $app['twig']->render('criteria_list.twig',
                [
                    'form' => $criterionForm->createView()
                ]) ;
    }

    // 2 - Display participants to be added

    public function addParticipantsAction(Request $request, Application $app, $actId){

        // Get all participants (users)
        $entityManager = $this->getEntityManager($app) ;
        $activityuser = new ActivityUser();
        $repository = $entityManager->getRepository(\Model\User::class);
        $result = [];
        foreach ($repository->findAllActive() as $user) {
            $result[] = $user->toArray($app);
        }

        return $app['twig']->render('participants_list.html.twig',
            [
                'participants' => $result,
            ]);


    }


    //AJAX call which inserts users in created activity

    public function insertParticipantsAction(Request $request, Application $app, $actId){

        // Get all participants (users)
        $entityManager = $this->getEntityManager($app) ;

        //return print_r($_POST['parId'])

        foreach ($_POST['usrId'] as $usrId) {
            $activityuser = new ActivityUser();
            $activityuser->setActId($actId);
            $activityuser->setUsrId($usrId);
            $entityManager->persist($activityuser);


        }
        $entityManager->flush();

        return true;

        /*
        return $app['twig']->render('participants_list.html.twig',
            [
                'participants' => $result,
                //'form' => $participantsForm->createView()
            ]);
        */

    }



    //Update activity (limited to activity manager)
    public function modifyActivityAction(Request $request, Application $app){

    }
    //Delete activity (limited to HR)
    public function deleteActivityAction(Request $request, Application $app){

    }

    /*********** ADDITION, MODIFICATION, DELETION AND DISPLAY OF PARTICIPANTS *****************/

    // Display all participants (after Activity Mgr sets activities parameters)
    public function getAllParticipantsAction(Request $request, Application $app){
        $entityManager = $this->getEntityManager($app) ;
        $repository = $entityManager->getRepository(\Model\User::class);
        $result = [];
        foreach ($repository->findAll() as $user) {
            $result[] = $user->toArray();
        }

        return $app['twig']->render('participants_list.html.twig',
            [
                'users' => $result
            ]) ;

    }

    //Display selected activity (all users)
    public function viewAction(Request $request, Application $app){
        $repository = $app['orm.em']->getRepository(Activity::class);


    }
    //Modify Action
    public function modifyAction(Request $request,Application $app, $actId){
        //Get the datas about the activity selected
        $activity = new Activity();
        $entityManager = $this->getEntityManager($app) ;
        $repository = $entityManager->getRepository(Activity::class) ;
        $activity = $repository->findOneById($actId);    
        
        //Get the criteria of the activity
        $criterion = new Criterion();
        $entityManager = $this->getEntityManager($app) ;
        $repository = $entityManager->getRepository(Criterion::class) ;
        $criterion = $repository->findOneByActId($actId); 
        var_dump ($criterion);
        
        $formFactory = $app['form.factory'] ;
        $modifyActivityForm = $formFactory->create(AddActivityCriteriaForm::class, $criterion, ['standalone' => true]) ;
        $modifyActivityForm->handleRequest($request);
        
        if ($modifyActivityForm->isSubmitted()) {
            $activity->setDeadline($modifyActivityForm->get('deadline')->getData());
            $activity->setVisibility($modifyActivityForm->get('visibility')->getData());
            $activity->setObjectives($modifyActivityForm->get('objectives')->getData());
            $activity->setName($modifyActivityForm->get('name')->getData());
            $entityManager->persist($activity);
            $entityManager->persist($criterion);
            $entityManager->flush();
            return $app['twig']->render('participants_list.html.twig',
            [
                'participants' => [],
            ]);
        }
        return $app['twig']->render('activity_modify.html.twig',
                [
                    'form' => $modifyActivityForm->createView()
                ]) ;
        //Get the participants linked to the activity
        $sql = "SELECT * FROM user INNER JOIN activity_user ON activity_user.user_usr_id=user.usr_id INNER JOIN activity ON activity.act_id=activity_user.activity_act_id WHERE act_id=:actId";
        $pdoStatement = $app['db']->prepare($sql);
        $pdoStatement->bindValue(':actId', $actId);
        $pdoStatement->execute();
        $participants = $pdoStatement->fetchAll();
        var_dump($activity);
        
        
        return print_r($participants) ;
    }
    //Grade an activity (all users)
    public function gradeAction(Request $request, Application $app, $actId){

        $entityManager = $this->getEntityManager($app) ;
        $grade = new Grade();
        //Get all participants
        $repository = $entityManager->getRepository(\Model\ActivityUser::class);
        $participants = [];


        foreach ($repository->findByActId($actId) as $participant) {
            //TODO : define toArray method in ActivityUser repository; create repository
            $participants[] = $participant->toArray();

        }

        //Get all criteria
        $repository = $entityManager->getRepository(\Model\Criterion::class);
        $criteria=[];

        foreach ($repository->findByActId($actId) as $criterion) {
            //TODO : define toArray method in Criteria repository; create repository
            $criteria[] = $criterion->toArray();
        }


        $formFactory = $app['form.factory'] ;
        $gradeForm = $formFactory->create(GradeForm::class, $grade, ['standalone'=>true]);
        $gradeForm->handleRequest($request);

        if ($gradeForm->isSubmitted()){

            print_r("Coucou");
            die;
        }

        $result=[];

        /*Feed all activity info in $result */

        //foreach($stage as $stage){
                $result['stage']['name']=1;
                //$result['stage']['name']=$stage;
            foreach($criteria as $criterion){
                $result['stage']['criterion']=$criterion;
                $result['stage']['participants']=$participants;
            }
        //}

        return $app['twig']->render('activity_grade.html.twig',
            [
                'form' => $gradeForm->createView(),
                'result' => $result,
                'actId' => $result['stage']['criterion']['actId'],
                'criId' => $result['stage']['criterion']['id'],

            ]) ;

    }

    //Get the results of an activity for habilited people
    public function resultsAction(Request $request, Application $app, $actId){
        $em = $app['orm.em'];

        //Accessing all repositories

        //Get users associated to activity
        $entityManager = $this->getEntityManager($app);
        $repoAU = $entityManager->getRepository(ActivityUser::class);
        $repoA = $em->getRepository(Activity::class);
        $repoU = $em->getRepository(User::class);
        $repoC = $em->getRepository(Criterion::class);
        $repoG = $em->getRepository(Grade::class);

        //Get data associated to the activity
        $activity = $repoA->findOneById($actId);
        
        //getting all activity users
        $activityUsers=$repoAU->findByActId($actId);

        //getting all criteria
        $criteria = $repoC->findByActId($actId);

        //getting all grades
        $grades = $repoG->findByActId($actId);

        /*****COMPUTE THE RESULTS****************************/

        //foreach ($stage as stage){

        foreach ($criteria as $criterion){

            $cweight = $criterion->getWeight();

            foreach ($activityUsers as $au){

                $id = $au->getUsrId();
                $user = $repoU->findOneById($id);
                $weight = $user->getWeightIni($id);
                //$grade = $repoG->finOneById

                //foreach ($)


            }
        }




        $repoU = $em->getRepository(User::class);
        //get the datas concerning the participants
        $participants = [];
        foreach ($activityUsers as $au) {
            $id = $au->getUsrId();
            $user = $repoU->findOneById($id);
            $participants[]=$user;
        }
        
        //rendering
        return $app['twig']->render('activity_results.html.twig',
            [
                'activity' => $activity,
                'activityUser' => $activityUser,
                'participants' => $participants,           
            ]);
    }

    // Display all organization activities (limited to HR)
    public function getAllOrganizationActivitiesAction(Request $request, Application $app){
        $entityManager = $this->getEntityManager($app);
        $repository = $entityManager->getRepository(Activity::class);
        $result = [];
        foreach ($repository->findAll() as $activity) {
            $result[] = $activity->toArray();
        }

        return $app['twig']->render('activities_list.html.twig',
            [
                'activities' => $result
            ]) ;

    }

    // Display all activities for current user
    public function getAllUserActivitiesAction(Request $request, Application $app){
        $role = $app['security.token_storage']->getToken()->getUser()->getRolId();
        $id = $app['security.token_storage']->getToken()->getUser()->getId();

        $sql = "SELECT * FROM activity 
            INNER JOIN activity_user ON activity_user.activity_act_id=activity.act_id
            INNER JOIN criterion ON activity.act_id = criterion.activity_act_id 
            INNER JOIN user ON user.usr_id=activity_user.user_usr_id 
            WHERE user.usr_id=:id 
            ORDER BY activity.act_id";

        $pdoStatement = $app['db']->prepare($sql) ;
        $pdoStatement->bindValue(':id',$id);
        $pdoStatement->execute();
        $result = $pdoStatement->fetchAll();
        $finalResult=[];
        foreach($result as $participant){
            $participant['isParticipant'] = 1;
            $finalResult[]=$participant;
        }

        if($role != 1) {
            return $app['twig']->render('activities_list.html.twig',
                [
                    'user_activities' => $finalResult
                ]);
        } else {
            $sql = "SELECT * FROM activity 
            INNER JOIN activity_user ON activity_user.activity_act_id=activity.act_id
            INNER JOIN criterion ON activity.act_id = criterion.activity_act_id 
            INNER JOIN user ON user.usr_id=activity_user.user_usr_id
            ORDER BY activity.act_id";
            $pdoStatement = $app['db']->prepare($sql) ;
            $pdoStatement->bindValue(':id',$id);
            $pdoStatement->execute();
            $resultAdmin = $pdoStatement->fetchAll();
            $finalResult=[];
            foreach ($resultAdmin as $key => $actAdmin){

                $actAdmin['isParticipant'] = 0 ;
                foreach ($result as $key => $act)
                    if ($actAdmin['act_id'] == $act['act_id']) {
                        $actAdmin['isParticipant'] = 1;
                        break;
                    }
                $finalResult[]=$actAdmin;
            }
            //print_r($finalResult);
            //die;

            return $app['twig']->render('activities_list.html.twig',
                [
                    'user_activities' => $finalResult
                ]);
        }

        /*return print_r($result);

        $repository = $entityManager->getRepository(Activity::class);
        $result = [];
        foreach ($repository->findByUsrId() as $activity) {
            $result[] = $activity->toArrayUser();
        }
        */
        return $app['twig']->render('activities_list.html.twig',
            [
                'user_activities' => $result
            ]) ;

    }

    public function saveGradesAction(Request $request, Application $app){

        //Insert Grades
        $entityManager = $this->getEntityManager($app);
        $repository = $entityManager->getRepository(Grade::class);

        foreach ($_POST as $key => $value){
            if($key=="usrId"){
                $parId=intval($value);
            }
            if($key=="actId"){
                $actId=intval($value);
            }
            if($key=="criId"){
                $criId=intval($value);
            }
        }

        foreach ($_POST as $key => $value){
            if(is_numeric($key)){
                $grade = new Grade();
                $grade->setParId($parId);
                $grade->setActId($actId);
                $grade->setCriId($criId);
                $grade->setGradedId($key);
                $grade->setValue(floatval($value));
                $entityManager->persist($grade);
            }
        }
        $entityManager->flush();
        return $app->redirect($app['url_generator']->generate('myActivities')) ;
    }

    public function activityResults(Request $request, Application $app,$actId)
    {





    }



    /*Optional : release an activity (all users)
    public function resultsAction(Request $request, Application $app){
        $repository = $app['orm.em']->getRepository(Activity::class);
    */
}

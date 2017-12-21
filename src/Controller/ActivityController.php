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
        $update = false ;

        foreach ($repository->findByActId($actId) as $participant) {
            //TODO : define toArray method in ActivityUser repository; create repository
            $participants[] = $participant->toArray();

        }
        //Add the grade of the participant : new name for the list of participants : $part
        $part=[];
        foreach ($participants as $participant) {
            $id = $participant['usr_id'];
            $connected = $app['security.token_storage']->getToken()->getUser()->getId();
            $sql = "SELECT grd_value FROM grade WHERE grd_graded_id=:id AND activity_user_activity_act_id=:actId AND activity_user_user_usr_id=:connected";
            $pdoStatement = $app['db']->prepare($sql);
            $pdoStatement->bindValue(':id',$id);
            $pdoStatement->bindValue(':actId', $actId);
            $pdoStatement->bindValue(':connected', $connected);
            $pdoStatement->execute();
            $grd = $pdoStatement->fetch();
            $participant['grade']=$grd['grd_value'];
            if ($grd['grd_value']!= null) {
                $update = true ;
            };
            $part[]=$participant;
        };

        //Get all criteria
        $repository = $entityManager->getRepository(\Model\Criterion::class);
        $criteria=[];

        foreach ($repository->findByActId($actId) as $criterion) {
            //TODO : define toArray method in Criteria repository; create repository
            $criteria[] = $criterion->toArray();
        }

        $result=[];

        /*Feed all activity info in $result */

        //foreach($stage as $stage){
                $result['stage']['name']=1;
                //$result['stage']['name']=$stage;
            foreach($criteria as $criterion){
                $result['stage']['criterion']=$criterion;
                $result['stage']['participants']=$part;
            }
        //}

        return $app['twig']->render('activity_grade.html.twig',
            [
                'result' => $result,
                'actId' => $result['stage']['criterion']['actId'],
                'criId' => $result['stage']['criterion']['id'],
                'update' => $update,
            ]) ;

    }

    //Get the results of an activity for intended users
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

        //getting all criteria (there is just one so findOneBy is enough)
        $criteria = $repoC->findByActId($actId);

        //getting all grades
        $grades = $repoG->findByActid($actId);

        //We compute the results until grading is not ended (here, as there are no third party
        //the square matrix condition is enough to check)
        if($repoAU->findOneByActId($actId)->getResult() == null)
            {

                //Computing results

                    //1 - retrieving relevant data

                //foreach ($stage as stage){
                    $results = [];
                    foreach ($criteria as $criterion) {

                        $critWeight = $criterion->getWeight();
                        $gradesMatrix = [];
                        $weights = [];


                        foreach ($activityUsers as $au) {

                            $usrId = $au->getUsrId();


                            $userGrades = $repoG->findBy(
                                ['actid' => $actId,
                                    'parid' => $usrId]);

                            $gradesRowMatrix = [];

                            foreach ($userGrades as $gradeElmt) {
                                $gradesRowMatrix[] = $gradeElmt->getValue();
                            }

                            $gradesMatrix[] = $gradesRowMatrix;


                            //get weights
                            $user = $repoU->findOneById($usrId);
                            $userWeight = $user->getWeightIni();
                            $weights[] = $userWeight;
                            //get users Id
                            $users[] = $usrId;
                        }
                    }

                //}

                $results = [];

                for ($i = 0; $i < sizeof($weights); $i++)
                {
                    $results[$i] = 0;
                    for ($j = 0; $j < sizeof($weights); $j++) {
                        $results[$i] += $gradesMatrix[$j][$i] * $weights[$j];

                    }

                    $results[$i] /= array_sum($weights);

                }

                    // 2 - Insert in DB participant results

                $renderedData = [];
                foreach ($activityUsers as $key => $activityUser) {

                    $id = $activityUser->getUsrId();
                    $user = $repoU->findOneById($id);

                    $firstname = $user->getFirstname();

                    $lastname = $user->getLastname();
                    $result = $results[$key];
                    $activityUser->setResult($results[$key]);
                    //$entityManager->persist($activityUser);

                    $renderedData[] =
                        [
                            'firstname' => $firstname,
                            'lastname' => $lastname,
                            'result' => $result
                        ];
                }

                $entityManager->flush();

            } else {

                $renderedData = [];
                foreach ($activityUsers as $key => $activityUser)
                {

                    $id = $activityUser->getUsrId();
                    $user = $repoU->findOneById($id);
                    $firstname = $user->getFirstname();
                    $lastname = $user->getLastname();
                    $result = $activityUser->getResult();
                    $renderedData[] =
                        [
                            'firstname' => $firstname,
                            'lastname' => $lastname,
                            'result' => $result
                        ];
                }
            }


            //rendering

        return $app['twig']->render('activity_results.html.twig',
            [
                'activity' => $activity,
                'data' => $renderedData,
                'lowerbound' => $criteria[0]->getLowerbound(),
                'upperbound' => $criteria[0]->getUpperbound()
            ]
        );
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

    if($role != 4) {
        $sql = "SELECT act_name,act_id,act_status,act_objectives,act_inserted,act_quotes_deadline,cri_gradetype,cri_lowerbound,cri_upperbound,cri_step FROM activity
            INNER JOIN activity_user ON activity_user.activity_act_id=activity.act_id 
            INNER JOIN criterion ON activity.act_id = criterion.activity_act_id 
            WHERE activity_user.user_usr_id=:id 
            GROUP BY (activity.act_id)
            ORDER BY activity.act_id";
    } else {
        $sql = "SELECT act_name,act_id,act_status,act_objectives,act_inserted,act_quotes_deadline,cri_gradetype,cri_lowerbound,cri_upperbound,cri_step FROM activity
            INNER JOIN activity_user ON activity_user.activity_act_id=activity.act_id
            INNER JOIN criterion ON activity.act_id = criterion.activity_act_id 
            GROUP BY (activity.act_id)
            ORDER BY activity.act_id";
    }
        $pdoStatement = $app['db']->prepare($sql);
        $pdoStatement->bindValue(':id', $id);
        $pdoStatement->execute();
        $result = $pdoStatement->fetchAll();
        $finalResult = [];
        foreach ($result as $participant) {
            $participant['isParticipant'] = 1;
            $finalResult[] = $participant;
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

    }

    public function saveGradesAction(Request $request, Application $app){

        //Insert Grades
        $entityManager = $this->getEntityManager($app);
        $repoG = $entityManager->getRepository(Grade::class);

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
        
        // If it is the first time the users grades the activity
        if ($_POST['update']==false) {
            foreach ($_POST as $key => $value){
                if(is_numeric($key)){
                    $grade = new Grade();
                    $grade->setParId($parId);
                    $grade->setActId($actId);
                    $grade->setCriId($criId);
                    $grade->setGradedId($key);
                    $grade->setValue(floatval($value));
                    $entityManager->persist($grade);
                    //Change activity status to 'On Grade'
                } else {
                    $grade->setComment($value);
                }
            }

            $entityManager->flush();

            //Set status to 1 if user grades
            $repoA = $entityManager->getRepository(Activity::class);
            $activity = $repoA->findOneById($actId);
            $activity->setStatus(1);
            $entityManager->persist($activity);
            $entityManager->flush();

            //Check if all grades have been submitted, then result can now be computed
            if(sizeof($repoG->findByActid($actId)) == pow(sizeof($entityManager->getRepository(ActivityUser::class)->findByActId($actId)),2))
            {
                $activity->setStatus(2);
                $entityManager->persist($activity);
                $entityManager->flush();
            }
        //...otherwise
        } else {
            foreach ($_POST as $key => $value){
                if(is_numeric($key)){
                    //find the grd_id
                    $sql = "SELECT grd_id FROM grade WHERE grd_graded_id=:id AND activity_user_activity_act_id=:actId AND activity_user_user_usr_id=:connected";
                    $pdoStatement = $app['db']->prepare($sql);
                    $pdoStatement->bindValue(':id',$key);
                    $pdoStatement->bindValue(':actId', $actId);
                    $pdoStatement->bindValue(':connected', $parId);
                    $pdoStatement->execute();
                    $grdId = $pdoStatement->fetch();
                    $gradeId = $grdId['grd_id'];
                    //get the grade object that correspond to the grd_id
                    $grade = $repository->findOneById($gradeId);
                    //modify the values
                    $grade->setParId($parId);
                    $grade->setActId($actId);
                    $grade->setCriId($criId);
                    $grade->setGradedId($key);
                    $grade->setValue(floatval($value));
                    $entityManager->persist($grade);
                }
            }
        $entityManager->flush();
        }

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

<?php
/**
 * Created by IntelliJ IDEA.
 * User: Faventyne
 * Date: 05/12/2017
 * Time: 00:48
 */

namespace Controller;


use Silex\Application;
use Form\AddUserForm;
use Form\LogInForm;
use Form\SignUpForm;
use Symfony\Component\HttpFoundation\Request;
use Model\User;
use Model\Position;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Model\Activity;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\DateTime;

class UserController extends MasterController
{


    /*********** ADDITION, MODIFICATION, DELETION AND DISPLAY OF USERS *****************/

    //Adds user to current organization (limited to HR)
    public function addUserAction(Request $request, Application $app){
        $user = new User() ;
        $position = new Position();
        //Create the addUserForm
        $formFactory = $app['form.factory'] ;
        $userForm = $formFactory->create(AddUserForm::class, $user, ['standalone'=>true]) ;
        $userForm->handleRequest($request) ;
        $errorMessage = '';
        //Form submitted and valid
        if ($userForm->isSubmitted() && $userForm->isValid()) {

            // Email : check wether the email exists or not
            $entityManager = $this->getEntityManager($app) ;
            $repository = $entityManager->getRepository(User::class) ;
            $userExists = $repository->findOneByEmail($user->getEmail());

            if ($userExists != NULL) {
                $errorMessage = 'User already created' ;
            } else {

                $token = md5(rand()) ;
                $user->setToken($token) ;
                $entityManager = $app['orm.em'] ;

                //If users sets a new position and do not chose between existing one, we just flush the new position
                //before inserting the user
                if($userForm->get('positionName')->getData() != ''){

                    $position->setName($userForm->get('positionName')->getData());
                    $entityManager->persist($position);
                    $entityManager->flush();
                    $positionId = $position->getId();
                    $user->setPosId($positionId);
                    $entityManager->persist($user);
                    $entityManager->flush();

                }

                // Sending a message to the added user
                $message = \Swift_Message::newInstance()
                ->setSubject('Your Serpico account has been created')
                ->setFrom(array('noreply@serpico.com' => 'no reply'))
                ->setTo(array($user->getEmail()))
                ->setBody("url/password/$token", 'text/plain');

                $app['mailer']->send($message);
                $app['swiftmailer.spooltransport']
                ->getSpool()
                ->flushQueue($app['swiftmailer.transport']) ;

                return $app->redirect($app['url_generator']->generate('settingsUsers'));

            }
        }

        return $app['twig']->render('create_user.html.twig',
                [
                    'form' => $userForm->createView(),
                    'message' => $errorMessage,
                ]) ;

    }
    // Modify pwd
    public function modifyPwdAction (Request $request, Application $app, $token)
    {
        $entityManager = $this->getEntityManager($app) ;
        $repository = $entityManager->getRepository(User::class) ;
        $user = $repository->findOneByToken($token);

        $formFactory = $app['form.factory'] ;
        $pwdForm = $formFactory->create(SignUpForm::class, $user, ['standalone' => true]) ;
        $pwdForm->handleRequest($request);

        if ($pwdForm->isSubmitted() /*&& $pwdForm->isValid()*/) {
            $encoder = $app['security.encoder_factory']->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), 'azerty');
            $user->setPassword($password);

            $user->setToken('');
            $entityManager->persist($user);
            $entityManager->flush();
            return $app->redirect($app['url_generator']->generate('login')) ;
        }

        return $app['twig']->render('signup.html.twig',
                [
                    'form' => $pwdForm->createView()
                ]) ;
    }

    // Modify user info  (ajax call)
    public function modifyUserAction(Request $request, Application $app){

    }

    // Delete user (ajax call)
    public function deleteUserAction(Request $request, Application $app, $id){
        $manager = $app['orm.em'];
        $repository = $manager->getRepository(User::class);
        $user = $repository->find($id);

        if (!$user) {
            $message = sprintf('User %d not found', $id);
            return $app->json(['status' => 'error', 'message' => $message], 404);
        }
        $user->setDeleted(new \DateTime());
        $manager->persist($user);
        //$manager->remove($user);
        $manager->flush();

        return $app->json(['status' => 'done']);
    }

    // Display all users (when HR clicks on "users" from /settings)
    public function getAllUsersAction(Request $request, Application $app){
        $entityManager = $this->getEntityManager($app) ;
        $repository = $entityManager->getRepository(User::class);
        $result = [];
        foreach ($repository->findAllActive() as $user) {

            $result[] = $user->toArray($app);

        }

        return $app['twig']->render('users_list.html.twig',
                [
                    'users' => $result
                ]) ;

    }

    /*********** USER LOGIN AND CONTEXTUAL MENU *****************/
    //Logs current user
    public function loginAction(Request $request,Application $app){

        return $app['twig']->render('login.html.twig',
            [
                'error' => $app['security.last_error']($request),
                'last_username' => $app['session']->get('security.last_username')
            ]);
    }

    //Displays the menu in relation with user role
    public function homeAction(Request $request, Application $app){

        return $app['twig']->render('home.html.twig',
            [
                //'error' => $app['security.last_error']($request),
                //'last_username' => $app['session']->get('security.last_username')
            ]);
    }

    /*********** ADDITION, MODIFICATION AND DELETION *****************/

    // Creates user position and weight
    public function addPositionWeightAction(Request $request, Application $app){

    }

    // Updates user position and weight
    public function modifyPositionWeightAction(Request $request, Application $app){

    }

}

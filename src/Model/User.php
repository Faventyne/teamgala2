<?php
/**
 * Created by IntelliJ IDEA.
 * User: Faventyne
 * Date: 04/12/2017
 * Time: 23:28
 */
namespace Model;

use Silex\Application;
use Model\Role;
/**
 * @Entity(repositoryClass="Repository\UserRepository")
 * @Table(name="user")
 */
class User extends DbObject implements \Symfony\Component\Security\Core\User\UserInterface
{

    /**
     * @Id()
     * @GeneratedValue()
     * @Column(name="usr_id", type="integer", nullable=false)
     * @var int
     */
    protected $id;

    /**
     * @Column(name="usr_firstname", type="string")
     * @var string
     */
    protected $firstname;
    /**
     * @Column(name="usr_lastname", type="string")
     * @var string
     */
    protected $lastname;

    /**
     * @Column(name="usr_birthdate", type="datetime")
     * @var \DateTime
     */
    protected $birthdate;

    /**
     * @Column(name="usr_email", type="string", nullable=true)
     * @var string
     */
    protected $email;
    /**
     * @Column(name="usr_password", type="string")
     * @var string
     */
    protected $password;
    /**
     * @Column(name="usr_picture", type="string")
     * @var string
     */
    protected $picture;
    /**
     * @Column(name="usr_token", type="string")
     * @var string
     */
    protected $token;
    /**
     * @Column(name="usr_weight_ini", length= 10, type="float")
     * @var float
     */
    protected $weight_ini;
    /**
     * @Column(name="usr_weight_1y", length= 10, type="float")
     * @var float
     */
    protected $weight_1y;
    /**
     * @Column(name="usr_weight_2y", length= 10, type="float")
     * @var float
     */
    protected $weight_2y;
    /**
     * @Column(name="usr_weight_3y", length= 10, type="float")
     * @var float
     */
    protected $weight_3y;
    /**
     * @Column(name="usr_weight_4y", length= 10, type="float")
     * @var float
     */
    protected $weight_4y;
    /**
     * @Column(name="usr_weight_5y", length= 10, type="float")
     * @var float
     */
    protected $weight_5y;
    /**
     * @ManyToOne(targetEntity="Role")
     * @JoinColumn(name="rol_id", referencedColumnName="role_rol_id")
     * @Column(name="role_rol_id", type="integer")
     * @var int
     */
    protected $rol_id;
    /**
     * @Column(name="position_pos_id", type="integer")
     * @var int
     */
    protected $pos_id;
    /**
     * @Column(name="usr_inserted", type="datetime")
     * @var /DateTime
     */
    protected $inserted;
    /**
     * @Column(name="usr_deleted", type="datetime")
     * @var /DateTime
     */
    protected $deleted;

    /**
     * User constructor.
     * @param int $id
     * @param string $firstname
     * @param string $lastname
     * @param string $username
     * @param string $birthdate
     * @param string $email
     * @param string $password
     * @param string $picture
     * @param string $token
     * @param float $weight_ini
     * @param float $weight_1y
     * @param float $weight_2y
     * @param float $weight_3y
     * @param float $weight_4y
     * @param float $weight_5y
     * @param int $rol_id
     * @param int $pos_id
     * @param /DateTime $inserted
     * @param /DateTime $deleted
     */
    public function __construct($id =0, $firstname='', $lastname='', $username='', $birthdate=null, $email='', $password='', $picture='', $token='', $weight_ini=0.0, $weight_1y=0.0, $weight_2y=0.0, $weight_3y=0.0, $weight_4y=0.0, $weight_5y=0.0, $rol_id=2, $pos_id=1, $inserted=null, $deleted=null)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthdate = $birthdate;
        $this->email = $email;
        $this->password = $password;
        $this->picture = $picture;
        $this->token = $token;
        $this->weight_ini = $weight_ini;
        $this->weight_1y = $weight_1y;
        $this->weight_2y = $weight_2y;
        $this->weight_3y = $weight_3y;
        $this->weight_4y = $weight_4y;
        $this->weight_5y = $weight_5y;
        $this->rol_id = $rol_id;
        $this->pos_id = $pos_id;
        parent::__construct($id,new \DateTime());
        $this->deleted = $deleted;
    }


    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    /**
     * @param /DateTime $inserted
     */
    public function setInserted($inserted)
    {
        $this->inserted = $inserted;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->email = $username;
    }
    /**
     * @return string
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param string $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return float
     */
    public function getWeightIni()
    {
        return $this->weight_ini;
    }

    /**
     * @param float $weight_ini
     */
    public function setWeightIni($weight_ini)
    {
        $this->weight_ini = $weight_ini;
    }

    /**
     * @return float
     */
    public function getWeight1y()
    {
        return $this->weight_1y;
    }

    /**
     * @param float $weight_1y
     */
    public function setWeight1y($weight_1y)
    {
        $this->weight_1y = $weight_1y;
    }

    /**
     * @return float
     */
    public function getWeight2y()
    {
        return $this->weight_2y;
    }

    /**
     * @param float $weight_2y
     */
    public function setWeight2y($weight_2y)
    {
        $this->weight_2y = $weight_2y;
    }

    /**
     * @return float
     */
    public function getWeight3y()
    {
        return $this->weight_3y;
    }

    /**
     * @param float $weight_3y
     */
    public function setWeight3y($weight_3y)
    {
        $this->weight_3y = $weight_3y;
    }

    /**
     * @return float
     */
    public function getWeight4y()
    {
        return $this->weight_4y;
    }

    /**
     * @param float $weight_4y
     */
    public function setWeight4y($weight_4y)
    {
        $this->weight_4y = $weight_4y;
    }

    /**
     * @return float
     */
    public function getWeight5y()
    {
        return $this->weight_5y;
    }

    /**
     * @param float $weight_5y
     */
    public function setWeight5y($weight_5y)
    {
        $this->weight_5y = $weight_5y;
    }

    /**
     * @return int
     */
    public function getRolId()
    {
        return $this->rol_id;
    }

    //Following posID & rolID reign key setters are irrelevant, but were inserted to create a form where HR forces the values of roles
    //in the user creation form, and not separately in the application (yet it will be done in the future)

    /**
     * @param int $rol_id
     */
    public function setRolId($rol_id)
    {
        $this->rol_id = $rol_id;
    }

    /**
     * @return int
     */
    public function getPosId()
    {
        return $this->pos_id;
    }

    /**
     * @param int $pos_id
     */
    public function setPosId($pos_id)
    {
        $this->pos_id = $pos_id;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }




    public function toArray(Application $app)
    {

        $position = $this->getEntityManager($app)->getRepository(Position::class)->find($this->getPosId())->getName();


        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'weight' => $this->weight_ini,
            'inserted' => $this->inserted,
            'position' => $position,
            'role' => $this->rol_id
        ];
    }

    public function eraseCredentials() {

    }

    public function getRoles() {
        global $app ;
        $sql = "SELECT rol_name FROM role INNER JOIN user ON user.role_rol_id=role.rol_id WHERE user.usr_id=:id" ;
        $pdoStatement = $app['db']->prepare($sql) ;
        $pdoStatement->bindValue(':id', $this->id) ;
        $pdoStatement->execute() ;
        $r = $pdoStatement->fetch() ;
        return $r;
    }

    public function getSalt() {

    }

    //Creation of external getters and setters to call the method when setting activity parameters in a User form
    public function setPositionName($posname){
        $position = new Position();
        $position->setName($posname);
    }

    public function getPositionName(){
        $position = new Position();
        return $position->getName();
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager (Application $app) {
        return $app['orm.em'] ;
    }


}

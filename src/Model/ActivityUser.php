<?php
/**
 * Created by IntelliJ IDEA.
 * User: Faventyne
 * Date: 05/12/2017
 * Time: 00:43
 */

namespace Model;

/**
 * @Entity()
 * @Table(name="activity_user")
 */
class ActivityUser
{
    
    /**
     * @Id()
     *@Column(name="activity_act_id", type="integer", nullable=false)
     * @var int
     */
    protected $actId;
    /**
     * @Id()
     *@Column(name="user_usr_id", type="integer", nullable=false)
     * @var int
     */
    protected $usrId;
    /**
     * @Column(name="a_u_distance", length= 10, type="float", nullable=true)
     * @var float
     */
    protected $distance;
    /**
     * @Column(name="a_u_result", length= 10, type="float", nullable=true)
     * @var float
     */
    protected $result;
    /**
     * @Column(name="a_u_type", type="string", columnDefinition="ENUM('contributor,thirdparty')")
     * @var string
     */
    protected $type;
    /**
     * @Column(name="a_u_mweight", length=10, type="float")
     * @var float
     */
    protected $mweight;
    /**
     * @Column(name="a_u_precomment", length=10, type="string")
     * @var string
     */
    protected $precomment;
    /**
     * @Column(name="a_u_ivp_bonus", length=10, type="float")
     * @var float
     */
    protected $ivp_bonus;
    /**
     * @Column(name="a_u_ivp_penalty", length=10, type="float")
     * @var float
     */
    protected $ivp_penalty;
    /**
     * @Column(name="a_u_of_bonus", length=10, type="float")
     * @var float
     */
    protected $of_bonus;
    /**
     * @Column(name="a_u_of_penalty", length=10, type="float")
     * @var float
     */
    protected $of_penalty;
    /**
     * @Column(name="a_u_inserted", type="datetime")
     * @var /DateTime
     */
    protected $inserted;


    /**
     * Participant constructor.
     * @param int $usr_id
     * @param int $act_id
     * @param float $distance
     * @param float $result
     * @param string $type
     * @param float $mweight
     * @param string $precomment
     * @param float $ivp_bonus
     * @param float $ivp_penalty
     * @param float $of_bonus
     * @param float $of_penalty

     */
    public function __construct($usrId=0, $actId=0, $distance=0.0, $result=0.0, $type='contributor', $mweight=0.0, $precomment='', $ivp_bonus=0.0, $ivp_penalty=0.0, $of_bonus=0.0, $of_penalty=0.0, $inserted=null)
    {
        $this->usr_id = $usrId;
        $this->actId = $actId;
        $this->distance = $distance;
        $this->result = $result;
        $this->type = $type;
        $this->mweight = $mweight;
        $this->precomment = $precomment;
        $this->ivp_bonus = $ivp_bonus;
        $this->ivp_penalty = $ivp_penalty;
        $this->of_bonus = $of_bonus;
        $this->of_penalty = $of_penalty;
        $this->inserted = new \DateTime();
    }
    
    /**
     * @return int
     */
    public function getUsrId()
    {
        return $this->usrId;
    }
    
    /**
     * @return int
     */
    public function getActId()
    {
        return $this->actId;
    }
    
    /**
     * @return float
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param float $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return float
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param float $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getMweight()
    {
        return $this->mweight;
    }

    /**
     * @param float $mweight
     */
    public function setMweight($mweight)
    {
        $this->mweight = $mweight;
    }

    /**
     * @return float
     */
    public function getPrecomment()
    {
        return $this->precomment;
    }

    /**
     * @param float $precomment
     */
    public function setPrecomment($precomment)
    {
        $this->precomment = $precomment;
    }

    /**
     * @return float
     */
    public function getIvpBonus()
    {
        return $this->ivp_bonus;
    }

    /**
     * @param float $ivp_bonus
     */
    public function setIvpBonus($ivp_bonus)
    {
        $this->ivp_bonus = $ivp_bonus;
    }

    /**
     * @return float
     */
    public function getIvpPenalty()
    {
        return $this->ivp_penalty;
    }

    /**
     * @param float $ivp_penalty
     */
    public function setIvpPenalty($ivp_penalty)
    {
        $this->ivp_penalty = $ivp_penalty;
    }

    /**
     * @return float
     */
    public function getOfBonus()
    {
        return $this->of_bonus;
    }

    /**
     * @param float $of_bonus
     */
    public function setOfBonus($of_bonus)
    {
        $this->of_bonus = $of_bonus;
    }

    /**
     * @return float
     */
    public function getOfPenalty()
    {
        return $this->of_penalty;
    }

    /**
     * @param float $of_penalty
     */
    public function setOfPenalty($of_penalty)
    {
        $this->of_penalty = $of_penalty;
    }


    /* Setters of table primary keys */

    /**
     * @param int $actId
     */
    public function setActId($id)
    {
        $this->actId = $id;
    }

    /**
     * @param int $usrId
     */
    public function setUsrId($id)
    {
        $this->usrId = $id;
    }

    public function toArray()
    {
        global $app;
        $sql = "SELECT * FROM user INNER JOIN activity_user ON activity_user.user_usr_id=user.usr_id WHERE usr_id=:id AND activity_act_id=:actId";
        $pdoStatement = $app['db']->prepare($sql);
        $pdoStatement->bindValue(':id', $this->usrId);
        $pdoStatement->bindValue(':actId', $this->actId);
        $pdoStatement->execute();
        $result = $pdoStatement->fetchAll();
        return $result[0];
        /*
        $participants = [];
        foreach ($result as $key => $value) {
            $participants[] = $value;
        }
        return $participants;
        */
    }

}
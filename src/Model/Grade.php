<?php
/**
 * Created by IntelliJ IDEA.
 * User: Faventyne
 * Date: 05/12/2017
 * Time: 00:41
 */

namespace Model;

/**
 * @Entity()
 * @Table(name="grade")
 */
class Grade extends DbObject
{
    /**
     * @Id()
     * @GeneratedValue()
     * @Column(name="grd_id", length=10, type="integer")
     * @var int
     */
    protected $id;
    /**
     * @Column(name="activity_user_activity_act_id", length=10, type="integer")
     * @var int
     */
    protected $actid;
    /**
     * @Column(name="activity_user_user_usr_id", length=10, type="integer")
     * @var int
     */
    protected $parid;
    /**
     * @Column(name="criterion_crt_id", length=10, type="integer")
     * @var int
     */
    protected $criid;
    /**
     * @Column(name="stage_stg_id", length= 10, type="integer")
     * @var int
     */
    protected $stgid;
    /**
     * @Column(name="grd_graded_id", length= 10, type="integer")
     * @var int
     */
    protected $gradedid;
    //TODO : remove grader_id, similar to par_id, place graded_id next to foreign keys
    /**
     * @Column(name="grd_value", length= 10, type="float")
     * @var float
     */
    protected $value;
    //TODO : vérifier si dans Doctrine on peut créer un long champ
    /**
     * @Column(name="grd_comment", length= 10, type="string")
     * @var string
     */
    protected $comment;
/**
* @Column(name="grd_inserted", type="datetime")
* @var /DateTime
*/
    protected $inserted;

    /**
     * Grade constructor.
     * @param int $id
     * @param int $actid
     * @param int $parid
     * @param int $criid
     * @param int $stg_id
     * @param int $graded_id
     * @param float $value
     * @param string $comment
     * @param \DateTime $inserted
     */
    public function __construct($id=0, $actid=0, $parid=0, $criid=0, $stgid=2, $gradedid=0, $value=0.0, $comment='',$inserted=null)
    {
        parent::__construct($id,new \DateTime());
        $this->actid = $actid;
        $this->parid = $parid;
        $this->criid = $criid;
        $this->stgid = $stgid;
        $this->gradedid = $gradedid;
        $this->value = $value;
        $this->comment = $comment;
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return int
     */
    public function getActId()
    {
        return $this->actid;
    }

    /**
     * @return int
     */
    public function getParId()
    {
        return $this->parid;
    }

    /**
     * @return int
     */
    public function getCriId()
    {
        return $this->criid;
    }

    /**
     * @return int
     */
    public function getStgId()
    {
        return $this->stgid;
    }

    /**
     * @return int
     */
    public function getGradedId()
    {
        return $this->gradedid;
    }

    /**
     * @param int $graded_id
     */
    public function setGradedId($gradedid)
    {
        $this->gradedid = $gradedid;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param int $act_id
     */
    public function setActId($actid)
    {
        $this->actid = $actid;
    }

    /**
     * @param int $par_id
     */
    public function setParId($parid)
    {
        $this->par_id = $parid;
    }

    /**
     * @param int $cri_id
     */
    public function setCriId($criid)
    {
        $this->criid = $criid;
    }

    /**
     * @param int $stg_id
     */
    public function setStgId($stgid)
    {
        $this->stgid = $stgid;
    }




}
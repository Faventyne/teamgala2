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
 * @Table(name="stage")
 */
class Stage extends DbObject
{
    /**
     *@Id()
     * @GeneratedValue()
     * @Column(name="stg_id", type="integer",nullable=false, length=10)
     * @var int
     */
    protected $id;
    /**
     * @Column(name="activity_act_id", length=10, type="integer")
     * @var int
     */
    protected $act_id;
    /**
     * @Column(name="stg_name", type="string")
     * @var string
     */
    protected $name;
    /**
     * @Column(name="stg_weight", length=10, type="float")
     * @var float
     */
    protected $weight;
    /**
     * @Column(name="stg_deadline", type="datetime")
     * @var \DateTime
     */
    protected $deadline;

    /**
     * @Column(name="stg_inserted", type="datetime")
     * @var \DateTime
     */
    protected $inserted;

    /**
     * Stage constructor.
     * @param int $id
     * @param int $act_id
     * @param string $name
     * @param float $weight
     * @param \DateTime $deadline
     * @param \DateTime $inserted
     */
    public function __construct($id=0, $act_id=0, $name='', $weight=0.0, $deadline=null, $inserted=null)
    {
        parent::__construct($id,new \DateTime());
        $this->act_id = $act_id;
        $this->name = $name;
        $this->weight = $weight;
        $this->deadline = $deadline;
    }
    
    /**
     * return int
     */
    public function getId()
    {
        return $this->id ;
    }
    
    /**
     * @return int
     */
    public function getActId()
    {
        return $this->act_id;
    }

    /**
     * @param int $act_id
     */
    public function setActId($act_id)
    {
        $this->act_id = $act_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return \DateTime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param \DateTime $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }


}
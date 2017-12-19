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
 * @Table(name="criterion")
 */
class Criterion extends DbObject
{
    /**
     * @Id()
     * @GeneratedValue()
     * @column(name="crt_id", type="integer", nullable=false) 
     */
    protected $id ;
    /**
     * @Column(name="activity_act_id", length=10, type="integer")
     * @var int
     */
    protected $actId;
    /**
     * @Column(name="cri_name", type="string")
     * @var string
     */
    protected $name;
    /**
     * @Column(name="cri_weight", length= 10, type="float")
     * @var float
     */
    protected $weight;
    /**
     * @Column(name="cri_lowerbound", length= 10, type="float")
     * @var float
     */
    protected $lowerbound;
    /**
     * @Column(name="cri_upperbound", length= 10, type="float")
     * @Assert\GreaterThan($lowerbound)
     * @var float
     */
    protected $upperbound;
    /**
     * @Column(name="cri_step", length= 10, type="float")
     * @var float
     */
    protected $step;
    /**
     * @Column(name="cri_gradetype", type="string")
     * @var string
     */
    protected $gradetype;
    /**
     * @Column(name="cri_inserted", type="datetime")
     * @var \DateTime
     */
    protected $inserted;

    /**
     * Criterion constructor.
     * @param int $id
     * @param int $act_id
     * @param string $name
     * @param string $gradetype
     * @param float $weight
     * @param float $lowerbound
     * @param float $upperbound
     * @param float $step
     * @param /DateTime $inserted
     */
    public function __construct($id=0, $actId=0, $name='', $weight=0.0, $lowerbound=0.0, $upperbound=5.0, $step=0.1, $gradetype='absolute',$inserted=null)
    {
        parent::__construct($id,new \DateTime());
        $this->actId = $actId;
        $this->name = $name;
        $this->gradetype = $gradetype;
        $this->weight = $weight;
        $this->lowerbound = $lowerbound;
        $this->upperbound = $upperbound;
        $this->step = $step;
        
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
        return $this->actId;
    }


    /*
     * As for User class, the below setter is normally irrelevant but we forces the setting of a foreign key
     * as activity creation has been simplified to what it should have been initially
     */

    /**
     * @param int $act_id
     */
    public function setActId($actId)
    {
        $this->actId = $actId;
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

    function getLowerbound() {
        return $this->lowerbound;
    }

    function getUpperbound() {
        return $this->upperbound;
    }

    function getStep() {
        return $this->step;
    }

    function setLowerbound($lowerbound) {
        $this->lowerbound = $lowerbound;
    }

    function setUpperbound($upperbound) {
        $this->upperbound = $upperbound;
    }

    function setStep($step) {
        $this->step = $step;
    }

       

    /**
     * @return string
     */
    public function getGradeType()
    {
        return $this->gradetype;
    }

    /**
     * @param string $gradetype
     */
    public function setGradeType($gradetype)
    {
        $this->gradetype = $gradetype;
    }


    //Creation of external getters and setters to call the method when setting activity parameters in a Criterion form
    public function setDeadline($deadline)
{
    $activity = new Activity();
    $activity->setDeadline($deadline);
}

    public function getDeadline()
    {
        $activity = new Activity();
        return $activity->getDeadline();
    }

    public function setVisibility($visibility)
    {
        $activity = new Activity();
        $activity->setVisibility($visibility);
    }

    public function getVisibility()
    {
        $activity = new Activity();
        return $activity->getVisibility();
    }

    public function setObjectives($objectives)
    {
        $activity = new Activity();
        $activity->setObjectives($objectives);
    }

    public function getObjectives()
    {
        $activity = new Activity();
        return $activity->getObjectives();
    }
    
    public function toArray()
    {
        return [
            'id' => $this->id,
            'actId' => $this->actId,
            'name' => $this->name,
            'lowerbound' => $this->lowerbound,
            'upperbound' => $this->upperbound,
            'step' => $this->step
        ];
    }

}


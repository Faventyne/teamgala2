<?php
/**
 * Created by IntelliJ IDEA.
 * User: Faventyne
 * Date: 05/12/2017
 * Time: 00:39
 */

namespace Model;

/**
 * @Entity @Table(name="position")
 */
class Position extends DbObject
{
    /**
     *@Id()
     * @GeneratedValue()
     * @Column(name="pos_id", type="integer", length=10, nullable=false)
     * @var int
     */
    protected $id;
    /**
     * @Column(name="organization_org_id", length=10, type="integer")
     * @var int
     */
    protected $org_id;
    /**
     * @Column(name="pos_name", length= 45, type="string")
     * @var string
     */
    protected $name;
    /**
     * @Column(name="pos_weight_ini", length= 10, type="float")
     * @var float
     */
    protected $weight_ini;
    /**
     * @Column(name="pos_weight_1y", length= 10, type="float")
     * @var float
     */
    protected $weight_1y;
    /**
     * @Column(name="pos_weight_2y", length= 10, type="float")
     * @var float
     */
    protected $weight_2y;
    /**
     * @Column(name="pos_weight_3y", length= 10, type="float")
     * @var float
     */
    protected $weight_3y;
    /**
     * @Column(name="pos_weight_4y", length= 10, type="float")
     * @var float
     */
    protected $weight_4y;
    /**
     * @Column(name="pos_weight_5y", length= 10, type="float")
     * @var float
     */
    protected $weight_5y;
    /**
     * @Column(name="pos_inserted", type="datetime")
     * @var \DateTime
     */
    protected $inserted;

    /**
     * Role constructor.
     * @param int $id
     * @param int $org_id
     * @param string $name
     * @param float $weight_ini
     * @param float $weight_1y
     * @param float $weight_2y
     * @param float $weight_3y
     * @param float $weight_4y
     * @param float $weight_5y
     * @param \DateTime inserted
     */
    public function __construct($id=0, $org_id=1, $name='', $weight_ini=0.0, $weight_1y=0.0, $weight_2y=0.0, $weight_3y=0.0, $weight_4y=0.0, $weight_5y=0.0,$inserted=null)
    {
        parent::__construct($id,new \DateTime());
        $this->org_id = $org_id;
        $this->name = $name;
        $this->weight_ini = $weight_ini;
        $this->weight_1y = $weight_1y;
        $this->weight_2y = $weight_2y;
        $this->weight_3y = $weight_3y;
        $this->weight_4y = $weight_4y;
        $this->weight_5y = $weight_5y;
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
    public function getOrgId()
    {
        return $this->org_id;
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


}

<?php
/**
 * Created by IntelliJ IDEA.
 * User: Faventyne
 * Date: 05/12/2017
 * Time: 00:38
 */

namespace Model;

/**
 * @Entity()
 * @Table(name="organization")
 */
class Organization extends DbObject
{
    /**
     * @Id()
     * @GeneratedValue()
     * @Column(name="org_id", type="integer", nullable=false)
     * @var int
     */
    protected $id;
    /**
     * @Column(name="org_legalname", type="string")
     * @var string
     */
    // TODO : rename propertie org_lname to org_legalname, create org_commname
    protected $legalname;
    /**
     * @Column(name="org_commname", type="string")
     * @var string
     */
    protected $commname;
    // TODO : rename property, create enum for weight_type
    /**
     * @Column(name="org_weight_type", type="string")
     * @var string
     */
    protected $weight_type;
    /**
     * @Column(name="org_inserted", type="datetime")
     * @var \DateTime
     */
    protected $inserted;

    /**
     * Organization constructor.
     * @param int $id
     * @param string $legalname
     * @param string $commname
     * @param string $weight_type
     * @param \DateTime $inserted
     */
    public function __construct($id=0, $legalname='', $commname='', $weight_type='', $inserted=null)
    {
        parent::__construct($id,new \DateTime());
        $this->legalname = $legalname;
        $this->commname = $commname;
        $this->weight_type = $weight_type;
    }
    
    /* GETTERS */
    function getId() {
        return $this->id;
    }

    function getLegalname() {
        return $this->legalname;
    }

    function getCommname() {
        return $this->commname;
    }

    function getWeight_type() {
        return $this->weight_type;
    }

    /* SETTERS */
    function setId($id) {
        $this->id = $id;
    }

    function setLegalname($legalname) {
        $this->legalname = $legalname;
    }

    function setCommname($commname) {
        $this->commname = $commname;
    }

    function setWeight_type($weight_type) {
        $this->weight_type = $weight_type;
    }


}
<?php

namespace Model ;

/**
 * @Entity()
 * @Table(name="role")
 */
class Role extends DbObject
{
    /**
     * @Id()
     * @GeneratedValue()
     * @Column(name="rol_id", type="integer", nullable=false, length=10)
     * @var int
     */
    protected $id;
    
    /**
     *@Column(name="rol_name", type="string", nullable=false, length=10)
     * @var string
     */
    protected $name;

    /**
     *@Column(name="rol_inserted", type="datetime")
     * @var \DateTime
     */
    protected $inserted;
    
    public function __construct($id = 0, $inserted = '', $name='', $inserted=null) {
        parent::__construct($id, new \DateTime());
        $this->name = $name;
    }
    
    /* GETTERS */
    
    /**
     * 
     * @return int
     */
    public function getId() 
    {
        return $this->id;
    }
    
    /**
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /* SETTERS */
    
    /**
     * 
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}

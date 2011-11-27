<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Task', 'doctrine');

/**
 * BaseTask
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property text $description
 * @property string $slug
 * @property string $task_color
 * @property integer $estimated_mins_to_complete
 * @property timestamp $actual_mins_to_complete
 * @property integer $phase_id
 * @property integer $department_id
 * @property Phase $Phase
 * @property Department $Department
 * 
 * @method string     getName()                       Returns the current record's "name" value
 * @method text       getDescription()                Returns the current record's "description" value
 * @method string     getSlug()                       Returns the current record's "slug" value
 * @method string     getTaskColor()                  Returns the current record's "task_color" value
 * @method integer    getEstimatedMinsToComplete()    Returns the current record's "estimated_mins_to_complete" value
 * @method timestamp  getActualMinsToComplete()       Returns the current record's "actual_mins_to_complete" value
 * @method integer    getPhaseId()                    Returns the current record's "phase_id" value
 * @method integer    getDepartmentId()               Returns the current record's "department_id" value
 * @method Phase      getPhase()                      Returns the current record's "Phase" value
 * @method Department getDepartment()                 Returns the current record's "Department" value
 * @method Task       setName()                       Sets the current record's "name" value
 * @method Task       setDescription()                Sets the current record's "description" value
 * @method Task       setSlug()                       Sets the current record's "slug" value
 * @method Task       setTaskColor()                  Sets the current record's "task_color" value
 * @method Task       setEstimatedMinsToComplete()    Sets the current record's "estimated_mins_to_complete" value
 * @method Task       setActualMinsToComplete()       Sets the current record's "actual_mins_to_complete" value
 * @method Task       setPhaseId()                    Sets the current record's "phase_id" value
 * @method Task       setDepartmentId()               Sets the current record's "department_id" value
 * @method Task       setPhase()                      Sets the current record's "Phase" value
 * @method Task       setDepartment()                 Sets the current record's "Department" value
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTask extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('task');
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('description', 'text', null, array(
             'type' => 'text',
             ));
        $this->hasColumn('slug', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('task_color', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('estimated_mins_to_complete', 'integer', 8, array(
             'type' => 'integer',
             'length' => 8,
             ));
        $this->hasColumn('actual_mins_to_complete', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('phase_id', 'integer', 8, array(
             'type' => 'integer',
             'length' => 8,
             ));
        $this->hasColumn('department_id', 'integer', 8, array(
             'type' => 'integer',
             'length' => 8,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Phase', array(
             'local' => 'phase_id',
             'foreign' => 'id'));

        $this->hasOne('Department', array(
             'local' => 'department_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'slug',
             ),
             ));
        $this->actAs($timestampable0);
        $this->actAs($sluggable0);
    }
}
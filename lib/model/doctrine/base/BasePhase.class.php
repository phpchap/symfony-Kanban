<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Phase', 'doctrine');

/**
 * BasePhase
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property text $description
 * @property string $slug
 * @property Doctrine_Collection $Tasks
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getName()        Returns the current record's "name" value
 * @method text                getDescription() Returns the current record's "description" value
 * @method string              getSlug()        Returns the current record's "slug" value
 * @method Doctrine_Collection getTasks()       Returns the current record's "Tasks" collection
 * @method Phase               setId()          Sets the current record's "id" value
 * @method Phase               setName()        Sets the current record's "name" value
 * @method Phase               setDescription() Sets the current record's "description" value
 * @method Phase               setSlug()        Sets the current record's "slug" value
 * @method Phase               setTasks()       Sets the current record's "Tasks" collection
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePhase extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('phase');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
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
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Task as Tasks', array(
             'local' => 'id',
             'foreign' => 'phase_id'));

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
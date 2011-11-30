<?php

/**
 * Task filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTaskFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                       => new sfWidgetFormFilterInput(),
      'description'                => new sfWidgetFormFilterInput(),
      'slug'                       => new sfWidgetFormFilterInput(),
      'task_color'                 => new sfWidgetFormFilterInput(),
      'estimated_mins_to_complete' => new sfWidgetFormFilterInput(),
      'actual_mins_to_complete'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'phase_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Phase'), 'add_empty' => true)),
      'department_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => true)),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'departments_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Department')),
    ));

    $this->setValidators(array(
      'name'                       => new sfValidatorPass(array('required' => false)),
      'description'                => new sfValidatorPass(array('required' => false)),
      'slug'                       => new sfValidatorPass(array('required' => false)),
      'task_color'                 => new sfValidatorPass(array('required' => false)),
      'estimated_mins_to_complete' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'actual_mins_to_complete'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'phase_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Phase'), 'column' => 'id')),
      'department_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Department'), 'column' => 'id')),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'departments_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Department', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('task_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addDepartmentsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.TaskDepartment TaskDepartment')
      ->andWhereIn('TaskDepartment.department_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Task';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'name'                       => 'Text',
      'description'                => 'Text',
      'slug'                       => 'Text',
      'task_color'                 => 'Text',
      'estimated_mins_to_complete' => 'Number',
      'actual_mins_to_complete'    => 'Date',
      'phase_id'                   => 'ForeignKey',
      'department_id'              => 'ForeignKey',
      'created_at'                 => 'Date',
      'updated_at'                 => 'Date',
      'departments_list'           => 'ManyKey',
    );
  }
}

<?php

/**
 * Task form base class.
 *
 * @method Task getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTaskForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'name'                       => new sfWidgetFormInputText(),
      'description'                => new sfWidgetFormInputText(),
      'slug'                       => new sfWidgetFormInputText(),
      'task_color'                 => new sfWidgetFormInputText(),
      'estimated_mins_to_complete' => new sfWidgetFormInputText(),
      'actual_mins_to_complete'    => new sfWidgetFormDateTime(),
      'phase_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Phase'), 'add_empty' => true)),
      'department_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => true)),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
      'departments_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Department')),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                       => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'description'                => new sfValidatorPass(array('required' => false)),
      'slug'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'task_color'                 => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'estimated_mins_to_complete' => new sfValidatorInteger(array('required' => false)),
      'actual_mins_to_complete'    => new sfValidatorDateTime(array('required' => false)),
      'phase_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Phase'), 'required' => false)),
      'department_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
      'departments_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Department', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Task', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('task[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Task';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['departments_list']))
    {
      $this->setDefault('departments_list', $this->object->Departments->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveDepartmentsList($con);

    parent::doSave($con);
  }

  public function saveDepartmentsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['departments_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Departments->getPrimaryKeys();
    $values = $this->getValue('departments_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Departments', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Departments', array_values($link));
    }
  }

}

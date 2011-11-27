<?php

/**
 * board actions.
 *
 * @package    sf_sandbox
 * @subpackage board
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class boardActions extends sfActions
{
 /**
  * Display the main board page 
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    // get phases
    $q = Doctrine::getTable('Phase')->createQuery('p');
    $this->phases = $q->execute();
    $this->phases_count = $this->phases->count();

    // get tasks
    $q = Doctrine::getTable('Task')->createQuery('t');
    $this->tasks = $q->execute();
    $this->tasks_count = $this->tasks->count();
  }

  /**
  * Update a task in a project
  *
  * @param sfRequest $request A request object
  */
  public function executeUpdateProjectTask(sfWebRequest $request)
  {  
    if ($request->hasParameter('phase') && $request->hasParameter('task')) {
  
      sfConfig::set('sf_web_debug', false);

      // get the clean JSON parameters
      $task = str_replace("_", "", $request->getParameter('task'));
      $phase = str_replace("_", "", $request->getParameter('phase'));
   
      error_log('phase param: ' .$phase );
      error_log('task param: ' .$task );
  
      // get the task
      $q = Doctrine::getTable('Task')->createQuery('t')->addWhere('t.slug=?', $task);
      $this->task = $q->execute()->getFirst();

      // get the phase
      $q = Doctrine::getTable('Phase')->createQuery('p')->addWhere('p.slug=?', $phase);
      $this->phase = $q->execute()->getFirst();

      // now update the task with the correct phase
      $this->task->setPhaseId($this->phase->getId());
      $this->task->save();

      error_log('task object: ' .$this->task->toArray());

      $response['status'] = "Successfully updated ".$this->task->getName();

      $this->setLayout(false);
      $this->getResponse()->setContentType('application/json');
      return (string)$this->renderText(json_encode($response));      
    }
  }
}

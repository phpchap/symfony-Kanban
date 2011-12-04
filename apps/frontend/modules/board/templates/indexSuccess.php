<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta charset="utf-8">
    <title>Kanban Board</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/2.8.0r4/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">    
    <!-- Reference the theme's stylesheet on the Google CDN -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css" type="text/css" rel="Stylesheet" />
    <!-- Reference jQuery and jQuery UI from the CDN. Remember that the order of these two elements is important -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
    <script>
    $(function() {


		$( ".column" ).sortable({
			connectWith: ".column"
		});

		$( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
			.find( ".portlet-header" )
				.addClass( "ui-widget-header ui-corner-all" )
				.prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
				.end()
			.find( ".portlet-content" );

		$( ".portlet-header .ui-icon" ).click(function() {
			$( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
			$( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
		});

		$( ".column" ).disableSelection();

		// started drag
		function callBackStart( obj ) {
			console.log('STARTED DRAG: ' + obj.id );
		}

		// end drag
		function callBackStop( obj ) {
			console.log('STOP DRAG: ' + obj.id );
		}

		// update task
		function updateTask(task, phase) {

			console.log('task: ' + task.attr('id'));
			console.log('phase: ' + phase.id);

			var task_slug = task.attr('id');
			var phase_slug = phase.id;
			
			$.ajax({
				url: '<?php echo url_for("@updateProjectTask");?>',
				data: {task: task_slug, phase: phase_slug},
				dataType: 'json',
				success: function(response) {
					$("#info_box").html('');
					$("#info_box").html(response.status);
			  }
			});
		}

		// define all the tasks as droppables
		<?php foreach($tasks as $task) { ?>
			$( "#_<?php echo $task->getSlug();?>" ).draggable({
			start: function() {				
				callBackStart( this );
			}, 
			stop: function() {				
				callBackStop( this );
			}
		});
		<?php } ?>

		// define the phases as droppables
		<?php foreach($phases as $phase) { ?>
            $( "#_<?php echo $phase->getSlug();?>" ).droppable({
                    drop: function( event, ui ) {
						// console.log(ui.draggable.attr('id'));
						updateTask(ui.draggable, this);
                    }
            });
		<?php } ?>
	});
    
    </script>
    <style>
	body { font-family: "Trebuchet MS","Helvetica","Arial","Verdana","sans-serif"; }
	h1 { font-weight: normal; margin: 0; font-size: 24px; }
	h2 { font-weight: normal; margin: 0; font-size: 18px; }
	.drag_box { width: 180px; height: 100px; padding: 0.5em; float: left; margin: 10px 10px 10px 0; float;left; }    
	.column { width: 200px; height: 800px; padding: 0.5em; float: left; margin: 10px; border:1px dashed #000}	
	.phase_title { border:1px solid blue;min-height:80px;padding: 0.5em; }
	#tasks_container { border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border: 5px solid #000000; }
	#info_box { position: relative; top: 1px; left: 1px; background: #ffff00; padding:5px; }
	.column { width: 170px; float: left; padding-bottom: 100px; }
	.portlet { margin: 0 1em 1em 0; }
	.portlet-header { margin: 0.3em; padding-bottom: 4px; padding-left: 0.2em; }
	.portlet-header .ui-icon { float: right; }
	.portlet-content { padding: 0.4em; }
	.ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
	.ui-sortable-placeholder * { visibility: hidden; }
    </style>
</head>
<body class="yui-skin-sam">



<div id="info_box"></div>
	<div id="doc3" class="yui-t7">
		<div id="hd" role="banner">
			<h1>Whitewater Kanban Board - <a href="javascript:return false;" id="opener">New Task</a></h1>
			<ul id="nav">
				<li>Home</li>
				<li>Departments</li>
				<li>People</li>
				<li>Tasks</li>
				<li>Burndown Chart</li>
			</ul>
		</div>
		<div id="bd" role="main">
		<div class="yui-g">
				<div id="tasks_container">                                
					<?php foreach($phases as $phase) { ?>

						<!-- PHASE -->
						<div class="column">

							<div class="phase_title">
								<h2><?php echo $phase->getName();?></h2>
								<p><?php echo $phase->getDescription();?></p>
							</div>

							<!-- TASK -->
							<?php foreach($phase->getTasks() as $task) { ?>
								<div class="portlet">
									<div class="portlet-header"><?php echo $task->getName();?></div>
									<div class="portlet-content">
										<p>Who: <?php echo $task->getDepartment()->getShortName(); ?></p>
										<p>How Long: <?php echo $task->getEstimatedMinsToComplete()." mins"; ?></p>
										<p><a href="#">More info</a></p>
									</div>
								</div>
							<?php } ?>
							

						</div>
						



<?php /* 
						<div id="_<?php echo $phase->getSlug();?>" class="drop_box">
							<div class="phase_title">
								<h2><?php echo $phase->getName();?></h2>
								<p><?php echo $phase->getDescription();?></p>
							</div>
							<?php foreach($phase->getTasks() as $task) { ?>
								<div id="_<?php echo $task->getSlug();?>" class="drag_box" style="background:#<?php echo $task->getDepartment()->getTaskColor();?>">
									<p>What: <?php echo $task->getName();?></p>
									<p>Who: <?php echo $task->getDepartment()->getShortName(); ?></p>
									<p>How Long: <?php echo $task->getEstimatedMinsToComplete()." mins"; ?></p>
									<p><a href="#">More info</a></p>
									<div style="clear:both"></div>
								</div>
							<?php } ?>
						</div>
	  
							<ul id="sortable<?php echo $phase->getId();?>" class="connectedSortable">
								<?php foreach($phase->getTasks() as $task) { ?>
									<li class="ui-state-default">
										<p>What: <?php echo $task->getName();?></p>
										<p>Who: <?php echo $task->getDepartment()->getShortName(); ?></p>
										<p>How Long: <?php echo $task->getEstimatedMinsToComplete()." mins"; ?></p>
										<p><a href="#">More info</a></p>
										<div style="clear:both"></div>
									</li>
								<?php } ?>
							</ul>
						</div>
	  */ ?>
					<?php } ?>									
					<div style="clear:both"></div>
				</div><!-- End tasks_container -->                
			</div>
		</div>
		<div id="ft" role="contentinfo"><p>Footer</p></div>
	</div>
</body>
</html>
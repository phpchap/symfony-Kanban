<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta charset="utf-8">
    <title>YUI Base Page</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/2.8.0r4/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">    
    <!-- Reference the theme's stylesheet on the Google CDN -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css" type="text/css" rel="Stylesheet" />
    <!-- Reference jQuery and jQuery UI from the CDN. Remember that the order of these two elements is important -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
    <script>
    $(function() {
/*
		var $dialog = $('<div></div>')
		.html('<form id="add_task"><label for="task_name">task name</label>><input type="text" name="task_name"/><input type="submit" value="add task"></form>')
		.dialog({
			autoOpen: false,
			title: 'Add a new Task'
		});

		$('#opener').click(function() {
			$dialog.dialog('open', { buttons: { "Ok": function() { $(this).dialog("close"); } } });
			// prevent the default action, e.g., following a link
			return false;
		});
*/

		$( "#create-user" )
			
			.click(function() {
				$( "#dialog-form" ).dialog( "open" );
			});

		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 300,
			width: 350,
			modal: true,
			buttons: {
				"Create an account": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkLength( name, "username", 3, 16 );
					bValid = bValid && checkLength( email, "email", 6, 80 );
					bValid = bValid && checkLength( password, "password", 5, 16 );

					bValid = bValid && checkRegexp( name, /^[a-z]([0-9a-z_])+$/i, "Username may consist of a-z, 0-9, underscores, begin with a letter." );
					// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
					bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com" );
					bValid = bValid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );

					if ( bValid ) {
						$( "#users tbody" ).append( "<tr>" +
							"<td>" + name.val() + "</td>" + 
							"<td>" + email.val() + "</td>" + 
							"<td>" + password.val() + "</td>" +
						"</tr>" ); 
						$( this ).dialog( "close" );
					}
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});


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
	.drop_box { width: 200px; height: 800px; padding: 0.5em; float: left; margin: 10px; border:1px dashed #000}	
	.phase_title { border:1px solid blue;min-height:80px;padding: 0.5em; }
	#tasks_container { border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border: 5px solid #000000; }
	#info_box { position: relative; top: 1px; left: 1px; background: #ffff00; padding:5px; }
    </style>
</head>
<body class="yui-skin-sam">


<div id="dialog-form" title="Create new user">
	<p class="validateTips">All form fields are required.</p>

	<form>
	<fieldset>
		<label for="name">Name</label>
		<input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
		<label for="email">Email</label>
		<input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all" />
		<label for="password">Password</label>
		<input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all" />
	</fieldset>
	</form>
</div>


<button id="create-user">Create new user</button>


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
					<?php } ?>									
					<div style="clear:both"></div>
				</div><!-- End tasks_container -->                
			</div>
		</div>
		<div id="ft" role="contentinfo"><p>Footer</p></div>
	</div>
</body>
</html>
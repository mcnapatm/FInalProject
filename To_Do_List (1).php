<!-- User Declartion and Task Data -->
<?php

    // Start Session
	session_start();

	//Include database connectio
	include('connect.php');

	try{
		//If user is logged in set username
		if(isset($_SESSION['sess_username']))
		{
			$username = $_SESSION['sess_username'];
			$getUserID = $db->prepare("SELECT UserID FROM user WHERE UserName='$username'");
			$getUserID->execute();
			$UserID = $getUserID->fetch(PDO::FETCH_ASSOC);
			$UserID = $UserID['UserID'];
		}

		//If user is logged in set user role
		if(isset($_SESSION['sess_userrole']))
		{
			$userrole = $_SESSION['sess_userrole'];
		}

		// Retrieve Priorities from the database
		$getPriorities = $db->prepare("SELECT PriorityName,PriorityWeight,PriorityDescription,PriorityID FROM priority WHERE UserID='$UserID'");
		$getPriorities->execute();
		
		//Decalre array and fetch data from database
		$priority_array= array();
		while($fetchPriorities = $getPriorities->fetch(PDO::FETCH_ASSOC))
		{
			$priority_array[] = $fetchPriorities;
		}

		//Sort data by Priority Weight
		function sort_by_order ($a, $b)
		{
			return $a['PriorityWeight'] - $b['PriorityWeight'];
		}
		
		uasort($priority_array, 'sort_by_order');
			
		//Set Priority Variables
		$priority_array  = array_values($priority_array);

		// Get Task IDs from the user_task_list table
		$getTaskID = $db->prepare("SELECT TaskID FROM user_task_list WHERE (UserID='$UserID' AND ListType='In Progress') OR (UserID='$UserID' AND ListType='Reoccur')");
		$getTaskID->execute();


		// Place Task IDs into Array
		if(isset($getTaskID))
		{
			while($fetchTaskID = $getTaskID->fetch(PDO::FETCH_ASSOC))
				{
					$TaskIDArray[] = $fetchTaskID['TaskID'];
				}

			// Fetch Task Data
			foreach($TaskIDArray as $TaskID)
			{
				$Task = $db->prepare("SELECT * FROM task WHERE TaskID='$TaskID'");
				$Task->execute();
				$TaskArray[] = $Task->fetch(PDO::FETCH_ASSOC);
			}

			// Sort Tasks into Proper Array
			if(isset($TaskArray))
			{
			   foreach($TaskArray as $Task)
			    {
    				if($Task['Reoccurance'] == '1')
    				{
    					$RTaskArray[] = $Task;
    				}
    				else
    				{
    					if($Task['TaskGrade'] == 'A')
    						{
    							$ATaskArray[] = $Task;
    						}
    					elseif($Task['TaskGrade'] == 'B')
    						{
    							$BTaskArray[] = $Task;
    						}
    					elseif($Task['TaskGrade'] == 'C')
    						{
    							$CTaskArray[] = $Task;
    						}
    					elseif($Task['TaskGrade'] == 'D')
    						{
    							$DTaskArray[] = $Task;
    						}
    				}

			    } 
			}
			

		
		}
		else
		{
			
		}
		
		
	}
	catch(PDOException $Exception){
		
	}
	
?>


<!doctype html>
<html>
	<head>
		<!--Link to Stylesheet -->
		<link rel="stylesheet" type="text/css" href="Style/taskmaster.css">
		
		<!--Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		
		<!-- Jquery Script -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		
		<!-- Bootstrap Script -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<!-- jQuery Modal -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
		<meta charset="utf-8">
		
		<!--Javascript Links -->
		<script src="Scripts/ShowReoccur.js"></script>
		<script src="Scripts/HideReoccur.js"></script>
		<script src="Scripts/addFourth.js"></script>
		<script src="Scripts/addFifth.js"></script>		
						
		<title>To Do List</title>
	</head>

	<body class="body">
	
		<!-- Header Panel with User Information and Links -->
		<header class="Header">
			<div class="Title">
				<h1>Task Master</h1>
			</div>
			<div class="HeaderLog">
				<div class="AboutLink">
						<p><a href="about.php">About</a></p>
				</div>
				<p><?php echo $_SESSION['sess_username']; ?><br/><a href="logout.php">Log Out</a></p>
			</div>
		</header>
	
	<div class='mainFlex'>
	<!-- To Do list -->
		<div class="Task_Container">
			<h2 class="ToDoTitle">To-Do List</h2>
				<div class="panel-group">
					<div class="panel panel-default">
					
						<!--A Task Title -->
						<div class="panel-heading">
							<h4 class="panel-title">
							<a data-toggle="collapse" href="#collapse_A">A-Tasks</a>
							</h4>
						</div>
						
						<!--A Task List Items -->
						<div id="collapse_A" class="panel-collapse collapse">
							<ul class="list-group">
							<?php
								if(isset($ATaskArray))
								{
								    foreach ($ATaskArray as $key => $row) 
								    {
									    $SubGrade[$key]  = $row['TaskSubGrade'];

								    }
								    array_multisort($SubGrade, SORT_ASC, $ATaskArray);
									foreach($ATaskArray as $Task)
									{
									    foreach($priority_array as $priority)
										{
											if($priority['PriorityID'] == $Task['PriorityID'])
											{
												$TaskPriority =$priority['PriorityName'];
											}
										}
										
										$TaskID= $Task['TaskID'];
										$TaskSubGrade= $Task['TaskSubGrade'];
										$TaskName= $Task['TaskName'];
										$TaskDate= $Task['DateDue'];
										$TaskDate = date( 'M-d', strtotime( $TaskDate) );
										?>
			
										<li class='list-group-item'>
											<a href='FindTask.php?id=<?php echo $TaskID; ?>' >
												<?php echo $TaskName; ?>
											</a>
											   <?php echo"A-",$TaskSubGrade; ?></br> <?php echo $TaskPriority; ?>
											</br>Due By:<?php echo $TaskDate; ?>
										</li>
										<?php
									}
								}
								else
								{
									echo "<li>No tasks available</br>"?>
									<a href="#addTask" rel="modal:open">Click Here to Add a Task.</a><?php
								}
							?>
							</ul>
						</div>
						
						<!--B Task Title -->
						<div class="panel-heading">
							<h4 class="panel-title">
							<a data-toggle="collapse" href="#collapse_B">B-Tasks</a>
							</h4>
						</div>
						
						<!--B Task List Items -->
						<div id="collapse_B" class="panel-collapse collapse">
							<ul class="list-group">
							<?php
								if(isset($BTaskArray))
								{
									foreach ($BTaskArray as $key => $row) 
									{
										$SubGrade[$key]  = $row['TaskSubGrade'];

									}
								array_multisort($SubGrade, SORT_ASC, $BTaskArray);
									foreach($BTaskArray as $Task)
									{
									    foreach($priority_array as $priority)
										{
											if($priority['PriorityID'] == $Task['PriorityID'])
											{
												$TaskPriority =$priority['PriorityName'];
											}
										}
										$TaskID= $Task['TaskID'];
										$TaskSubGrade= $Task['TaskSubGrade'];
										$TaskName= $Task['TaskName'];
										$TaskDate= $Task['DateDue'];
										$TaskDate = date( 'M-d', strtotime( $TaskDate) );
										?>
			
										<li class='list-group-item'>
											<a href='FindTask.php?id=<?php echo $TaskID; ?>' >
												<?php echo $TaskName; ?>
											</a>
											<?php echo"B-",$TaskSubGrade; ?></br> <?php echo $TaskPriority; ?>
											</br>Due By:<?php echo $TaskDate; ?>
										</li>
										<?php
									}
								}
								else
								{
									echo "<li>No tasks available</br>"?>
									<a href="#addTask" rel="modal:open">Click Here to Add a Task.</a><?php
								}
							?>
							</ul>
						</div>
						
						<!--C Task Title -->
						<div class="panel-heading">
							<h4 class="panel-title">
							<a data-toggle="collapse" href="#collapse_C">C-Tasks</a>
							</h4>
						</div>
						
						<!--C Task List Items -->
						<div id="collapse_C" class="panel-collapse collapse">
							<ul class="list-group">
							<?php
								if(isset($CTaskArray))
								{
									foreach ($CTaskArray as $key => $row) 
									{
										$SubGrade[$key]  = $row['TaskSubGrade'];

									}
								array_multisort($SubGrade, SORT_ASC, $CTaskArray);
									foreach($CTaskArray as $Task)
									{
									    foreach($priority_array as $priority)
										{
											if($priority['PriorityID'] == $Task['PriorityID'])
											{
												$TaskPriority =$priority['PriorityName'];
											}
										}
										$TaskID= $Task['TaskID'];
										$TaskSubGrade= $Task['TaskSubGrade'];
										$TaskName= $Task['TaskName'];
										$TaskDate= $Task['DateDue'];
										$TaskDate = date( 'M-d', strtotime( $TaskDate) );
										?>
			
										<li class='list-group-item'>
											<a href='FindTask.php?id=<?php echo $TaskID; ?>' >
												<?php echo $TaskName; ?>
											</a>
											<?php echo"C-",$TaskSubGrade; ?></br> <?php echo $TaskPriority; ?>
											</br>Due By:<?php echo $TaskDate; ?>
										</li>
										<?php
									}
								}
								else
								{
									echo "<li>No tasks available</br>"?>
									<a href="#addTask" rel="modal:open">Click Here to Add a Task.</a><?php
								}
							?>
							</ul>
						</div>
						
						<!--D Task Title -->
						<div class="panel-heading">
							<h4 class="panel-title">
							<a data-toggle="collapse" href="#collapse_D">D-Tasks</a>
							</h4>
						</div>
						
						<!--D Task List Items -->
						<div id="collapse_D" class="panel-collapse collapse">
							<ul class="list-group">
							<?php
								if(isset($DTaskArray))
								{
									foreach ($DTaskArray as $key => $row) 
									{
										$SubGrade[$key]  = $row['TaskSubGrade'];

									}
								array_multisort($SubGrade, SORT_ASC, $DTaskArray);
									foreach($DTaskArray as $Task)
									{
									    foreach($priority_array as $priority)
										{
											if($priority['PriorityID'] == $Task['PriorityID'])
											{
												$TaskPriority =$priority['PriorityName'];
											}
										}
										$TaskID= $Task['TaskID'];
										$TaskSubGrade= $Task['TaskSubGrade'];
										$TaskName= $Task['TaskName'];
										$TaskDate= $Task['DateDue'];
										$TaskDate = date( 'M-d', strtotime( $TaskDate) );
										?>
			
										<li class='list-group-item'>
											<a href='FindTask.php?id=<?php echo $TaskID; ?>' >
												<?php echo $TaskName; ?>
											</a>
											<?php echo"D-",$TaskSubGrade; ?></br> <?php echo $TaskPriority; ?>
											</br>Due By:<?php echo $TaskDate; ?>
										</li>
										<?php
									}
								}
								else
								{
									echo "<li>No tasks available</br>"?>
									<a href="#addTask" rel="modal:open">Click Here to Add a Task.</a><?php
								}
							?>
							</ul>
						</div>
						
						
						
					</div>
					
				</div>
				
				<!-- Add Task modal -->
				<div id="addTask" class="modal">
					<form action="addTask.php" method="post">
						<p>Task Name: <input type="text" name="addTaskName"></p>
						<p>Task Priority:
							<select name="addTaskPriority" type>
								<option value="none">None/Misc</option>
								<?php
								foreach($priority_array as $item)
									{
										if($item['PriorityName'] == NULL )
										{

										}
										else
										{
											echo "<option value='".$item['PriorityName']."'>",$item['PriorityName'],"</option>";
										}
									}
								?>
							</select>
						</p>
						<p>Task Grade:
							<select name="addTaskGrade">
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
								<option value="E">E</option>
							</select>
						</p>
						<p>Task Sub-Grade:
							<select name="addTaskSubGrade">
								<option value="0">None</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select>
						</p>
						<p>Task Due Date:<input type="date" name="addDueDate"></p>
						<p>Do want the task to Reoccur after the due date?:
							<input type="radio" name="addReoccuring" value="Yes" onClick="ShowReoccur()">Yes
							<input type="radio" name="addReoccuring" value="No" onClick="HideReoccur()">No
						</p>
						<div id="addReoccuranceDays" style="display: none;">
							<p>
							Reoccur every<input type="text" name="addReoccuranceDays">Days.
							</p>
						</div>
						<p>Task Description:
							<textarea name="addTaskDescription"></textarea>
						</p>
						<button type="submit" name="submit">Add Task</button>
 					</form>
  					<a href="#" rel="modal:close">Close</a>
				</div>

				<!-- Link to open Add Task modal -->
				<p><button class='btn-block'><a href="#addTask" rel="modal:open">Add Task</a></button></p>
				
				<!-- Task Edit Data -->
				<?php

				if(isset($_SESSION['sess_TaskID']))
				{
					$EditTaskID = $_SESSION['sess_TaskID'];
				}
                else
				{
				     $EditTaskID ='';
				}
					if(isset($_SESSION['sess_TaskName']))
					{
						$EditTaskName = $_SESSION['sess_TaskName'];
					}else
					{
						 $EditTaskName = '';
					}
					if(isset($_SESSION['sess_TaskDescription']))
					{
						$EditTaskDescription = $_SESSION['sess_TaskDescription'];
					}else
					{
						 $EditTaskDescription= '';
					}
					if(isset($_SESSION['sess_TaskGrade']))
					{
						$EditTaskGrade = $_SESSION['sess_TaskGrade'];
					}else
					{
						 $EditTaskGrade = '';
					}
					if(isset($_SESSION['sess_TaskSubGrade']))
					{
						$EditTaskSubGrade = $_SESSION['sess_TaskSubGrade'];
					}else
					{
						$EditTaskSubGrade = '';
					}
					if(isset($_SESSION['sess_DateEntered']))
					{
						$EditTaskDateEntered = $_SESSION['sess_DateEntered'];
					}else
					{
						 $EditTaskDateEntered = '';
					}
					if(isset($_SESSION['sess_DateDue']))
					{
						$EditTaskDateDue = $_SESSION['sess_DateDue'];
						$EditTaskDateDue = date( 'Y-m-d', strtotime( $TaskDate) );
					}else
					{
						 $EditTaskDateDue = '';
					}
					if(isset($_SESSION['sess_Reoccurance']))
					{
						$EditTaskReoccurance = $_SESSION['sess_Reoccurance'];
							if($EditTaskReoccurance == 0)
							{
							$EditTaskReoccurance = 'No';
							$EditTaskReoccuranceNum = 0;
							}
							else
							{
							    $EditTaskReoccurance = 'Yes';
							     $EditTaskReoccuranceNum =$_SESSION['sess_ReoccuranceNum'];
							}
					}
					else
					{
						 $EditTaskReoccurance = '';
						 $EditTaskReoccuranceNum = '';
					}
					if(isset($_SESSION['sess_PriorityName']))
					{
						$EditTaskPriorityName = $_SESSION['sess_PriorityName'];
					}
					else{
						$EditTaskPriorityName = '';
					}	
                    if($EditTaskID == '')
                    {
                        
                    }
                    else
                    {
                       echo "<script type='text/javascript'>
							$(document).ready(function(){
							$('#editTask').modal('show');
							});
						</script>";
					echo "<script>
							$( '#editDueDate' ).val('$EditTaskDateDue');
					</script>"; 
                    }

	
				?>
				
				
				<!-- Edit task Modal -->
				<div id="editTask" class="modal">
					<form action="editTask.php" method="post">
						<p>Task Name: <input type="text" name="editTaskName" value="<?php echo $EditTaskName ?>" ></p>
						<p>Task Priority:
							<select name="editTaskPriority" id="editTaskPriority" type>
								<option value="none">None/Misc</option>
								<?php
								foreach($priority_array as $item)
									{
										if($item['PriorityName'] == NULL )
										{

										}
										else
										{
											echo "<option value='".$item['PriorityName']."'>",$item['PriorityName'],"</option>";
										}
									}
								?>
							</select>
						<p>Task Grade:
							<select name="editTaskGrade" id="editTaskGrade">
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
								<option value="E">E</option>
							</select>
						</p>
						<p>Task Sub-Grade:
							<select name="editTaskSubGrade" id="editTaskSubGrade">
								<option value="0">None</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select>
						</p>
						<p>Task Due Date:<input type="date" name="editDueDate" id="editDueDate"></p>
						<p>Do want the task to Reoccur after the due date?:
							<input type="radio" name="editReoccuring" id="editReoccuring" value="Yes" onClick="ShowReoccur()">Yes
							<input type="radio" name="editReoccuring" id="editReoccuring" value="No" onClick="HideReoccur()" >No
						</p>
						<div id="editReoccuranceDays" style="display: none;">
							<p>
							Reoccur every<input type="text" name="editReoccuranceDays" id="editReoccuranceDays">Days.
							</p>
						</div>
						<p>Task Description:
							<textarea name="editTaskDescription" ><?php echo $EditTaskDescription ?></textarea>
						</p>
						<button type="submit" name="submit">Submit Changes</button>
						<button type="button" name="delete"><a href="DeleteTask.php?id=<?php echo $EditTaskID ?>" >Delete Task</a></button>
						<button type="button" name="Complete"><a href="CompleteTask.php?id=<?php echo $EditTaskID ?>" >Complete Task</a></button>
 					</form>
  					<a href="#" rel="modal:close">Close</a>
				</div>


				
		</div>
		<div class="PriorityReoccur">
			<!-- Priorities Container -->
			<div class="PrioritiesContainer">
				<h1>Priorities</h1>
				<div>
					<ol>

			<!-- PHP code to output Priorities  -->
			<?php

			//Set Priority Variables
			$priority_array1 = $priority_array[0];
			$priority_Name1 = $priority_array1["PriorityName"];
			$priority_Description1 = $priority_array1["PriorityDescription"];
			$priority_array2 = $priority_array[1];
			$priority_Name2 = $priority_array2["PriorityName"];
			$priority_Description2 = $priority_array2["PriorityDescription"];
			$priority_array3 = $priority_array[2];
			$priority_Name3 = $priority_array3["PriorityName"];
			$priority_Description3 = $priority_array3["PriorityDescription"];
			if(isset($priority_array[3]))
			{
				$priority_array4 = $priority_array[3];
				$priority_Name4 = $priority_array4["PriorityName"];
				$priority_Description4 = $priority_array4["PriorityDescription"];
			}
			if(isset($priority_array[4]))
			{
				$priority_array5 = $priority_array[4];
				$priority_Name5 = $priority_array5["PriorityName"];
				$priority_Description5 = $priority_array5["PriorityDescription"];
			}
			// Output Priorities into list items
			foreach($priority_array as $item)
			{
				if($item['PriorityName'] == '' )
				{

				}
				else
				{
					echo "<li>",$item['PriorityName'],"</li>";
				}
			}

			?>
					</ol>
				</div>
			<a href="#changePriorities" rel="modal:open">Change Priorities</a>
			</div>

			<!-- Change Priorties Modal  -->
			<div id="changePriorities" class="modal">
						<form action="changePriorities.php" method="post">
							<p>
								Priority Number 1: <input type="text" name="PriorityOne" value="<?php echo $priority_Name1; ?>">
							</p>
								Priority Number 1 Description:</br>
								<textarea name="Priority1Description" ><?php echo $priority_Description1 ?></textarea>
							<p>
								Priority Number 2: <input type="text" name="PriorityTwo" value="<?php echo $priority_Name2; ?>" >
							</p>
								Priority Number 2 Description:</br>
								<textarea name="Priority2Description" ><?php echo $priority_Description2 ?></textarea>
							<p>
								Priority Number 3: <input type="text" name="PriorityThree" value="<?php echo $priority_Name3; ?>">
							</p>
								Priority Number 3 Description:</br>
								<textarea name="Priority3Description" ><?php echo $priority_Description3 ?></textarea>
							<div id="prioritySubmitOne" 
							<?php if($priority_Name4 == '')
                                	{
                                		echo "style='display: block;'";
                                	}
                                	else
                                	{
                                		echo "style='display: none;'";
                                	}
                                
                                	?>>
								<button type="button" name="AddFourth" onClick="addFourth()">Add Fourth Priority</button>   <button type="submit" name="submitPriorities">Submit Changes</button>
							</div>
							<div id="fourthPriority" 
							        <?php if($priority_Name4 == '')
                                            {
                                        		echo "style='display: none;'";
                                        	}
                                        	else
                                        	{
                                        		echo "style='display: block;'";
                                        	}
                                        
                                        	?>>
								<p>Priority Number 4: <input type="text" name="PriorityFour" value="<?php if(isset($priority_Name4))
									{echo $priority_Name4; } 
									?>" >
								</p>
								Priority Number 4 Description:</br>
								<textarea name="Priority4Description" ><?php if(isset($priority_Description4))
									{echo $priority_Name4; }  ?></textarea>
							</div>
							<div id="prioritySubmitTwo" 
							<?php if($priority_Name5 == '')
                                	{
                                		echo "style='display: block;'";
                                	}
                                	else
                                	{
                                		echo "style='display: none;'";
                                	}
                                
                                	?>>
								<button type="button" name="AddFifth" onClick="addFifth()">Add Fifth Priority</button>   <button type="submit" name="submitPriorities">Submit Changes</button>
							</div>
							<div id="FifthPriority" 
							        <?php if($priority_Name5 == '')
                                        	{
                                        		echo "style='display: none;'";
                                        	}
                                        	else
                                        	{
                                        		echo "style='display: block;'";
                                        	}
                                        
                                        	?>>
								<p>Priority Number 5: <input type="text" name="PriorityFive" value="<?php if(isset($priority_Name5))
									{echo $priority_Name5; } 
									?>">
								</p>
								Priority Number 5 Description:</br>
								<textarea name="Priority5Description" ><?php if(isset($priority_Description5))
									{echo $priority_Name5; } ?></textarea>
							</div>
							<div id="prioritySubmitThree" style="display: none;">
								<button type="submit" name="submitPriorities">Submit Changes</button>
							</div>
						</form>
						<a href="#" rel="modal:close">Close</a>
			</div>

			<!--Container for Reoccuring Tasks -->
			<div class="ReoccuringContainer">
				<h1>Reoccuring Tasks</h1>
				<div>
					<ul>
					<?php 
							if(isset($RTaskArray))
							{
								foreach($RTaskArray as $Task)
								{
								    foreach($priority_array as $priority)
										{
											if($priority['PriorityID'] == $Task['PriorityID'])
											{
												$TaskPriority =$priority['PriorityName'];
											}
										}
									$TaskID= $Task['TaskID'];
									$TaskName= $Task['TaskName'];
									$TaskDate= $Task['DateDue'];
									$TaskDate = date( 'M-d', strtotime( $TaskDate) );
									if(isset($Task['DateCompleted']))
                                    {
                                    	$DateCompleted = $Task['DateCompleted'];
	                                    $DateCompleted = date( 'M-d', strtotime( $DateCompleted) );
	                                    $ReoccuranceNum = $Task['ReoccuranceNum'];
	                                    $NextDueDate = date('M-d', strtotime($DateCompleted.' + '.$ReoccuranceNum.'days')); ?>
                                    	<li>
			                                    <a href='FindTask.php?id=<?php echo $TaskID; ?>' >
				                                    <?php echo $TaskName; ?>
			                                    </a>
			                                    </br> <?php echo $TaskPriority; ?>
			                                    </br>Last Done:<?php echo $DateCompleted; ?>
			                                    </br>Next Due Date:<?php echo $NextDueDate; ?>
	                                    	</li> <?php
                                    }
                                    else
                                    {
                                    	?><li>
                                    			<a href='FindTask.php?id=<?php echo $TaskID; ?>' >
                                    				<?php echo $TaskName; ?>
                                    			</a>
                                    			</br>Due By:<?php echo $TaskDate; ?>
                                    		</li> <?php
                                    }

								}	
								
							}
							else
							{
								echo "<li>No tasks available</br>"?>
								<a href="#addTask" rel="modal:open"><button>Click Here to Add a Task</button>
								</a>
					  <?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

		
			
	</body>
	<script>
		$( "#editTaskPriority" ).val("<?php echo $EditTaskPriorityName ?>");
		$( "#editTaskGrade" ).val("<?php echo $EditTaskGrade ?>");
		$( "#editTaskSubGrade" ).val("<?php echo $EditTaskSubGrade ?>");
		$( "#editDueDate" ).val("<?php echo $EditTaskDateDue ?>");
		<?php 
			if($EditTaskReoccurance == "Yes")
			{
				echo "$('input[name=editReoccuring][value=Yes]').prop('checked',true);";
				echo "ShowReoccur().call();";
			}
			else
			{
				echo "$('input[name=editReoccuring][value=No]').prop('checked',true);";
			}
		?>
		$( "#editReoccuranceDays" ).val("<?php echo $EditTaskReoccuranceNum ?>");
		//$( "#" ).val("<?php // echo  ?>");
Success!
		//$( "#" ).val("<?php //echo  ?>");
		//$( "#" ).val("<?php //echo  ?>");
	</script>
</html>
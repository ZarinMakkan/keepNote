<?php
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
if (!empty($_POST["taskName"])){
	$bulk = new MongoDB\Driver\BulkWrite;
	$bulk->insert(['task' => $_POST["taskName"], 'completed' => 0]);
	$manager->executeBulkWrite('todo.tasks', $bulk);
}
if (isset($_POST["delete"])){
  $bulk = new MongoDB\Driver\BulkWrite;
  $bulk->delete(['task' => $_POST["oldTaskName"]]);
  $manager->executeBulkWrite('todo.tasks', $bulk);
}else if (isset($_POST["update"])){
  $bulk = new MongoDB\Driver\BulkWrite;
  $bulk->update(
      ['task' => $_POST["oldTaskName"]],
      ['$set' => ['task' => $_POST["taskNameUpdate"]]]
  );
  $manager->executeBulkWrite('todo.tasks', $bulk);
}

$query = new MongoDB\Driver\Query([]); 
$rows = $manager->executeQuery("todo.tasks", $query);
?>

<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        
    </head>
    <body>
        <section class="vh-100" style="background-color: #e2d5de;">
            <div class="container py-5 h-100">
              <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                  <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-5">
                      <h6 class="mb-3">Awesome Todo List</h6>
                      <form class="d-flex justify-content-center align-items-center mb-4" action="index.php" method="post">
                        <div class="form-outline flex-fill">
                          <input type="text" id="form1" name="taskName" class="form-control form-control-lg" />
                          <label class="form-label" for="form1">What do you need to do today?</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg ms-2">Add</button>
                      </form>
          
                      <ul class="list-group mb-0">
                        <?php
						foreach ($rows as $row) { ?>
						<form action="index.php" method="post">
							<input type="hidden" name="oldTaskName" value="<?php echo $row->task ?>">
							<li class="list-group-item d-flex justify-content-between align-items-center border-start-0 border-top-0 border-end-0 border-bottom rounded-0 mb-2">
							<div class="d-flex align-items-center">
								<input class="form-check-input me-2" name="completed" type="checkbox" value="<?php $row->completed ?>" aria-label="..." />
								<input type="text" name="taskNameUpdate" class="form-control form-control-lg" value="<?php echo $row->task; ?>" />
							</div>
							<input type="submit" class="btn btn-success" name="update" value="update" />
              <input type="submit" class="btn btn-danger" name="delete" value="delete" />
							</li>
						</form>
						<?php } ?>
                      </ul>
          
                    </div>
                  </div>
          
                </div>
              </div>
            </div>
          </section>
    </body>
</html>
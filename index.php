<?php
include "./db.php";
session_start();
if (!isset($_SESSION['userId'])) {
  header("Location: accountPage/loginPage.php");
  exit();
}
$userId = $_SESSION['userId'];
if (isset($_POST['submit'])) {
  // Get task and priority from form
  $task = mysqli_real_escape_string($conn, $_POST['task']);
  $priority = mysqli_real_escape_string($conn, $_POST['priority']);

  // Insert into database
  $sql = "INSERT INTO todotask (task, priority, isDone, userId) VALUES ('$task', '$priority', 0, $userId)";

  if (mysqli_query($conn, $sql)) {
    header("Location: index.php"); // Redirect to prevent form resubmission
    exit();
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
if (isset($_POST['editTaskId'])) {
  $id = intval($_POST['editTaskId']);
  $task = mysqli_real_escape_string($conn, $_POST['editTaskInput']);
  $priority = mysqli_real_escape_string($conn, $_POST['editPriority']);

  $sql = "UPDATE todotask SET task='$task', priority='$priority' WHERE id=$id";

  if (mysqli_query($conn, $sql)) {
    header("Location: index.php"); // Redirect to prevent form resubmission
    exit();
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
if (isset($_POST['deleteTaskId'])) {
  $id = $_POST['deleteTaskId'];

  $sql = "DELETE FROM `todotask` WHERE `todotask`.`id` = $id";
  if (mysqli_query($conn, $sql)) {
    header("Location: index.php"); // Redirect to prevent form resubmission
    exit();
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}

if (isset($_POST['doneTaskId'])) {
  $id = $_POST['doneTaskId'];
  $sql = "UPDATE `todotask` SET `isDone` = '1' WHERE `todotask`.`id` = $id;";

  if (mysqli_query($conn, $sql)) {
    header("Location: index.php"); // Redirect to prevent form resubmission
    exit();
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>To-Do List | Do your task on time</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="shortcut icon" href="./Img/Logo.png" type="image/x-icon">
</head>

<body>

  <!-- Edit Task Modal -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close" id="closeModal">&times;</span>
      <h2>Edit Task</h2>
      <form id="editForm" action="./index.php" method="post">
        <input type="hidden" id="editTaskId" name="editTaskId">
        <label>Task: </label>
        <input type="text" id="editTaskInput" required name="editTaskInput">
        <br>
        <label>Priority:</label>
        <div class="priority-selector">
          <label>
            <input type="radio" name="editPriority" value="high" required>
            <span class="dot red"></span>
          </label>
          <label>
            <input type="radio" name="editPriority" value="medium" required>
            <span class="dot orange"></span>
          </label>
          <label>
            <input type="radio" name="editPriority" value="low" required>
            <span class="dot green"></span>
          </label>
        </div>

        <button type="submit">Update Task</button>
      </form>
    </div>
  </div>
  <!-- Edit Task Modal ended -->
  <!------------------ Delete Modal Started -------------------->
  <div id="deleteModal" class="modal">
    <div class="modal-content" style="max-width:400px ">
      <span class="close deleteClose" id="closeModal">&times;</span>
      <h2>Delete Task</h2>
      <p>Do You Want to delete ?</p>
      <form id="deleteForm" action="./index.php" method="post">
        <input type="hidden" id="deleteTaskId" name="deleteTaskId">
        <br>
        <button type="submit">Yes</button>
      </form>
    </div>
  </div>
  <!-- Delete Modal Ended -->
  <!------------------ Done Modal Started -------------------->
  <div id="doneModal" class="modal">
    <div class="modal-content" style="max-width:400px ">
      <span class="close doneClose" id="closeModal">&times;</span>
      <h2>Task Done</h2>
      <p>Is you done your task ?</p>
      <form id="doneForm" action="./index.php" method="post">
        <input type="hidden" id="doneTaskId" name="doneTaskId">
        <br>
        <button type="submit" id="confirmDone">Yes</button>
      </form>
    </div>
  </div>
  <!-- Done Modal Ended -->
  <!-------------- NavBar Section ---------------->
  <nav class="navBar">
    <div class="logoContainer">
      <img src="./Img/Logo.png" alt="logo">
      <span>To-Do Manager</span>
    </div>

    <div class="useAuth">
      <?php
      if (isset($_SESSION['userId'])) {
        echo '
          <img src="./img/profile.png" class = "profile"> 
          <p> Hello, Mr. ' . $_SESSION['username'] . '</p> 
          <a href="/PhpProject/TodoList/accountPage/logout.php">Log out</a>
          <a href="./herosection.php">Home</a>';
      } else {
        echo '<a href="#">Login</a>
                <a href="#">Sign-Up</a>';
      }
      ?>

    </div>
  </nav>
  <!-- NavBar Ended -->
  <!-------------- To Do Add from Section  ---------------->
  <form action="./index.php" method="post" class="input-container">
    <input type="text" name="task" placeholder="Enter your task..." required>

    <div class="priority-selector">
      <label>
        <input type="radio" name="priority" value="high" checked>
        <span class="dot red"></span>
      </label>
      <label>
        <input type="radio" name="priority" value="medium">
        <span class="dot orange"></span>
      </label>
      <label>
        <input type="radio" name="priority" value="low">
        <span class="dot green"></span>
      </label>
    </div>

    <button type="submit" name="submit">Add Note</button>
  </form>
  <!-- To Do Add from Ended -->
  <!-------------- To Do Info Section  ---------------->
  <div class="toDoInfo">
    <div class="tableData">
      <table>
        <thead>
          <tr>
            <th>No.</th>
            <th>Task</th>
            <th>Priority</th>
            <th>Action</th>
            <th>Done</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $sql = "SELECT * FROM `todotask`WHERE userId = '$userId'";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while ($row = mysqli_fetch_assoc($result)) {
            // Dynamically set priority class
            $priorityClass = "";
            if ($row['priority'] == 'low') {
              $priorityClass = "low";
            } elseif ($row['priority'] == 'medium') {
              $priorityClass = "medium";
            } elseif ($row['priority'] == 'high') {
              $priorityClass = "high";
            }

            // Checkbox checked if done = 1
            $checked = ($row['isDone'] == 1) ? "checked" : "";
            $sno += 1;
            echo "
            <tr>
              <td class='task-id'>" . $sno . "</td>
              <td class='task-idReal' hidden>" . $row['id'] . "</td>
              <td class='task-text'>" . $row['task'] . "</td>
              <td><span class='priority-dot $priorityClass'></span></td>
              <td>
                <div class='btn-container'>
                  <span class='btn edit-btn'><i class='fas fa-edit' style='color: #28a745;'></i></span>
                  <span class='btn delete-btn'>
                    <i class='fas fa-trash' style='color: #dc3545;'></i>
                  </span>
                </div>
              </td>
              <td><input type='checkbox' $checked id='checkBox' class='isDoneBox'></td>
            </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="./app.js"></script>
</body>

</html>
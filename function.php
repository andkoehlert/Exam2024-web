

<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/config.php'; 



function validate($inputdata) {



return htmlspecialchars((trim($inputdata)));
}


function redirect($url, $status) 
{
  $_SESSION['status'] = "$status";
  header('Location: '.$url);
  exit();}

function alertMessage()

{if(isset($_SESSION['status'])) 
  {
    echo '<div class="alert alert-success">
            <h4>'.$_SESSION['status'].'</h4>
            </div>';
  unset($_SESSION['status']);
    
  }

}

function deleteMessage()

{if(isset($_SESSION['status'])) 
  {
    echo '<div class="alert alert-success"
            <h4>'.$_SESSION['status'].'</h4>
            </div>';
  unset($_SESSION['status']);
    
  }

}

function getALL($tableName)
{
    global $pdo;

    $validTables = ['users2']; // List of allowed tables
    if (!in_array($tableName, $validTables)) {
        throw new Exception("Table not found");
    }

    $sql = "SELECT * FROM $tableName"; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getById($tableName, $id) {
  global $pdo;

  $validTables = ['users2']; // List of allowed tables
  if (!in_array($tableName, $validTables)) {
      throw new Exception("Table not found");
  }

  $sql = "SELECT * FROM $tableName WHERE users2_id = :id LIMIT 1";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();

  if ($stmt) {
      if ($stmt->rowCount() == 1) {
          $user = $stmt->fetch(PDO::FETCH_ASSOC); 
          return [
              'status' => 200,
              'data' => $user,
              'message' => 'Data found',
          ];
      } else {
          return [
              'status' => 404,
              'message' => 'No data found',
          ];
      }
  } else {
      return [
          'status' => 500,
          'message' => 'Something went wrong',
      ];
  }
}




function checkParamId($paramType) {

  if(isset($_GET[$paramType])) {
    if($_GET[$paramType] != null){
    return $_GET[$paramType];
    }else{
      return 'No id found';
    }
  }else {
    return 'No id given';
  }
}


function deleteQuery($tableName, $id) {
  global $pdo;

  $validTables = ['users2']; // List of allowed tables
  if (!in_array($tableName, $validTables)) {
      throw new Exception("Table not found");
  }  



  $sql = "DELETE FROM $tableName WHERE users2_id = :id LIMIT 1";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);

  if ($stmt->execute()) {
    return $stmt->rowCount() > 0;

  } else {
    return false;
  }

}

function deleteUserById($id) {
  global $pdo; 

  $query = "DELETE FROM users2 WHERE users2_id = ?";
  $stmt = $pdo->prepare($query);
  
  return $stmt->execute([$id]);// Returns true if successful
}




?>
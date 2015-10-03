<?php

require("config.inc.php");

if (!empty($_POST)) {

    if (empty($_POST['fname']) || empty($_POST['password'])) {
        
        
        $response["success"] = 0;
        $response["message"] = "Please Enter Both a Username and Password.";
        

        die(json_encode($response));
    }
    
    $query        = " SELECT * FROM users WHERE phone = :phone";
    $query_params = array(
        ':phone' => $_POST['phone']
    );
    
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        $response["success"] = 0;
        $response["message"] = "Database Error1. Please Try Again!";
        die(json_encode($response));
    }
    

    $row = $stmt->fetch();
    if ($row) {

        $response["success"] = 0;
        $response["message"] = "I'm sorry, this phone is already in use";
        die(json_encode($response));
    }
    
 
    $query = "INSERT INTO users ( username, email,password,phone ) VALUES ( :username, :email, :password, :phone ) ";
        $query_params = array(
        ':username' => $_POST['username'],
        ':email' => $_POST['email'],
        ':password' => $_POST['password'],
        ':phone' => $_POST['phone'],
		
    );
    
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        $response["success"] = 0;
        $response["message"] = "Database Error2. Please Try Again!";
        die(json_encode($response));
    }
    

    $response["success"] = 1;
    $response["message"] = "Username Successfully Added!";
    echo json_encode($response);
     
    
} 
?>
	

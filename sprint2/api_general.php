<?php
    class Data_fetch {

        public $databaseName = null;
        public $serverName = null;
        public $sql = null;

        public function __construct($serverName, $databaseName)
        {
            $this->databaseName = $databaseName;
            $this->serverName = $serverName;
             
        }

        public function findAll($serverName, $databaseName)
        {
            $connectionInfo = array("Database"=>$databaseName); 
            $conn = sqlsrv_connect( $serverName, $connectionInfo);
            if(!$conn)
            {
                echo "Connection not established";
            }
            
            $sql = "SELECT * FROM TEACHER"; 
            $result = sqlsrv_query( $conn, $sql);
            $response['data'] = array(); 
            while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_NUMERIC))  
            {
                $id = ['id', $row[0]];
                $firstname =  ['firstname', $row[1]];
                $lastname = ['lastname', $row[2]];
                $email = ['email', $row[3]];
                $pass = ['pass', $row[4]];
                $number = ['number', $row[5]];
                $department = ['department', $row[6]];
                $gender = ['gender', $row[7]];
                array_push($response['data'], $id, $firstname, $email, $pass, $number, $department, $gender);
            }

            echo json_encode($response);

            
            $sql = "SELECT * FROM COURSE"; 
            $result = sqlsrv_query( $conn, $sql);
            $response['data'] = array(); 
            while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_NUMERIC))  
            {  
                $id = ['id', $row[0]];
                $name = ['name', $row[1]];
                $section = ['section', $row[2]];
                $department = ['department', $row[3]];
                $module = ['module', $row[4]];
                $teacher_id = ['teacher id', $row[5]];
                array_push($response['data'], $id, $name, $section, $department, $module, $teacher_id);
            }
            

            echo json_encode($response);
        }

        public function find_query()
        {

        }
}

$serverName = "DESKTOP-Q5PEO1M"; //change the server name if you want to access this on your local server
$databaseName = "Teachers"; 
$data = new Data_fetch($serverName, $databaseName);
$result = $data->findAll($serverName, $databaseName);
$query_result = $data->find_query()
?>
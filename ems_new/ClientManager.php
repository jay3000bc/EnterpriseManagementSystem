<?php
include_once 'DBManager.php';

class ClientManager {

    public function getClientIdType() {
        $db = new DBManager();
        $sql = "SELECT type from ems_manage_client_id";
        $result = $db->getARecord($sql);
        return $result;
    }
    public function getAutoIncrimentID() {
        $databaseName = $GLOBALS['databaseName'];
        $db = new DBManager();
        $sql = "SELECT `AUTO_INCREMENT`
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = '$databaseName'
            AND   TABLE_NAME   = 'ems_clients'";
        $data = $db->getARecord($sql);
        return $data;
 
    }
    public function getClientIdDetails() {
        $db = new DBManager();
        $sql = "SELECT * from ems_client_auto_id";
        $result = $db->getARecord($sql);
        return $result;
    }
    public function manageClientId($type) {
        $db = new DBManager();
        $sql = "SELECT * from ems_manage_client_id";
        $total = $db->getNumRow($sql);
        if($total == 0) {
            $sql = "INSERT into ems_manage_client_id ( type ) Values ( '$type' )";
        }
        else {
           $sql = "UPDATE ems_manage_client_id set type = '$type'"; 
        }
        $result = $db->execute($sql);
        return $result;
    }
    // list all clients
    public function listClients() {
        $db = new DBManager();
        $sql = "SELECT * from ems_clients";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->id[] = $row['id'];
            $this->client_id[] = $row['client_id'];
            $this->name[] = $row['name'];
            $this->country[] = $row['country'];
            $this->created_at[] = $row['created_at'];
            $this->status[] = $row['status'];
        }
        return $total;

    }
    public function saveClientDetails($client_id, $name, $country, $state, $gstin, $email, $phone_no,  $address, $photo, $created_at ) {

        $db = new DBManager();
        $sql = "INSERT into ems_clients(client_id, name, country, state, gstin, email, phone_no, address, photo, created_at) 
        Values('$client_id', '$name', '$country', '$state', '$gstin', '$email', '$phone_no', '$address', '$photo', '$created_at')";
        $result = $db->execute($sql);
        return $result;
    }
    public function saveClientProjects($client_id, $project_title, $project_description, $created_at ) {
        $db = new DBManager();
        $sql = "INSERT into ems_projects(client_id, title, description, created_at) 
        Values('$client_id', '$project_title', '$project_description', '$created_at')";
        $result = $db->execute($sql);
        return $result;
    }
    public function getClientDetails($client_id) {
        $db = new DBManager();
        if (is_numeric($client_id)) {
            $sql = "SELECT * from ems_clients where client_id=$client_id";
        }
        else {
             $sql = "SELECT * from ems_clients where client_id='$client_id'";
        }
        $clientsDetails = $db->getARecord($sql);
        return $clientsDetails;
    }
    public function getClientProjects($client_id) {
        $db = new DBManager();
        if (is_numeric($client_id)) {
            $sql = "SELECT * from ems_projects where client_id=$client_id";
        }
        else {
            $sql = "SELECT * from ems_projects where client_id='$client_id'"; 
        }    
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->project_id[] = $row['id'];
            $this->title[] = $row['title'];
            $this->description[] = $row['description'];
            $this->created_at[] = $row['created_at'];
            $this->ended_at[] = $row['ended_at'];
            $this->status[] = $row['status'];
        }
        return $total;
    }
    public function editClientDetails($client_id, $name, $country, $state, $gstin, $email, $phone_no,  $address, $photo) {
        $db = new DBManager();
        if (is_numeric($client_id)) {
        $sql = "UPDATE ems_clients set name='$name', country='$country', state='$state', gstin='$gstin', email='$email', phone_no= '$phone_no', address='$address', photo='$photo' where client_id=$client_id";
        }
        else {
           $sql = "UPDATE ems_clients set name='$name', country='$country', state='$state', gstin='$gstin', email='$email', phone_no= '$phone_no', address='$address', photo='$photo' where client_id='$client_id'"; 
        }
        $result = $db->execute($sql);
        return $result;
    }
    public function editClientProjects($client_id, $title, $description, $project_id) {
        $db = new DBManager();
        if (is_numeric($client_id)) {
        $sql = "UPDATE ems_projects set title='$title', description='$description' where client_id=$client_id and id=$project_id";
        }
        else {
           $sql = "UPDATE ems_projects set title='$title', description='$description' where client_id='$client_id' and id='$project_id'"; 
        }
        $result = $db->execute($sql);
        return $result;
    }
    //list All Projects
    public function listAllProjects() {
        $db = new DBManager();
        $sql = "SELECT ems_projects.id, ems_projects.client_id, ems_projects.title, ems_projects.description, ems_projects.created_at, ems_projects.ended_at,ems_projects.status, ems_clients.name  from ems_projects, ems_clients where ems_projects.client_id = ems_clients.client_id";   
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->project_id[] = $row['id'];
            $this->client_id[] = $row['client_id'];
            $this->title[] = $row['title'];
            $this->description[] = $row['description'];
            $this->created_at[] = $row['created_at'];
            $this->ended_at[] = $row['ended_at'];
            $this->status[] = $row['status'];
            $this->name[] = $row['name'];
        }
        return $total;
    }
    // get a project details 
    public function getAProjectDetails($id) {
        $db = new DBManager();
        $sql = "SELECT * from ems_projects where id=$id";
        $result = $db->getARecord($sql);
        return $result;
    }
    public function changeProjectStatus($id, $status, $ended_at, $client_id) {
        $db = new DBManager();
        if($status == 1) {
            $sql = "UPDATE ems_projects set status = 0, ended_at = '' where id='$id'";
        }
        if($status == 0) {
            $sql = "UPDATE ems_projects set status = 1, ended_at = '$ended_at' where id='$id'";
        }
        $result = $db->execute($sql);
        if(is_numeric($client_id)) {
            $sql1 = "SELECT * from ems_projects where client_id= $client_id and status=0";
            $total = $db->getNumRow($sql1);
            if($total == 0) {
                $sql2 = "UPDATE ems_clients set status = 1 where client_id=$client_id";
                $result2 = $db->execute($sql2);
            }
            else {
                $sql2 = "UPDATE ems_clients set status = 0 where client_id=$client_id";
                $result2 = $db->execute($sql2);
            }
        }
        else {
            $sql1 = "SELECT * from ems_projects where client_id= '$client_id' and status=0";
            $total = $db->getNumRow($sql1);
            if($total == 0) {
                $sql2 = "UPDATE ems_clients set status = 1 where client_id='$client_id'";
                $result2 = $db->execute($sql2);
            }
            else {
                $sql2 = "UPDATE ems_clients set status = 0 where client_id='$client_id'";
                $result2 = $db->execute($sql2);
            }
        }    
        
        if($result) {
            return 'success'; 
        }
        else {
            return 'fail';
        }
    }
    public function deleteProject($id) {
        $db = new DBManager();
        $sql = "DELETE from ems_projects where id='$id'";
        $result = $db->execute($sql);
        if($result) {
            return 1; 
        }
    }
    public function deleteClient($id) {
        $db = new DBManager();
        $sql = "DELETE from ems_clients where client_id='$id'";
        $result = $db->execute($sql);
        $sql1 = "DELETE from ems_projects where client_id='$id'";
        $result1 = $db->execute($sql1);
        if($result) {
            return 1; 
        }
    }

    public function listClientName($searchKey) {
        $db = new DBManager();
        $sql = "SELECT * from ems_clients where name LIKE '$searchKey%'";
        $data = $db->getAllRecords($sql);
        $arrayNameList =array();
        $arrayName = array();
        while ($row = $db->getNextRow()) {
            $arrayName['id'] = $row['id'];
            $arrayName['client_id'] = $row['client_id'];
            $arrayName['value'] = $row['name'];
            $arrayName['label'] = $row['name'];
            $arrayName['gstin'] = $row['gstin'];
            $arrayName['state'] = $row['state'];
            $arrayName['address'] = $row['address'];
            $arrayName['email'] = $row['email'];
            array_push($arrayNameList, $arrayName); 
        }

        return $arrayNameList;
    }
     // check_already_exist_client
    public function check_already_exist_client($value, $field_name) {
        $db = new DBManager();
        $sql = "SELECT * from ems_clients where $field_name = '$value'";
        $total = $db->getNumRow($sql);
        return $total;
    }
}
?>
<?php
header('Content-Type: application/json');

include 'includes/Connection.php';
include 'includes/CRUD.php';

$action = $_POST['action'];

$connection = new Connection();
$crud = new CRUD($connection->getConnection());

$response = array();

switch ($action) {
    case 'get_records':
        $records = $crud->getAllRecords();

        if ($records) {
            $response['error'] = false;
            $response['records'] = $records;
        } else {
            $response['error'] = true;
            $response['message'] = 'No records available.';
        }

        break;

    case 'insert_record':
        // Retrieve and sanitize the data
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        if (!empty($name) && !empty($email)) {
            $data = array(
                'name' => $name,
                'email' => $email
            );

            $result = $crud->insertRecord($data);

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Record inserted successfully.';
            } else {
                $response['error'] = true;
                $response['message'] = 'Error occurred while inserting the record.';
            }
        } else {
            $response['error'] = true;
            $response['message'] = 'Invalid data provided.';
        }

        break;

    case 'update_record':
        // Retrieve and sanitize the data
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        if ($id !== false && !empty($name) && !empty($email)) {
            $data = array(
                'name' => $name,
                'email' => $email
            );

            $result = $crud->updateRecord($id, $data);

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Record updated successfully.';
            } else {
                $response['error'] = true;
                $response['message'] = 'Error occurred while updating the record.';
            }
        } else {
            $response['error'] = true;
            $response['message'] = 'Invalid data provided.';
        }

        break;

    case 'delete_record':
        // Retrieve and sanitize the data
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id !== false) {
            $result = $crud->deleteRecord($id);

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Record deleted successfully.';
            } else {
                $response['error'] = true;
                $response['message'] = 'Error occurred while deleting the record.';
            }
        } else {
            $response['error'] = true;
            $response['message'] = 'Invalid data provided.';
        }

        break;

    default:
        $response['error'] = true;
        $response['message'] = 'Invalid action.';
}

echo json_encode($response);
?>

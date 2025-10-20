<?php
require_once 'config.php';
require_once 'EmployeeManager.class.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=employee_management", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $employeeManager = new EmployeeManager($pdo);

    // Get the action from POST
    $action = $_POST['action'] ?? '';

    // Enable CORS for debugging
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    switch ($action) {
        case 'get_all_employees':
            $employees = $employeeManager->getAllEmployees();
            sendResponse($employees);
            break;

        case 'get_employee':
            $id = $_POST['id'] ?? 0;
            if (!$id) sendError('Employee ID is required');
            $employee = $employeeManager->getEmployee($id);
            sendResponse($employee);
            break;

        case 'add_employee':
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'salary' => $_POST['salary'],
                'department_id' => $_POST['department_id'],
                'hire_date' => $_POST['hire_date']
            ];
            $result = $employeeManager->addEmployee($data);
            sendResponse(['message' => 'Employee added successfully']);
            break;

        case 'update_employee':
            $id = $_POST['id'];
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'salary' => $_POST['salary'],
                'department_id' => $_POST['department_id'],
                'hire_date' => $_POST['hire_date']
            ];
            $result = $employeeManager->updateEmployee($id, $data);
            sendResponse(['message' => 'Employee updated successfully']);
            break;

        case 'delete_employee':
            $id = $_POST['id'] ?? 0;
            error_log("Delete request received for ID: " . $id); // Debug log
            
            if (!$id) {
                sendError('Employee ID is required');
            }
            
            $result = $employeeManager->deleteEmployee($id);
            
            if ($result) {
                sendResponse(['message' => 'Employee deleted successfully']);
            } else {
                sendError('Failed to delete employee');
            }
            break;

        case 'get_departments':
            $departments = $employeeManager->getDepartments();
            sendResponse($departments);
            break;

        case 'get_above_avg_salary':
            $employees = $employeeManager->getEmployeesAboveAverageSalary();
            sendResponse($employees);
            break;

        case 'get_department_rankings':
            $rankings = $employeeManager->getDepartmentSalaryRankings();
            sendResponse($rankings);
            break;

        case 'get_dept_highest_paid':
            $employees = $employeeManager->getDepartmentHighestPaidEmployees();
            sendResponse($employees);
            break;

        case 'get_dashboard_stats':
            $stats = $employeeManager->getDashboardStats();
            sendResponse($stats);
            break;

        default:
            sendError('Invalid action specified: ' . $action);
            break;
    }

} catch (Exception $e) {
    sendError($e->getMessage());
}
?>
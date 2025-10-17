<?php
require_once 'config.php';
require_once 'EmployeeManager.class.php';

try {
    $employeeManager = new EmployeeManager($pdo);

    // Get the action from POST or GET
    $action = $_POST['action'] ?? $_GET['action'] ?? '';

    switch ($action) {
        case 'get_all_employees':
            $employees = $employeeManager->getAllEmployees();
            sendResponse($employees);
            break;

        case 'get_employee':
            $id = $_POST['id'] ?? $_GET['id'] ?? 0;
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
            $id = $_POST['id'] ?? $_GET['id'] ?? 0;
            if (!$id) sendError('Employee ID is required');
            $result = $employeeManager->deleteEmployee($id);
            sendResponse(['message' => 'Employee deleted successfully']);
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
            sendError('Invalid action specified');
            break;
    }

} catch (Exception $e) {
    sendError($e->getMessage());
}
?>
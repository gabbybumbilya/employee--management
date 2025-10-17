<?php
require_once 'db_connection.php';

class EmployeeManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // CREATE - Add new employee
    public function addEmployee($data) {
        try {
            $sql = "INSERT INTO employees (name, email, salary, department_id, hire_date) 
                    VALUES (:name, :email, :salary, :department_id, :hire_date)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            throw new Exception(message: "Error adding employee: " . $e->getMessage());
        }
    }

    // READ - Get all employees with department names
    public function getAllEmployees() {
        $sql = "SELECT e.*, d.name as department_name 
                FROM employees e 
                LEFT JOIN departments d ON e.department_id = d.id 
                ORDER BY e.id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ - Get single employee
    public function getEmployee($id) {
        $sql = "SELECT * FROM employees WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE - Update employee
    public function updateEmployee($id, $data) {
        try {
            $data['id'] = $id;
            $sql = "UPDATE employees SET name = :name, email = :email, salary = :salary, 
                    department_id = :department_id, hire_date = :hire_date WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            throw new Exception(message: "Error updating employee: " . $e->getMessage());
        }
    }

    // DELETE - Delete employee
    public function deleteEmployee($id) {
        try {
            $sql = "DELETE FROM employees WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new Exception(message: "Error deleting employee: " . $e->getMessage());
        }
    }

    // Get all departments
    public function getDepartments() {
        $sql = "SELECT * FROM departments ORDER BY name";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // SQL SUBQUERY 1: Get employees with above-average salary
    public function getEmployeesAboveAverageSalary() {
        $sql = "SELECT e.*, d.name as department_name,
                (SELECT AVG(salary) FROM employees) as company_avg_salary
                FROM employees e 
                LEFT JOIN departments d ON e.department_id = d.id 
                WHERE e.salary > (SELECT AVG(salary) FROM employees)
                ORDER BY e.salary DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // SQL SUBQUERY 2: Get department rankings by average salary
    public function getDepartmentSalaryRankings() {
        $sql = "SELECT d.name as department_name,
                (SELECT COUNT(*) FROM employees WHERE department_id = d.id) as employee_count,
                (SELECT AVG(salary) FROM employees WHERE department_id = d.id) as avg_salary,
                (SELECT RANK() OVER (ORDER BY AVG(salary) DESC) 
                 FROM employees WHERE department_id = d.id) as salary_rank
                FROM departments d
                HAVING employee_count > 0
                ORDER BY salary_rank";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // SQL SUBQUERY 3: Get employees with highest salary in their department
    public function getDepartmentHighestPaidEmployees() {
        $sql = "SELECT e.*, d.name as department_name
                FROM employees e
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.salary = (
                    SELECT MAX(salary) 
                    FROM employees 
                    WHERE department_id = e.department_id
                )
                ORDER BY d.name";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get dashboard statistics
    public function getDashboardStats() {
        $sql = "SELECT 
                (SELECT COUNT(*) FROM employees) as total_employees,
                (SELECT AVG(salary) FROM employees) as avg_salary,
                (SELECT SUM(salary) FROM employees) as total_salary,
                (SELECT COUNT(DISTINCT department_id) FROM employees) as total_departments";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
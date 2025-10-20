<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Simple Employee Management</h1>
        </div>
    </header>

    <div class="container">
        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showTab('dashboard')">Dashboard</button>
            <button class="nav-tab" onclick="showTab('employees')">Employees</button>
            <button class="nav-tab" onclick="showTab('addEmployee')">Add Employee</button>
            <button class="nav-tab" onclick="showTab('reports')">Reports</button>
        </div>

        <!-- Dashboard Tab -->
        <div id="dashboard" class="tab-content active">
            <h2>Dashboard</h2>
            <div class="stats-grid" id="statsGrid">
                <!-- Stats will be loaded via JavaScript -->
            </div>
            
            <h3>Department Salary Rankings</h3>
            <div id="departmentRankings">
                <!-- Rankings will be loaded via JavaScript -->
            </div>
        </div>

        <!-- Employees List Tab -->
        <div id="employees" class="tab-content">
            <h2>Employee List</h2>
            <div id="employeeList">
                <!-- Employee list will be loaded via JavaScript -->
            </div>
        </div>

        <!-- Add Employee Tab -->
        <div id="addEmployee" class="tab-content">
            <h2 id="formTitle">Add New Employee</h2>
            <form id="employeeForm">
                <input type="hidden" id="employeeId" name="id">
                
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="salary">Salary:</label>
                    <input type="number" id="salary" name="salary" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="department_id">Department:</label>
                    <select id="department_id" name="department_id" required>
                        <option value="">Select Department</option>
                        <!-- Options will be populated via JavaScript -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="hire_date">Hire Date:</label>
                    <input type="date" id="hire_date" name="hire_date" required>
                </div>

                <button type="submit" class="btn" id="submitBtn">Add Employee</button>
                <button type="button" class="btn btn-secondary" onclick="resetForm()">Cancel</button>
            </form>
        </div>

        <!-- Reports Tab -->
        <div id="reports" class="tab-content">
            <h2>Reports & Analytics</h2>
            
            <h3>Employees with Above Average Salary</h3>
            <div id="aboveAvgSalary">
                <!-- Data will be loaded via JavaScript -->
            </div>

            <h3>Highest Paid Employees by Department</h3>
            <div id="highestPaidByDept">
                <!-- Data will be loaded via JavaScript -->
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
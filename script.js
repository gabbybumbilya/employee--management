class EmployeeManager {
    constructor() {
        this.apiUrl = 'api.php';
        this.loadDepartments();
        this.loadEmployees();
        this.loadDashboard();
        this.setupEventListeners();
    }

    setupEventListeners() {
        document.getElementById('employeeForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleEmployeeSubmit();
        });
    }

    async apiCall(formData) {
        try {
            const response = await fetch(this.apiUrl, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            
            if (!result.success) {
                throw new Error(result.error || 'Unknown error occurred');
            }
            
            return result.data;
        } catch (error) {
            console.error('API Error:', error);
            this.showMessage(error.message, 'error');
            throw error;
        }
    }

    async loadDepartments() {
        try {
            const formData = new FormData();
            formData.append('action', 'get_departments');
            
            const departments = await this.apiCall(formData);
            this.populateDepartmentSelect(departments);
        } catch (error) {
            // Error already handled in apiCall
        }
    }

    populateDepartmentSelect(departments) {
        const select = document.getElementById('department_id');
        select.innerHTML = '<option value="">Select Department</option>';
        
        departments.forEach(dept => {
            const option = document.createElement('option');
            option.value = dept.id;
            option.textContent = dept.name;
            select.appendChild(option);
        });
    }

    async loadEmployees() {
        try {
            const formData = new FormData();
            formData.append('action', 'get_all_employees');
            
            const employees = await this.apiCall(formData);
            this.displayEmployees(employees);
        } catch (error) {
            // Error already handled in apiCall
        }
    }

    displayEmployees(employees) {
        const container = document.getElementById('employeeList');
        
        if (employees.length === 0) {
            container.innerHTML = '<p>No employees found.</p>';
            return;
        }

        let html = `
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Salary</th>
                        <th>Department</th>
                        <th>Hire Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
        `;

        employees.forEach(employee => {
            html += `
                <tr>
                    <td>${employee.id}</td>
                    <td>${this.escapeHtml(employee.name)}</td>
                    <td>${this.escapeHtml(employee.email)}</td>
                    <td>$${this.formatCurrency(employee.salary)}</td>
                    <td>${this.escapeHtml(employee.department_name || 'N/A')}</td>
                    <td>${employee.hire_date}</td>
                    <td class="actions">
                        <button class="btn" onclick="employeeManager.editEmployee(${employee.id})">Edit</button>
                        <button class="btn btn-danger" onclick="employeeManager.deleteEmployee(${employee.id})">Delete</button>
                    </td>
                </tr>
            `;
        });

        html += '</tbody></table>';
        container.innerHTML = html;
    }

    async handleEmployeeSubmit() {
        const form = document.getElementById('employeeForm');
        const formData = new FormData(form);
        const employeeId = document.getElementById('employeeId').value;
        
        const action = employeeId ? 'update_employee' : 'add_employee';
        formData.append('action', action);

        try {
            await this.apiCall(formData);
            
            alert('Employee added successfully!');
            const message = employeeId ? 'Employee updated successfully!' : 'Employee added successfully!';
            this.showMessage(message, 'success');
            
            this.loadEmployees();
            this.loadDashboard();
            this.resetForm();
            
            if (!employeeId) {
                showTab('employees');
            }
        } catch (error) {
            // Error already handled in apiCall
        }
    }

    async editEmployee(id) {
        try {
            const formData = new FormData();
            formData.append('action', 'get_employee');
            formData.append('id', id);
            
            const employee = await this.apiCall(formData);

            document.getElementById('employeeId').value = employee.id;
            document.getElementById('name').value = employee.name;
            document.getElementById('email').value = employee.email;
            document.getElementById('salary').value = employee.salary;
            document.getElementById('department_id').value = employee.department_id;
            document.getElementById('hire_date').value = employee.hire_date;
            
            document.getElementById('submitBtn').textContent = 'Update Employee';
            document.getElementById('formTitle').textContent = 'Edit Employee';
            showTab('addEmployee');
            alert('Employee edited successfully!');
        } catch (error) {
            // Error already handled in apiCall
        }
    }

    async deleteEmployee(id) {
        if (!confirm('Are you sure you want to delete this employee?')) {
            return;
        }

        try {
            const formData = new FormData();
            formData.append('action', 'delete_employee');
            formData.append('id', id);
            
            await this.apiCall(formData);
            
            this.showMessage('Employee deleted successfully!', 'success');
            this.loadEmployees();
            this.loadDashboard();
        } catch (error) {
            // Error already handled in apiCall
        }
    }

    resetForm() {
        document.getElementById('employeeForm').reset();
        document.getElementById('employeeId').value = '';
        document.getElementById('submitBtn').textContent = 'Add Employee';
        document.getElementById('formTitle').textContent = 'Add New Employee';
    }

    async loadDashboard() {
        await this.loadDashboardStats();
        await this.loadDepartmentRankings();
        await this.loadAboveAvgSalary();
        await this.loadHighestPaidByDept();
    }

    async loadDashboardStats() {
        try {
            const formData = new FormData();
            formData.append('action', 'get_dashboard_stats');
            
            const stats = await this.apiCall(formData);
            this.displayDashboardStats(stats);
        } catch (error) {
            // Error already handled in apiCall
        }
    }

    displayDashboardStats(stats) {
        const container = document.getElementById('statsGrid');
        
        const statsData = [
            { label: 'Total Employees', value: stats.total_employees, icon: '👥' },
            { label: 'Average Salary', value: `$${this.formatCurrency(stats.avg_salary)}`, icon: '💰' },
            { label: 'Total Salary', value: `$${this.formatCurrency(stats.total_salary)}`, icon: '📊' },
            { label: 'Active Departments', value: stats.total_departments, icon: '🏢' }
        ];

        let html = '';
        statsData.forEach(stat => {
            html += `
                <div class="stat-card">
                    <div class="stat-icon">${stat.icon}</div>
                    <h3>${stat.label}</h3>
                    <div class="value">${stat.value}</div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    async loadDepartmentRankings() {
        try {
            const formData = new FormData();
            formData.append('action', 'get_department_rankings');
            
            const rankings = await this.apiCall(formData);
            this.displayDepartmentRankings(rankings);
        } catch (error) {
            // Error already handled in apiCall
        }
    }

    displayDepartmentRankings(rankings) {
        const container = document.getElementById('departmentRankings');
        
        if (!rankings || rankings.length === 0) {
            container.innerHTML = '<p>No department data available.</p>';
            return;
        }

        let html = `
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Department</th>
                        <th>Employee Count</th>
                        <th>Average Salary</th>
                    </tr>
                </thead>
                <tbody>
        `;

        rankings.forEach(dept => {
            html += `
                <tr>
                    <td>#${dept.salary_rank}</td>
                    <td>${this.escapeHtml(dept.department_name)}</td>
                    <td>${dept.employee_count}</td>
                    <td>$${this.formatCurrency(dept.avg_salary, 2)}</td>
                </tr>
            `;
        });

        html += '</tbody></table>';
        container.innerHTML = html;
    }

    async loadAboveAvgSalary() {
        try {
            const formData = new FormData();
            formData.append('action', 'get_above_avg_salary');
            
            const employees = await this.apiCall(formData);
            this.displayAboveAvgSalary(employees);
        } catch (error) {
            // Error already handled in apiCall
        }
    }

    displayAboveAvgSalary(employees) {
        const container = document.getElementById('aboveAvgSalary');
        
        if (!employees || employees.length === 0) {
            container.innerHTML = '<p>No employees found with above average salary.</p>';
            return;
        }

        const companyAvg = employees[0]?.company_avg_salary || 0;

        let html = `<p><strong>Company Average Salary: $${this.formatCurrency(companyAvg, 2)}</strong></p>`;
        html += `
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Salary</th>
                        <th>Above Average By</th>
                    </tr>
                </thead>
                <tbody>
        `;

        employees.forEach(employee => {
            const aboveBy = employee.salary - companyAvg;
            html += `
                <tr>
                    <td>${this.escapeHtml(employee.name)}</td>
                    <td>${this.escapeHtml(employee.department_name || 'N/A')}</td>
                    <td>$${this.formatCurrency(employee.salary)}</td>
                    <td style="color: green;">+$${this.formatCurrency(aboveBy, 2)}</td>
                </tr>
            `;
        });

        html += '</tbody></table>';
        container.innerHTML = html;
    }

    async loadHighestPaidByDept() {
        try {
            const formData = new FormData();
            formData.append('action', 'get_dept_highest_paid');
            
            const employees = await this.apiCall(formData);
            this.displayHighestPaidByDept(employees);
        } catch (error) {
            // Error already handled in apiCall
        }
    }

    displayHighestPaidByDept(employees) {
        const container = document.getElementById('highestPaidByDept');
        
        if (!employees || employees.length === 0) {
            container.innerHTML = '<p>No data available.</p>';
            return;
        }

        let html = `
            <table>
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Employee Name</th>
                        <th>Salary</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
        `;

        employees.forEach(employee => {
            html += `
                <tr>
                    <td><strong>${this.escapeHtml(employee.department_name)}</strong></td>
                    <td>${this.escapeHtml(employee.name)}</td>
                    <td style="color: #e74c3c; font-weight: bold;">$${this.formatCurrency(employee.salary)}</td>
                    <td>${this.escapeHtml(employee.email)}</td>
                </tr>
            `;
        });

        html += '</tbody></table>';
        container.innerHTML = html;
    }

    // Utility functions
    formatCurrency(amount, decimals = 0) {
        return parseFloat(amount).toLocaleString(undefined, {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });
    }

    escapeHtml(unsafe) {
        if (unsafe === null || unsafe === undefined) return '';
        return unsafe
            .toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    showMessage(message, type) {
        // Remove any existing messages
        const existingAlert = document.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;

        document.querySelector('.container').insertBefore(alert, document.querySelector('.nav-tabs').nextSibling);

        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
}

// Tab navigation function
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    // Remove active class from all tabs
    document.querySelectorAll('.nav-tab').forEach(tab => {
        tab.classList.remove('active');
    });

    // Show selected tab
    document.getElementById(tabName).classList.add('active');
    
    // Add active class to clicked tab
    event.target.classList.add('active');

    // Reload data if needed
    if (tabName === 'dashboard' || tabName === 'reports') {
        employeeManager.loadDashboard();
    } else if (tabName === 'employees') {
        employeeManager.loadEmployees();
    }
}

function resetForm() {
    employeeManager.resetForm();
}

// Initialize the application
const employeeManager = new EmployeeManager();
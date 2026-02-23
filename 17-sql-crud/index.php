<?php
/**
 * Day 17: CRUD Practice
 *
 * Complete CRUD (Create, Read, Update, Delete) operations
 * combined in a single practical example
 */

// Helper function for URLs that work both via router and directly
function url($file, $params = '') {
    $base = isset($_GET['day']) ? "?day=17&file=$file" : $file;
    return $params ? ($base . (strpos($base, '?') !== false ? '&' : '?') . $params) : $base;
}

require_once __DIR__ . '/db_config.php';

// Handle form submissions
$message = '';
$messageType = '';

// CREATE - Add a new student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'create') {
        try {
            $stmt = $pdo->prepare("INSERT INTO students (name, email, age, grade, phone) VALUES (:name, :email, :age, :grade, :phone)");
            $stmt->execute([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'age' => $_POST['age'],
                'grade' => $_POST['grade'],
                'phone' => $_POST['phone']
            ]);
            $message = "Student created successfully!";
            $messageType = 'success';
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = "Error: Email already exists!";
            } else {
                $message = "Error: " . $e->getMessage();
            }
            $messageType = 'error';
        }
    }

    // UPDATE - Modify a student
    if ($_POST['action'] === 'update') {
        $stmt = $pdo->prepare("UPDATE students SET name = :name, email = :email, age = :age, grade = :grade, phone = :phone WHERE id = :id");
        $stmt->execute([
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'age' => $_POST['age'],
            'grade' => $_POST['grade'],
            'phone' => $_POST['phone']
        ]);
        $message = "Student updated successfully!";
        $messageType = 'success';
    }

    // DELETE - Remove a student
    if ($_POST['action'] === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
        $stmt->execute(['id' => $_POST['id']]);
        $message = "Student deleted successfully!";
        $messageType = 'success';
    }
}

// READ - Get all students
$stmt = $pdo->query("SELECT * FROM students ORDER BY id");
$students = $stmt->fetchAll();

// Check if editing a student
$editStudent = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
    $stmt->execute(['id' => $_GET['edit']]);
    $editStudent = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 17: CRUD Practice - Student Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #5c6bc0;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 30px;
            margin-bottom: 30px;
        }

        .card h2 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #667eea;
        }

        .message {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .form-group input {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }

        .btn-primary {
            background: #5c6bc0;
            color: white;
        }

        .btn-success {
            background: #2ecc71;
            color: white;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
            padding: 8px 15px;
            font-size: 0.85rem;
        }

        .btn-edit {
            background: #9b59b6;
            color: white;
            padding: 8px 15px;
            font-size: 0.85rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #5c6bc0;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        th:first-child {
            border-radius: 8px 0 0 0;
        }

        th:last-child {
            border-radius: 0 8px 0 0;
        }

        tr:hover {
            background: #f8f9ff;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #888;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .btn-cancel {
            background: #e0e0e0;
            color: #333;
            text-decoration: none;
            display: inline-block;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 1.8rem;
            }

            .card {
                padding: 20px;
            }

            th, td {
                padding: 10px;
                font-size: 0.9rem;
            }

            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Management System</h1>

        <?php if ($message): ?>
            <div class="message <?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Create/Edit Student Form -->
        <div class="card">
            <h2><?= $editStudent ? 'Edit Student' : 'Add New Student' ?></h2>
            <form method="POST">
                <input type="hidden" name="action" value="<?= $editStudent ? 'update' : 'create' ?>">
                <?php if ($editStudent): ?>
                    <input type="hidden" name="id" value="<?= $editStudent['id'] ?>">
                <?php endif; ?>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required placeholder="Enter name" value="<?= $editStudent ? htmlspecialchars($editStudent['name']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required placeholder="Enter email" value="<?= $editStudent ? htmlspecialchars($editStudent['email']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" required placeholder="Enter age" min="1" max="150" value="<?= $editStudent ? htmlspecialchars($editStudent['age']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="grade">Grade</label>
                        <input type="text" id="grade" name="grade" placeholder="e.g. 10th" value="<?= $editStudent ? htmlspecialchars($editStudent['grade']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" placeholder="e.g. 555-0101" value="<?= $editStudent ? htmlspecialchars($editStudent['phone'] ?? '') : '' ?>">
                    </div>
                </div>
                <button type="submit" class="btn <?= $editStudent ? 'btn-primary' : 'btn-success' ?>"><?= $editStudent ? 'Update Student' : 'Add Student' ?></button>
                <?php if ($editStudent): ?>
                    <a href="<?= url('index.php') ?>" class="btn btn-cancel">Cancel</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Students Table -->
        <div class="card">
            <h2>All Students</h2>
            <?php if (empty($students)): ?>
                <div class="empty-state">
                    <p>No students found. Add your first student above!</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Grade</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $index => $student): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($student['name']) ?></td>
                                <td><?= htmlspecialchars($student['email']) ?></td>
                                <td><?= htmlspecialchars($student['age']) ?></td>
                                <td><?= $student['grade'] ? htmlspecialchars($student['grade']) : '<span style="color:#bbb;font-style:italic;">null</span>' ?></td>
                                <td><?= $student['phone'] ? htmlspecialchars($student['phone']) : '<span style="color:#bbb;font-style:italic;">null</span>' ?></td>
                                <td class="actions">
                                    <a href="<?= url('index.php', 'edit=' . $student['id']) ?>" class="btn btn-edit">Edit</a>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $student['id'] ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>

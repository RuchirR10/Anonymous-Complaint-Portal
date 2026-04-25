<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include "db.php";

$result = $conn->query("SELECT * FROM complaints ORDER BY FIELD(priority, 'High', 'Medium', 'Low'), date DESC");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Segoe UI;
        }

        /* background gradient */

        body {
            background: linear-gradient(135deg, #67487a, #cf8364);
        }

        /* top navigation bar */

        .navbar {

            width: 100%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1), 0 0 10px rgba(103, 72, 122, 0.1);

        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-left img {
            width: 91px;
        }

        .nav-left h2 {
            color: black;
            font-weight: 600;
        }



        .logout {

            text-decoration: none;
            background: #e35616;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(227, 86, 22, 0.4);

        }

        .logout:hover {
            background: #ff4800ff;
            box-shadow: 0 6px 15px rgba(227, 86, 22, 0.6);
            transform: translateY(-2px);
        }



        .dashboard {

            width: 85%;
            margin: 60px auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2), 0 0 40px rgba(255, 255, 255, 0.2);
            transition: box-shadow 0.3s ease;

        }

        .dashboard:hover {
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25), 0 0 60px rgba(227, 86, 22, 0.2);
        }

        /* Table */

        table {

            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;

        }

        th {

            background: #67487a;
            color: white;
            padding: 12px;

        }

        td {

            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;

        }

        tr:hover {
            background: #f9f9f9;
        }

        /* Status badges */

        .pending {

            background: #e35616;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;

        }

        .resolved {

            background: green;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;

        }

        /* Buttons */

        .btn {

            padding: 6px 14px;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            font-size: 13px;
            margin: 2px;
            display: inline-block;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;

        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .view {
            background: #67487a;
            box-shadow: 0 4px 10px rgba(103, 72, 122, 0.4);
        }

        .view:hover {
            box-shadow: 0 6px 15px rgba(108, 0, 176, 0.6);
        }

        .resolve {
            background: #1bbd36;
            box-shadow: 0 4px 10px rgba(27, 189, 54, 0.4);
        }

        .resolve:hover {
            background-color: #00ad1dff;
            box-shadow: 0 6px 15px rgba(27, 189, 54, 0.6);
        }

        .delete {
            background: red;
            box-shadow: 0 4px 10px rgba(255, 0, 0, 0.4);
        }

        .delete:hover {
            box-shadow: 0 6px 15px rgba(255, 0, 0, 0.6);
        }

        /* Modal */

        .modal {

            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;

        }

        .modal-content {

            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 400px;
            text-align: center;
            position: relative;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), 0 0 30px rgba(103, 72, 122, 0.4);

        }

        .close {

            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 22px;
            cursor: pointer;

        }

        /* Search and Filter */

        .filter-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 15px;
        }

        .filter-container input,
        .filter-container select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            width: 100%;
            transition: all 0.3s;
        }

        .filter-container input:focus,
        .filter-container select:focus {
            border-color: #67487a;
            box-shadow: 0 0 10px rgba(103, 72, 122, 0.3);
        }

        .filter-container select {
            width: 250px;
        }

        .priority-select {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Form inside modal */
        #resolveForm textarea {
            width: 100%;
            height: 100px;
            margin: 15px 0;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: none;
            transition: all 0.3s;
        }

        #resolveForm textarea:focus {
            border-color: #1bbd36;
            outline: none;
            box-shadow: 0 0 10px rgba(27, 189, 54, 0.3);
        }
    </style>

</head>

<body>

    <!-- Navbar -->

    <div class="navbar">

        <div class="nav-left">

            <img src="assets/logo.png">

            <h2>Admin Dashboard</h2>

        </div>

        <a class="logout" href="logout.php">Logout</a>

    </div>


    <!-- Dashboard Table -->

    <div class="dashboard">

        <div class="filter-container">
            <input type="text" id="searchInput" onkeyup="filterTable()"
                placeholder="Search by Tracking ID or Complaint ID...">
            <select id="categoryFilter" onchange="filterTable()">
                <option value="All">All Categories</option>
                <option value="Canteen">Canteen</option>
                <option value="Faculty">Faculty</option>
                <option value="Scholarship">Scholarship</option>
                <option value="Hostel">Hostel</option>
                <option value="Infrastructure">Infrastructure</option>
                <option value="Services">Services</option>
            </select>
        </div>

        <table id="complaintsTable">

            <tr>

                <th>ID</th>
                <th>Tracking ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Complaint</th>
                <th>File</th>
                <th>Action</th>

            </tr>

            <?php

            while ($row = $result->fetch_assoc()) {

                $statusClass = strtolower($row['status']);

                echo "<tr class='complaint-row'>

<td>" . $row['id'] . "</td>

<td class='td-tracking'>" . $row['tracking_id'] . "</td>

<td>" . $row['name'] . "</td>

<td class='td-category'>" . $row['category'] . "</td>

<td><span class='$statusClass'>" . $row['status'] . "</span></td>

<td>
    <select class='priority-select' onchange=\"updatePriority(" . $row['id'] . ", this.value)\">
        <option value='Low' " . ($row['priority'] == 'Low' ? 'selected' : '') . ">Low</option>
        <option value='Medium' " . ($row['priority'] == 'Medium' ? 'selected' : '') . ">Medium</option>
        <option value='High' " . ($row['priority'] == 'High' ? 'selected' : '') . ">High</option>
    </select>
</td>

<td>

<button class='btn view'
onclick=\"showComplaint('" . htmlspecialchars($row['message']) . "')\">
View Complaint
</button>

</td>

<td>";

                if ($row['file'] != "") {
                    echo "<a class='btn view' href='uploads/" . $row['file'] . "' target='_blank'>View</a>";
                } else {
                    echo "No File";
                }

                echo "</td>

<td>";

                if ($row['status'] == 'Pending') {
                    echo "<button class='btn resolve' onclick=\"openResolveModal(" . $row['id'] . ")\">Resolve</button>";
                }

                echo "<a class='btn delete' href='delete_complaint.php?id=" . $row['id'] . "'>Delete</a>

</td>

</tr>";

            }

            ?>

        </table>

    </div>


    <!-- Complaint Modal -->

    <div id="complaintModal" class="modal">

        <div class="modal-content">

            <span class="close" onclick="closeModal()">&times;</span>

            <h3>Complaint Details</h3>

            <p id="complaintText"></p>

        </div>

    </div>

    <!-- Resolve Modal -->
    <div id="resolveModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeResolveModal()">&times;</span>
            <h3 style="color: #67487a; margin-bottom: 5px;">Resolve Complaint</h3>
            <p style="font-size: 14px; color: #555;">Add an optional remark for resolving this complaint.</p>
            <form id="resolveForm" action="update_status.php" method="POST">
                <input type="hidden" name="id" id="resolveId">
                <textarea name="remark" placeholder="Write a remark..."
                    style="font-family: inherit; font-size:14px;"></textarea>
                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="button" class="btn delete" style="flex: 1; padding: 10px;"
                        onclick="closeResolveModal()">Cancel</button>
                    <button type="submit" class="btn resolve" style="flex: 1; padding: 10px;">Resolve</button>
                </div>
            </form>
        </div>
    </div>


    <script>

        function showComplaint(message) {

            document.getElementById("complaintText").innerText = message;

            document.getElementById("complaintModal").style.display = "flex";

        }

        function closeModal() {

            document.getElementById("complaintModal").style.display = "none";

        }

        function openResolveModal(id) {
            document.getElementById("resolveId").value = id;
            document.getElementById("resolveModal").style.display = "flex";
        }

        function closeResolveModal() {
            document.getElementById("resolveModal").style.display = "none";
        }

        function updatePriority(id, priority) {
            fetch('update_priority.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id + '&priority=' + priority
            })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "success") {
                    } else {
                        alert("Failed to update priority.");
                    }
                });
        }

        function filterTable() {
            var input = document.getElementById("searchInput");
            var filter = input.value.toUpperCase();
            var categoryFilter = document.getElementById("categoryFilter").value;
            var table = document.getElementById("complaintsTable");
            var tr = table.getElementsByClassName("complaint-row");

            for (var i = 0; i < tr.length; i++) {
                var tdId = tr[i].getElementsByTagName("td")[0];
                var tdTracking = tr[i].getElementsByClassName("td-tracking")[0];
                var tdCategory = tr[i].getElementsByClassName("td-category")[0];

                if (tdId && tdTracking && tdCategory) {
                    var idValue = tdId.textContent || tdId.innerText;
                    var trackingValue = tdTracking.textContent || tdTracking.innerText;
                    var categoryValue = tdCategory.textContent || tdCategory.innerText;

                    var matchesSearch = (idValue.toUpperCase().indexOf(filter) > -1 || trackingValue.toUpperCase().indexOf(filter) > -1);
                    var matchesCategory = (categoryFilter === "All" || categoryValue === categoryFilter);

                    if (matchesSearch && matchesCategory) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

    </script>

</body>

</html>
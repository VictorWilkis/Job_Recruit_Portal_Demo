<div class="container">
    <h2 class="text-center text-dark fw-bold">My Applications</h2>
    <table class="table table-bordered table-dark">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Company</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $user_id = $_SESSION['user_id'];
            $apps = $conn->query("SELECT jobs.title, jobs.company, applications.status FROM applications JOIN jobs ON applications.job_id = jobs.id WHERE applications.user_id = $user_id");
            while ($row = $apps->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['company'] ?></td>
                    <td><?= ucfirst($row['status']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
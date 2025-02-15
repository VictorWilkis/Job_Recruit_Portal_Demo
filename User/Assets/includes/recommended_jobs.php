<div class="container mt-5">
        <h2 class="text-center mb-4 bg-white py-2 fw-bold">Recommended Jobs for You</h2>
        <div class="row">
            <?php if (!empty($recommended_jobs)): ?>
                <?php foreach ($recommended_jobs as $job): ?>
                    <div class="col-md-6 mb-4 bg-dark">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($job['title']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($job['company']); ?> - <?= htmlspecialchars($job['location']); ?></h6>
                                <p class="card-text"><?= substr(htmlspecialchars($job['description']), 0, 100); ?>...</p>
                                <a href="apply.php?job_id=<?= $job['id']; ?>" class="btn btn-success">Apply Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-white bg-dark" style="algin-self: center; max-width: 500px; margin-left: 350px;">No recommended jobs available based on your skills.</p>
            <?php endif; ?>
        </div>
</div>
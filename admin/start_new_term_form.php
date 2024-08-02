<form method="POST">
    <div class="form-group">
        <select name="academic_year_id" class="form-control" required>
            <option value="">Select Academic Year</option>
            <?php
            $stmt = $pdo->query("SELECT id, year_name FROM academic_years ORDER BY start_date DESC");
            while ($row = $stmt->fetch()) {
                echo "<option value='{$row['id']}'>{$row['year_name']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <select name="term_number" class="form-control" required>
            <option value="">Select Term</option>
            <option value="1">Term 1</option>
            <option value="2">Term 2</option>
            <option value="3">Term 3</option>
        </select>
    </div>
    <div class="form-group">
        <input type="date" name="start_date" class="form-control" required>
    </div>
    <div class="form-group">
        <input type="date" name="end_date" class="form-control" required>
    </div>
    <button type="submit" name="start_new_term" class="btn btn-primary">Start New Term</button>
</form>
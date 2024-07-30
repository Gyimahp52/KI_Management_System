<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Academic Year</th>
                <th>School</th>
                <th>Term</th>
                <th>SEL Themes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assigned_themes as $assigned): ?>
                <tr>
                    <td><?php echo htmlspecialchars($assigned['year_name']); ?></td>
                    <td><?php echo htmlspecialchars($assigned['school_name']); ?></td>
                    <td><?php echo htmlspecialchars($assigned['term_number']); ?></td>
                    <td><button class="btn btn-info btn-sm" onclick="showThemes('<?php echo htmlspecialchars($assigned['themes']); ?>')">View</button></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="school_id" value="<?php echo $assigned['school_id']; ?>">
                            <input type="hidden" name="term_id" value="<?php echo $assigned['term_id']; ?>">
                            <button type="submit" name="delete_theme" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
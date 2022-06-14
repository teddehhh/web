<?php
while ($row = $res->fetch_assoc()) : ?>
    <a class="survey-card" href="survey.php?surveyid=<?php echo $row['surveyid'] ?>">
        <div class="survey-card-intro">
            <hr>
            <span><?php echo $row['title'] ?></span>
        </div>
        <p class="survey-card-info"><?php echo $row['description'] ?></p>
    </a>
<?php
endwhile; ?>
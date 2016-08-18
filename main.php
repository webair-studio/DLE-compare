<?php
$result = $db->query("SELECT * FROM dle_static WHERE id='1'");
$row = $db->get_row($result); 
?>
			<div class="static sans">
                <h1>
                    <?php echo $row['descr']; ?>
                </h1>
                <p class="static-desc">
                    <?php echo $row['template']; ?>
                </p>
            </div>
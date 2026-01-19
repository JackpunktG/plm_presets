<?php

require __DIR__ . '/inc/header.php';
if (isset($_SESSION['edit_input']))
    require __DIR__ . '/inc/edit_lfo_flags_types.php';
else
    require __DIR__ . '/inc/input_lfo_flags_types.php';
require __DIR__ . '/inc/footer.php';

<?php
session_start();

echo "
<script>
    if (confirm('Are you sure you want to logout?')) {
        // User confirmed, proceed with logout
        " . session_unset() . "
        " . session_destroy() . "
        window.open('/Restaurantly/index.php', '_self');
    } else {
        // User canceled, stay on the same page
        window.history.back();
    }
</script>
";
?>

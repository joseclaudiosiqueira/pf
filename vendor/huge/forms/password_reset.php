<?php
include $_SERVER['DOCUMENT_ROOT'] . 'pf/conf/conf.php';
if ($login->passwordResetWasSuccessful() == true && $login->passwordResetLinkIsValid() != true) {
    include DIR_BASE . 'pf/forms/form_login.php';
} else {
    include DIR_BASE . 'pf/forms/form_password_reset.php';
}

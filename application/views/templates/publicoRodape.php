<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<script type="text/javascript" src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/vendor/jquery-ui/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('bower_components/popper.js/js/popper.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('bower_components/bootstrap/js/bootstrap.min.js') ?>"></script>

<!-- jquery slimscroll js -->
<script type="text/javascript" src="<?= base_url('bower_components/jquery-slimscroll/js/jquery.slimscroll.js') ?>"></script>

<!-- modernizr js -->
<script type="text/javascript" src="<?= base_url('bower_components/modernizr/js/modernizr.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('bower_components/modernizr/js/css-scrollbars.js') ?>"></script>

<!-- Masking js -->
<script src="<?= base_url('assets/pages/form-masking/inputmask.js') ?>"></script>
<script src="<?= base_url('assets/pages/form-masking/jquery.inputmask.js') ?>"></script>
<script src="<?= base_url('assets/pages/form-masking/autoNumeric.js') ?>"></script>
<script src="<?= base_url('assets/pages/form-masking/form-mask.js') ?>"></script>

<!-- i18next.min.js -->
<script type="text/javascript" src="<?= base_url('bower_components/i18next/js/i18next.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('bower_components/jquery-i18next/js/jquery-i18next.min.js') ?>"></script>

<?php
if (isset($js)) {
    echo "{$js}";
}
?>
</body>

</html>
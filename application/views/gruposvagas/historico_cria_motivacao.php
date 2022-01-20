<?php

defined("BASEPATH") or exit("No direct script access allowed");
	if (strlen($erro) > 0) {
		echo "
                                                            <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>"; //$erro='';
	} elseif (strlen($sucesso) > 0) {
		echo "
                                                            <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
	}


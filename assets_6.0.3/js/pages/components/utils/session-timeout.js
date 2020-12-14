"use strict";

var KTSessionTimeout = function () {

    var initDemo = function () {
        $.sessionTimeout({
            title: 'Aviso de inatividade',
            message: 'Sua sessão será encerrada automaticamente em breve.',
            keepAliveUrl: 'Interna',
            redirUrl: 'Interna/logout',
            logoutUrl: 'Interna/logout',
            warnAfter: 1008000, //warn after 28 minutes 1008000
            redirAfter: 1044000, //redirect after 29 minutes 1044000
            ignoreUserActivity: true,
            countdownMessage: 'Fechando em {timer}',
            countdownBar: true,
            keepAliveButton: 'Ficar conectado',
            logoutButton: 'Sair'
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            initDemo();
        }
    };

}();

jQuery(document).ready(function() {    
    KTSessionTimeout.init();
});
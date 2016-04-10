$(function () {

    var optionsPwstrength = {};
    optionsPwstrength.common = {
        minChar: 8,
        onKeyUp: function (evt, data) {
            if (!$(evt.target).is(":focus")) {
                if (data.verdictLevel != 4) {

                    $(evt.target).val('');
                    $(evt.target).pwstrength("forceUpdate");
                }
            }
        }
    };
    optionsPwstrength.ui = {
        showStatus: true,
        verdicts: ["fraca", "fraca", "media", "media", "forte"],
        showVerdicts: true,
        showVerdictsInsideProgressBar: true
    };
    optionsPwstrength.rules = {
        activated: {
            wordThreeNumbers: false,
            wordSequences: false
        }
    };
    var pwstrength = $('#pw_nova_senha').pwstrength(optionsPwstrength);
});
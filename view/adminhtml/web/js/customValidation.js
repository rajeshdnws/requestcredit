require([
        'jquery',
        'mage/translate',
        'jquery/validate'],
    function($){
        $.validator.addMethod(
            'validate-comma-separated-emails', function (emaillist) {
                emaillist = emaillist.trim();
                if (emaillist.charAt(0) == ',' || emaillist.charAt(emaillist.length - 1) == ',') {
                    return false;
                }
                var emails = emaillist.split(',');
                var invalidEmails = [];
                var i;
                for (i = 0; i < emails.length; i++) {
                    var email = emails[i].trim();
                    if (email.length == 0) {
                        return false
                    } else {
                        if (!Validation.get('validate-email').test(email)) {
                            invalidEmails.push(email);
                        }
                    }
                }
                if (invalidEmails.length) {
                    return false;
                }
                return true;
            },
            $.mage.__('One or more admin email has an invalid email form, xample: john@gmail.com.'));
    }
);

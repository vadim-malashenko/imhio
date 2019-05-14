<?php

namespace Imhio\Api\Resources;

class Email {

    const MISSING_REQUIRED_FIELD = 'EMAIL_REQUIRED';
    const INVALID_VALUE = 'EMAIL_BAD';

    public static function check (\Imhio\Http\Request $request) {

        $result = [];
        $email = static::required_field_value ($request);

        if ($email === null)
            $result ['err'] = Email::MISSING_REQUIRED_FIELD;

        else if (static::is_value_bad ($email))
            $result ['err'] = Email::INVALID_VALUE;

        else
            $result ['validation'] = static::validate ($email);

        return $result;
    }

    protected static function required_field_value ($request) {

        return isset ($request->post ['email']) ? $request->post ['email'] : null;
    }

    protected static function is_value_bad ($value) {

        $email = filter_var ($value, FILTER_SANITIZE_EMAIL);
        $email_length = strlen ($email);
        $email_parts = explode ('@', $email);
        $result = true;

        if ($email_length >= 5 and $email_length <= 320 and count ($email_parts) == 2) {

            $name_length = strlen ($email_parts [0]);
            $domain_length = strlen ($email_parts [1]);

            $result = $name_length > 64 or $name_length < 1 or $domain_length > 255 or $domain_length < 3;
        }

        return $result;
    }

    protected static function validate ($email) {

        return filter_var ($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
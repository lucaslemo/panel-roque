<?php

if (! function_exists('formatPhone')) {
    function formatPhone(string $value): string
    {
        $CELL_PHONE_LENGTH = 11;
        $phone = preg_replace('/[\s\(\)-]/', '', $value);

        if (strlen($phone) === $CELL_PHONE_LENGTH) {
            return preg_replace("/(\d{2})(\d{5})(\d{4})/", "(\$1) \$2-\$3", $phone);
        }

        return preg_replace("/(\d{2})(\d{4})(\d{4})/", "(\$1) \$2-\$3", $phone);
    }
}

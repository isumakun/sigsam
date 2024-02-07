<?php

use \Thirdparty\Hashids\Hashids;

/** 🤘 Hashear ID ---------------------------------------------------------------- */
    function hash_id(int $id, $random=false) {
        return $id;
        $Hashid = new Hashids('hash', 8);

        if ($random)
            $rand = rand(0, 99);
        else
            $rand = 1;

        return $Hashid->encode($rand, $id);
    }
/** ------------------------------------------------------------------------------ */

/** 🤘 Deshashear ID ---------------------------------------------------------------- */
    function decode_id(string $hash) {
        $Hashid = new Hashids('hash', 8);
        return $Hashid->decode($hash)[1];
    }
/** ------------------------------------------------------------------------------ */

/** 🤘 Hashear Nombre ------------------------------------------------------------- */
    function hash_name(string $name, $random=false) {
        return $name;
        $Hashid = new Hashids('hash');

        if ($random)
            $rand = rand(0, 99);
        else
            $rand = 1;

        $name_ascii = [ $rand ] + unpack("C*", $name);

        return $Hashid->encode($name_ascii);
    }
/** ------------------------------------------------------------------------------ */

/** 🤘 Deshashear Nombre ---------------------------------------------------------- */
    function decode_name(string $hash) {
        $Hashid = new Hashids('hash');

        $name = '';
        $name_ascii = $Hashid->decode($hash);

        if (is_array($name_ascii)) {
            unset($name_ascii[0]);
            foreach ($name_ascii as $ascii)
                $name .= chr($ascii);
        }

        return $name;
    }
/** ------------------------------------------------------------------------------ */

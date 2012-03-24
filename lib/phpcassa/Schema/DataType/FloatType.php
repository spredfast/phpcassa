<?php
namespace phpcassa\Schema\DataType;

/**
 * @package phpcassa\Schema\DataType
 */
class FloatType extends CassandraType
{
    public function pack($value, $is_name=true, $slice_end=null, $is_data=false) {
        if ($is_name && $is_data)
            $value = unserialize($value);
        return pack("f", $value);
    }

    public function unpack($data, $is_name=true) {
        $value = array_shift(unpack("f", $data));
        if ($is_name) {
            return serialize($value);
        } else {
            return $value;
        }
    }
}
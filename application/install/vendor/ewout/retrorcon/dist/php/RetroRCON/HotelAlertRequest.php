<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: protos/rcon.proto

namespace RetroRCON;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>RetroRCON.HotelAlertRequest</code>
 */
class HotelAlertRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string alert = 1;</code>
     */
    private $alert = '';

    public function __construct() {
        \GPBMetadata\Protos\Rcon::initOnce();
        parent::__construct();
    }

    /**
     * Generated from protobuf field <code>string alert = 1;</code>
     * @return string
     */
    public function getAlert()
    {
        return $this->alert;
    }

    /**
     * Generated from protobuf field <code>string alert = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setAlert($var)
    {
        GPBUtil::checkString($var, True);
        $this->alert = $var;

        return $this;
    }

}


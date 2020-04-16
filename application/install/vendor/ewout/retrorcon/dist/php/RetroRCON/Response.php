<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: protos/rcon.proto

namespace RetroRCON;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>RetroRCON.Response</code>
 */
class Response extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>bool ok = 1;</code>
     */
    private $ok = false;
    /**
     * Generated from protobuf field <code>string error = 2;</code>
     */
    private $error = '';

    public function __construct() {
        \GPBMetadata\Protos\Rcon::initOnce();
        parent::__construct();
    }

    /**
     * Generated from protobuf field <code>bool ok = 1;</code>
     * @return bool
     */
    public function getOk()
    {
        return $this->ok;
    }

    /**
     * Generated from protobuf field <code>bool ok = 1;</code>
     * @param bool $var
     * @return $this
     */
    public function setOk($var)
    {
        GPBUtil::checkBool($var);
        $this->ok = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string error = 2;</code>
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Generated from protobuf field <code>string error = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setError($var)
    {
        GPBUtil::checkString($var, True);
        $this->error = $var;

        return $this;
    }

}


<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: protos/rcon.proto

namespace RetroRCON;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>RetroRCON.RefreshAppearanceRequest</code>
 */
class RefreshAppearanceRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>uint32 user_id = 1;</code>
     */
    private $user_id = 0;

    public function __construct() {
        \GPBMetadata\Protos\Rcon::initOnce();
        parent::__construct();
    }

    /**
     * Generated from protobuf field <code>uint32 user_id = 1;</code>
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Generated from protobuf field <code>uint32 user_id = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setUserId($var)
    {
        GPBUtil::checkUint32($var);
        $this->user_id = $var;

        return $this;
    }

}


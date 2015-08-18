<?php
namespace WowzaRestApi;

class WowzaApplication
{
    const APP_TYPE_LIVE = 'live';
    const APP_TYPE_VOD = 'vod';
    const APP_TYPE_DVR = 'dvr';

    public $name;
    public $appType;
    public $dvrEnabled;
    public $drmEnabled;
    public $transcoderEnabled;
    public $streamTargetsEnabled;

    public function __construct($object = null)
    {
        if (!is_null($object) && is_object($object)) {
            $this->name = $object->id;
            $this->appType = strtolower($object->appType);
            $this->dvrEnabled = $object->dvrEnabled;
            $this->drmEnabled = $object->drmEnabled;
            $this->transcoderEnabled = $object->transcoderEnabled;
            $this->streamTargetsEnabled = $object->streamTargetsEnabled;
        }
    }
}

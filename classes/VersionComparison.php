<?php

class VersionComparison
{

    public $priorVersion = "1.0.17+60";

    public $currentVersion;

    public function __construct($currentVersion)
    {

        $this->currentVersion = $currentVersion;
    }

    public function isBerlin()
    {
        if ($this->currentVersion >= $this->priorVersion) {
            return "UTC";
        } else {
            return "Europe/Berlin";
        }
    }
}

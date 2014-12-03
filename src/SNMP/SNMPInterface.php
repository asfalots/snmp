<?php
/**
 * Created by PhpStorm.
 * User: erwan
 * Date: 3/12/14
 * Time: 14:52
 */
namespace SNMP;

interface SNMPInterface{

    public function __construct($version, $hostname, $community, $timeout, $retries);
    public function get( $mib);
    public function set($mib, $type, $value);
    public function walk($mib);
    public function getLastRequest();
    public function getLastResponse();
}
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
    public function get($object_id, $preserve_keys=false);
    public function set($object_id, $type, $value);
    public function walk($object_id, $suffixe_as_key=false, $max_repetitions=null, $non_repeaters=null);
    public function close();
    public function setSecurity ($sec_level, $auth_protocol , $auth_passphrase , $priv_protocol, $priv_passphrase, $contextName, $contextEngineID );
    public function getLastRequest();
    public function getLastResponse();
    public function getErrno();
    public function getnext($object_id);
}
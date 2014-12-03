<?php
/**
 * Created by PhpStorm.
 * User: erwan
 * Date: 3/12/14
 * Time: 15:00
 */

namespace SNMP;


class Shell implements SNMPInterface{
    protected $_options=array();
    protected $_lastRequest;
    protected $_lastResponse;
    protected $_host;

    public function __construct($version, $hostname, $community, $timeout = 10000, $retries=1){
        $this->_options = array('c' => $community, 'v' => $version);
        $this->_host = $hostname;
    }

    protected function getOptionsAsString(){
        $output = '';
        foreach($this->_options as $key => $value){
            $output .= "-$key $value ";
        }
        return $output;
    }

    /**
     * @param array $options    Shell options as defined in man
     * @return \SNMP\Shell
     */
    public function setOption(array $options){
        $this->_options = array_merge($this->_options, $options);
        return $this;
    }

    public function get($mib){
        $output = $this->exec('snmpget',$mib);
        return $output[0];
    }

    protected function exec($bin, $mib, $type=null, $value=null){
        $this->_lastRequest = '/usr/bin/'.$bin.' '.$this->getOptionsAsString().' ' . $this->_host . ' ' . $mib . ' '.$type . ' ' . $value;
        exec($this->_lastRequest, $output, $return);
        if($return > 0){
            throw new RuntimeException(implode($output, "\n"));
        }
        $this->_lastResponse = $output;
        return $output;
    }

    public function getLastRequest(){
        return $this->_lastRequest;
    }

    public function getLastResponse(){
        return $this->_lastResponse;
    }

    public function walk($mib){
        return $this->exec('snmpwalk', $mib);
    }

    public function set($mib, $type, $value){

    }
} 
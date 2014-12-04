<?php
/**
 * Created by PhpStorm.
 * User: erwan
 * Date: 3/12/14
 * Time: 15:00
 */

namespace SNMP;


class SNMP implements SNMPInterface{

    const VERSION_1 = 1 ;
    const VERSION_2C = "2c" ;
    const VERSION_3 = 3 ;

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
     * @return \SNMP\SNMP
     */
    public function setOption(array $options){
        $this->_options = array_merge($this->_options, $options);
        return $this;
    }

    public function get($mib, $preserve_key=false){

        $output = $this->exec('snmpget',$mib);
        return $output[0];
    }

    protected function exec($bin, $mib, $type=null, $value=null){
        $this->_lastRequest = '/usr/bin/'.$bin.' '.$this->getOptionsAsString().' ' . $this->_host . ' ' . $mib . ' '.$type . ' ' . $value;
        exec($this->_lastRequest, $output, $return);
        if($return > 0){
            throw new \RuntimeException(implode($output, "\n"));
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

    public function walk($mib, $suffixe_as_key=false, $max_repetitions=null, $non_repeaters=null){
        return $this->exec('snmpwalk', $mib);
    }

    public function set($mib, $type, $value){

    }

    public function close()
    {
        return true;
    }

    public function setSecurity($sec_level, $auth_protocol, $auth_passphrase, $priv_protocol, $priv_passphrase, $contextName, $contextEngineID)
    {
        // TODO: Implement setSecurity() method.
    }

    public function getErrno()
    {
        // TODO: Implement getErrno() method.
    }

    public function getnext($object_id)
    {
        // TODO: Implement getnext() method.
    }
}
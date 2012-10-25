<?php
namespace Benchmark;

class Unit {
    private $start   = null;
    private $end     = null;
    private $times   = null;
    private $rusage  = false;
    private $benchmarks = null;

    public function __construct($rusage = false) {
        if($this->rusage = $rusage) {
            $rusage = getrusage();
            $this->start =
                array(
                    'utime_s'  => $rusage['ru_utime.tv_sec'],
                    'utime_us' => $rusage['ru_utime.tv_usec'],
                    'stime_s'  => $rusage['ru_stime.tv_sec'],
                    'stime_us' => $rusage['ru_stime.tv_usec'],
                    'real'     => microtime(true)
                );
        } else {
            $start = array('real' => microtime(true));
        }
    }

    public function stop() {
        $stop = array('real' => microtime(true));
        if($this->rusage) {
            $rusage = getrusage();
            $this->stop['utime_s']  = $rusage['ru_utime.tv_sec'];
            $this->stop['utime_us'] = $rusage['ru_utime.tv_usec'];
            $this->stop['stime_s']  = $rusage['ru_stime.tv_sec'];
            $this->stop['stime_us'] = $rusage['ru_stime.tv_usec'];
        }
    }

    public function time() {
        if(is_null($this->stop)) throw new Exception("Tried to calculate times without stopping the unit");
        if(is_null($this->times)) {
            $this->times = array('real' => ($this->stop['real'] - $this->start['real']));
            if($this->rusage) {
                $this->times['user']   = ($this->stop['utime_s']  + ($this->stop['utime_us']/1e6)) -
                                         ($this->start['utime_s'] + ($this->start['utime_us']/1e6));
                $this->times['system'] = ($this->stop['stime_s'] + ($this->stop['stime_us']/1e6)) -
                                         ($this->start['stime_s'] + ($this->start['stime_us']/1e6));
            }
        }
        return $this->times;
    }
}
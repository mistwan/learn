<?php

namespace app\index\Job;


use think\queue\Job;

class MultiTask
{
    public function taskA(Job $job,$data){

        $isJobDone = $this->_doTaskA($data);

        if ($isJobDone) {
            $job->delete();
            print("Info: TaskA of Job MultiTask has been done and deleted"."\n");
        }elseif( $isJobDone === false){
            $job->release();
        }else{
            if ($job->attempts() > 3) {
                $job->delete();
            }
        }
    }

    public function taskB(Job $job,$data){

        $isJobDone = $this->_doTaskA($data);

        if ($isJobDone) {
            $job->delete();
            print("Info: TaskB of Job MultiTask has been done and deleted"."\n");
        }else{
            if ($job->attempts() > 2) {
                $job->release();
            }
        }
    }

    private function _doTaskA($data) {
        print("Info: doing TaskA of Job MultiTask "."\n");
        return true;
    }

    private function _doTaskB($data) {
        print("Info: doing TaskB of Job MultiTask "."\n");
        return true;
    }
}
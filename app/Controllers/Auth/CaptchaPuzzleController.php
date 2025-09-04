<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class CaptchaPuzzleController extends BaseController
{
    public function generate()
    {
        $step = (int) ($this->request->getGet('step') ?? 1);
        $target = rand(40, 220);
        session()->set('puzzle_target_'.$step, $target);
        return $this->response->setJSON(['status'=>'ok','target'=>$target,'step'=>$step]);
    }

    public function verify()
    {
        $step = (int) $this->request->getPost('step');
        $pos = (int) $this->request->getPost('posX');
        $target = session()->get('puzzle_target_'.$step);
        if ($target === null) return $this->response->setJSON(['status'=>'error','message'=>'Expired']);
        if (abs($pos - $target) <= 6) {
            session()->set('puzzle_step_'.$step, true);
            if (session()->get('puzzle_step_1') && session()->get('puzzle_step_2') && session()->get('puzzle_step_3')) {
                session()->set('puzzle_ok', true);
            }
            return $this->response->setJSON(['status'=>'ok']);
        }
        session()->remove('puzzle_step_'.$step);
        return $this->response->setJSON(['status'=>'error','message'=>'Incorrect position']);
    }
}

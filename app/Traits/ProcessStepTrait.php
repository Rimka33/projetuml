<?php

namespace App\Traits;

trait ProcessStepTrait
{
    protected function setProcessStep($status)
    {
        switch ($status) {
            case 'pending':
                session(['current_step' => 'saisie']);
                session(['status' => null]);
                break;
            case 'rejected_by_rf':
                session(['current_step' => 'verification']);
                session(['status' => 'rejected_by_rf']);
                break;
            case 'approved_by_rf':
                session(['current_step' => 'validation']);
                session(['status' => null]);
                break;
            case 'rejected_by_chef':
                session(['current_step' => 'validation']);
                session(['status' => 'rejected_by_chef']);
                break;
            case 'validated_by_chef':
                session(['current_step' => 'consolidation']);
                session(['status' => null]);
                break;
            default:
                session(['current_step' => null]);
                session(['status' => null]);
        }
    }
}

<?php


namespace KaqazStudio\LaravelMobileAuth\traits;


trait HasMobileAuth
{
    public function initializeHasMobileAuth()
    {
        $this->fillable[] = 'phone';
        $this->fillable[] = 'attempts_left';
        $this->fillable[] = 'most_login_with_otp';
    }
}

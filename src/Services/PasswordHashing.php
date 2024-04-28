<?php

class PasswordHashing
{
    public function hashPassword($password)
    {
        return hash('sha256', $password);
    }
    
    public function verifyPassword($password, $hashedPassword)
    {
        $hashedInput = $this->hashPassword($password);
        return hash_equals($hashedInput, $hashedPassword);
    }
}

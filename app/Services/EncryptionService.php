<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;

class EncryptionService
{
    /**
     * 加密專案ID
     */
    public static function encryptProjectId($projectId)
    {
        return Crypt::encryptString($projectId);
    }

    /**
     * 解密專案ID
     */
    public static function decryptProjectId($encryptedId)
    {
        try {
            return Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            return null;
        }
    }
} 
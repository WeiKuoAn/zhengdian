<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\EncryptionService;

class DecryptProjectId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 檢查是否有加密的ID參數
        $encryptedId = $request->route('encrypted_id') ?? $request->route('id');
        
        if ($encryptedId) {
            // 嘗試解密ID
            $decryptedId = EncryptionService::decryptProjectId($encryptedId);
            
            if ($decryptedId) {
                // 將解密後的ID放入請求中
                $request->merge(['project_id' => $decryptedId]);
                
                // 更新路由參數
                $request->route()->setParameter('id', $decryptedId);
            }
        }

        return $next($request);
    }
} 
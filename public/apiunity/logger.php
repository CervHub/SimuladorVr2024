<?php

function apiUnityLog(string $endpoint, string $type, string $message, $data = null): void
{
    $logFile = __DIR__ . '/error.log';
    $payload = $data !== null ? ' | ' . json_encode($data, JSON_UNESCAPED_UNICODE) : '';
    $logLine = '[' . date('Y-m-d H:i:s') . "] [$endpoint] [$type] $message$payload\n";
    error_log($logLine, 3, $logFile);
}

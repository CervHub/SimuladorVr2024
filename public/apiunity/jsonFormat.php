<?php

function detectInsertNotaJsonFormat(array $jsonData): string
{
    if (empty($jsonData)) {
        return 'unknown';
    }

    $first = reset($jsonData);
    if (!is_array($first)) {
        return 'unknown';
    }

    if (isset($first['question_id']) && isset($first['statement'])) {
        return 'quiz';
    }

    if (isset($first['case'])) {
        return 'legacy';
    }

    return 'unknown';
}

function buildQuizStorageJson(array $questions): string
{
    return json_encode([
        'format' => 'quiz',
        'questions' => array_values($questions),
    ], JSON_UNESCAPED_UNICODE);
}

function countQuizErrors(array $questions): int
{
    $errors = 0;
    foreach ($questions as $question) {
        if (empty($question['is_correct'])) {
            $errors++;
        }
    }

    return $errors;
}

function countQuizCorrect(array $questions): int
{
    $correct = 0;
    foreach ($questions as $question) {
        if (!empty($question['is_correct'])) {
            $correct++;
        }
    }

    return $correct;
}

function normalizeLegacyItem(array $item): array
{
    return [
        'case' => $item['case'] ?? '',
        'identified' => $item['identified'] ?? '0',
        'risk_level' => $item['risk_level'] ?? '0',
        'correct_measure' => $item['correct_measure'] ?? '0',
        'time' => $item['time'] ?? '0:0',
        'difficulty' => $item['difficulty'] ?? '',
        'num_errors' => $item['num_errors'] ?? '0',
        'json_payload' => isset($item['json']) ? $item['json'] : $item,
    ];
}

function isQuizStorageJson($json): bool
{
    if (is_string($json)) {
        $json = json_decode($json, true);
    }

    if (!is_array($json)) {
        return false;
    }

    if (($json['format'] ?? null) === 'quiz' && isset($json['questions'])) {
        return true;
    }

    return isset($json['questions']) && is_array($json['questions'])
        && !empty($json['questions'])
        && isset($json['questions'][0]['question_id']);
}

function extractQuizQuestions($json): array
{
    if (is_string($json)) {
        $json = json_decode($json, true);
    }

    if (!is_array($json)) {
        return [];
    }

    if (isset($json['questions']) && is_array($json['questions'])) {
        return $json['questions'];
    }

    if (isset($json['question_id'])) {
        return [$json];
    }

    return [];
}

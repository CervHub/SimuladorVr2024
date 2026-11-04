<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInductionWorker extends Model
{
    use HasFactory;

    protected $table = 'detail_induction_workers';

    protected $fillable = [
        'induction_worker_id',
        'case',
        'note',
        'note_reference',
        'report',
        'json',
        'start_date',
        'end_date',
        'entrenamiento',
        'rol',
        'identified',
        'risk_level',
        'correct_measure',
        'time',
        'difficulty',
        'num_errors',
    ];

    protected $casts = [
        'json' => 'array',
    ];

    public function induction_worker()
    {
        return $this->belongsTo(InductionWorker::class, 'id');
    }

    /**
     * Puntuación de un detalle según campos con valor (para elegir entre duplicados).
     */
    public static function dataScore(self $detail): float
    {
        return floatval($detail->identified)
            + floatval($detail->risk_level)
            + floatval($detail->correct_measure);
    }

    /**
     * Si el mismo nombre de caso aparece más de una vez, conserva el registro con datos.
     */
    public static function deduplicateByCaseName($collection)
    {
        return $collection
            ->groupBy(fn ($detail) => trim(mb_strtolower($detail->case ?? '')))
            ->map(function ($group) {
                return $group->sortByDesc(fn ($detail) => [self::dataScore($detail), $detail->id])->first();
            })
            ->sortBy('id')
            ->values();
    }

    public static function isQuizJson($json): bool
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

    public static function extractQuizQuestions($json): array
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

    public static function countQuizCorrect(array $questions): int
    {
        $correct = 0;
        foreach ($questions as $question) {
            if (self::quizAnswerIsCorrect($question['is_correct'] ?? false)) {
                $correct++;
            }
        }

        return $correct;
    }

    public static function countQuizErrors(array $questions): int
    {
        return count($questions) - self::countQuizCorrect($questions);
    }

    public static function quizAnswerIsCorrect($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (int) $value === 1;
        }

        if (is_string($value)) {
            return in_array(strtolower(trim($value)), ['1', 'true', 'yes', 'si', 'sí'], true);
        }

        return false;
    }

    public static function buildQuizStorageArray(array $questions): array
    {
        return [
            'format' => 'quiz',
            'questions' => array_values($questions),
        ];
    }
}

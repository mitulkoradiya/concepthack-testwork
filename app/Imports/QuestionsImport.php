<?php

namespace App\Imports;

use App\Models\Exam;
use App\Models\Question;
use App\Rules\RequiredAny2;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use phpDocumentor\Reflection\Types\Nullable;


class QuestionsImport implements ToModel, WithValidation, WithHeadingRow, SkipsOnFailure, SkipsEmptyRows
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        $exam = Exam::firstOrCreate([
            'name' => $row['username']
        ]);

        return new Question([
            'exam_id' => $exam->id ?? null,
            'question' => $row['question'],
            'option1' => $row['option1'],
            'option2' => $row['option2'] ?? null,
            'option3' => $row['option3'] ?? null,
            'option4' => $row['option4'] ?? null,
            'answer' => $row['answer'],
        ]);
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'question' => ['required', 'string', 'unique:questions,question'],
            'option1' => [new RequiredAny2('option2,option3,option4')],
            'option2' => [],
            'option3' => [],
            'option4' => [],
            'answer' => ['required','string', 'in:option1,option2,option3,option4']
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Test;

use App\Models\Answer;
use App\Models\TestSession;
use App\Services\TestGeneratorService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Practice Test')]
class PracticeTest extends Component
{
    #[Validate('required|exists:answers,id')]
    public ?int $selectedAnswer = null;

    #[Locked]
    public int $currentIndex = 0;

    #[Locked]
    public int $totalQuestions = 20;

    /** @var Collection<int, \App\Models\Question> */
    #[Locked]
    public Collection $questions;

    /** @var array<int, array{question_id: int, answer_id: int, category_id: int, is_correct: bool}> */
    #[Locked]
    public array $responses = [];

    public function mount(): void
    {
        $this->questions = TestGeneratorService::generate($this->totalQuestions);
        $this->totalQuestions = $this->questions->count();
    }

    public function submitAnswer(): void
    {
        $this->validate();

        $question = $this->questions[$this->currentIndex] ?? null;
        $answer = Answer::query()->find($this->selectedAnswer);

        if ($question === null || $answer === null) {
            return;
        }

        $this->responses[] = [
            'question_id' => $question->id,
            'answer_id' => $answer->id,
            'category_id' => $question->category_id,
            'is_correct' => $answer->is_correct,
        ];

        $this->selectedAnswer = null;
        $this->currentIndex++;

        if ($this->currentIndex >= $this->totalQuestions) {
            $this->saveSession();
            $this->redirect(route('test.result'));
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.test.practice-test');
    }

    private function saveSession(): void
    {
        $score = collect($this->responses)->filter(fn (array $r) => $r['is_correct'])->count();
        $passed = $score >= 15;

        $session = TestSession::query()->create([
            'user_id' => auth()->id(),
            'session_token' => auth()->check() ? null : Str::uuid()->toString(),
            'started_at' => now()->subMinutes(5),
            'completed_at' => now(),
            'score' => $score,
            'total_questions' => $this->totalQuestions,
            'passed' => $passed,
        ]);

        foreach ($this->responses as $response) {
            $session->responses()->create([
                'question_id' => $response['question_id'],
                'answer_id' => $response['answer_id'],
                'is_correct' => $response['is_correct'],
            ]);
        }

        session(['last_test_session_id' => $session->id]);
    }
}

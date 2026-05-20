# Report a Concern / Correction Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Let users flag questions or answers as wrong, unclear, or typo-ridden from within the practice test and flashcard UIs; give admins a Filament resource to triage and resolve these reports.

**Architecture:** A `QuestionReport` model stores each flag (type, optional description, status). A small embeddable Livewire component (`ReportConcern`) renders a toggle + inline form on any view that shows a question. Admins manage reports via a Filament resource with status-change table actions and a view page with an infolist.

**Tech Stack:** PHP 8.4, Laravel 13, Livewire 4, Alpine.js, Filament v5, Tailwind CSS v4, Pest v4

---

## File Map

| Action | Path | Purpose |
|--------|------|---------|
| Create | `app/Enums/ReportType.php` | Backed enum: wrong answer, typo, unclear, other |
| Create | `app/Enums/ReportStatus.php` | Backed enum: pending, reviewed, resolved |
| Create | `database/migrations/2026_05_19_000000_create_question_reports_table.php` | DB schema |
| Create | `app/Models/QuestionReport.php` | Eloquent model with casts + relationships |
| Modify | `app/Models/Question.php` | Add `reports()` HasMany |
| Create | `database/factories/QuestionReportFactory.php` | Factory with `resolved()` state |
| Create | `app/Livewire/ReportConcern.php` | Embeddable report form component |
| Create | `resources/views/livewire/report-concern.blade.php` | Alpine toggle + inline form |
| Modify | `resources/views/livewire/test/practice-test.blade.php` | Embed component per question |
| Modify | `resources/views/livewire/study/flash-card.blade.php` | Embed component per card |
| Create | `app/Filament/Resources/QuestionReportResource.php` | Admin resource |
| Create | `app/Filament/Resources/QuestionReportResource/Pages/ListQuestionReports.php` | Table with status actions |
| Create | `app/Filament/Resources/QuestionReportResource/Pages/ViewQuestionReport.php` | Infolist view page |
| Create | `tests/Feature/Models/QuestionReportTest.php` | Model relationship + cast tests |
| Create | `tests/Feature/Livewire/ReportConcernTest.php` | Submit, validate, close tests |
| Create | `tests/Feature/Filament/QuestionReportResourceTest.php` | List, view, status action tests |

---

## Task 1: Create Enums

**Files:**
- Create: `app/Enums/ReportType.php`
- Create: `app/Enums/ReportStatus.php`

- [ ] **Step 1: Generate ReportType enum**

```bash
php artisan make:enum Enums/ReportType --string --no-interaction
```

- [ ] **Step 2: Fill in ReportType cases and label helper**

Replace the generated `app/Enums/ReportType.php` with:

```php
<?php

declare(strict_types=1);

namespace App\Enums;

enum ReportType: string
{
    case WrongAnswer = 'wrong_answer';
    case Typo = 'typo';
    case UnclearQuestion = 'unclear_question';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::WrongAnswer => 'Wrong Answer',
            self::Typo => 'Typo or Spelling Error',
            self::UnclearQuestion => 'Unclear Question',
            self::Other => 'Other',
        };
    }
}
```

- [ ] **Step 3: Generate ReportStatus enum**

```bash
php artisan make:enum Enums/ReportStatus --string --no-interaction
```

- [ ] **Step 4: Fill in ReportStatus cases**

Replace `app/Enums/ReportStatus.php` with:

```php
<?php

declare(strict_types=1);

namespace App\Enums;

enum ReportStatus: string
{
    case Pending = 'pending';
    case Reviewed = 'reviewed';
    case Resolved = 'resolved';
}
```

- [ ] **Step 5: Format**

```bash
vendor/bin/pint app/Enums/ --format agent
```

- [ ] **Step 6: Commit**

```bash
git add app/Enums/ReportType.php app/Enums/ReportStatus.php
git commit -m "feat: add ReportType and ReportStatus enums"
```

---

## Task 2: Migration

**Files:**
- Create: `database/migrations/..._create_question_reports_table.php`

- [ ] **Step 1: Generate migration**

```bash
php artisan make:migration create_question_reports_table --no-interaction
```

- [ ] **Step 2: Fill in migration schema**

Open the generated file and replace the `up()` method body:

```php
Schema::create('question_reports', function (Blueprint $table) {
    $table->id();
    $table->foreignId('question_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->string('report_type');
    $table->text('description')->nullable();
    $table->string('status')->default('pending');
    $table->timestamp('resolved_at')->nullable();
    $table->timestamps();
});
```

And the `down()` method:

```php
Schema::dropIfExists('question_reports');
```

- [ ] **Step 3: Run migration**

```bash
php artisan migrate --no-interaction
```

Expected output: `... question_reports ..... 0ms DONE`

- [ ] **Step 4: Commit**

```bash
git add database/migrations/
git commit -m "feat: add question_reports table migration"
```

---

## Task 3: Model + Factory

**Files:**
- Create: `app/Models/QuestionReport.php`
- Modify: `app/Models/Question.php`
- Create: `database/factories/QuestionReportFactory.php`

- [ ] **Step 1: Generate the model**

```bash
php artisan make:model QuestionReport --factory --no-interaction
```

- [ ] **Step 2: Write the model**

Replace `app/Models/QuestionReport.php` with:

```php
<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use Database\Factories\QuestionReportFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['question_id', 'user_id', 'report_type', 'description', 'status', 'resolved_at'])]
class QuestionReport extends Model
{
    /** @use HasFactory<QuestionReportFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'report_type' => ReportType::class,
            'status' => ReportStatus::class,
            'resolved_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<Question, $this> */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

- [ ] **Step 3: Add `reports()` relationship to Question**

In `app/Models/Question.php`, add the import and method after the `answers()` relation:

```php
use Illuminate\Database\Eloquent\Relations\HasMany;
// (HasMany is already imported — just add QuestionReport import)
use App\Models\QuestionReport;

/** @return HasMany<QuestionReport, $this> */
public function reports(): HasMany
{
    return $this->hasMany(QuestionReport::class);
}
```

The full updated `app/Models/Question.php` should look like:

```php
<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\QuestionBuilder;
use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UseEloquentBuilder(QuestionBuilder::class)]
#[Fillable(['category_id', 'question_text', 'image_path', 'difficulty', 'is_active'])]
class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    /** @return BelongsTo<Category, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** @return HasMany<Answer, $this> */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /** @return HasMany<QuestionReport, $this> */
    public function reports(): HasMany
    {
        return $this->hasMany(QuestionReport::class);
    }
}
```

- [ ] **Step 4: Write the factory**

Replace `database/factories/QuestionReportFactory.php` with:

```php
<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuestionReport>
 */
class QuestionReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'user_id' => null,
            'report_type' => fake()->randomElement(['wrong_answer', 'typo', 'unclear_question', 'other']),
            'description' => fake()->optional()->sentence(),
            'status' => 'pending',
            'resolved_at' => null,
        ];
    }

    public function resolved(): static
    {
        return $this->state([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);
    }
}
```

- [ ] **Step 5: Format**

```bash
vendor/bin/pint app/Models/QuestionReport.php app/Models/Question.php database/factories/QuestionReportFactory.php --format agent
```

- [ ] **Step 6: Commit**

```bash
git add app/Models/QuestionReport.php app/Models/Question.php database/factories/QuestionReportFactory.php
git commit -m "feat: add QuestionReport model, factory, and Question reports() relation"
```

---

## Task 4: Model Tests

**Files:**
- Create: `tests/Feature/Models/QuestionReportTest.php`

- [ ] **Step 1: Generate test**

```bash
php artisan make:test --pest QuestionReportTest --no-interaction
```

- [ ] **Step 2: Write tests**

Replace `tests/Feature/Models/QuestionReportTest.php` with:

```php
<?php

declare(strict_types=1);

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Models\Question;
use App\Models\QuestionReport;
use App\Models\User;

it('belongs to a question', function () {
    $report = QuestionReport::factory()->create();
    expect($report->question)->toBeInstanceOf(Question::class);
});

it('user is nullable', function () {
    $report = QuestionReport::factory()->create(['user_id' => null]);
    expect($report->user)->toBeNull();
});

it('belongs to a user when provided', function () {
    $user = User::factory()->create();
    $report = QuestionReport::factory()->create(['user_id' => $user->id]);
    expect($report->user)->toBeInstanceOf(User::class);
});

it('casts report_type to ReportType enum', function () {
    $report = QuestionReport::factory()->create(['report_type' => 'wrong_answer']);
    expect($report->report_type)->toBe(ReportType::WrongAnswer);
});

it('casts status to ReportStatus enum', function () {
    $report = QuestionReport::factory()->create(['status' => 'pending']);
    expect($report->status)->toBe(ReportStatus::Pending);
});

it('casts resolved_at to carbon', function () {
    $report = QuestionReport::factory()->resolved()->create();
    expect($report->resolved_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});

it('question has many reports', function () {
    $question = Question::factory()->create();
    QuestionReport::factory()->count(3)->create(['question_id' => $question->id]);
    expect($question->fresh()->reports)->toHaveCount(3);
});
```

- [ ] **Step 3: Run tests**

```bash
php artisan test --compact --filter=QuestionReportTest
```

Expected: all 7 tests pass.

- [ ] **Step 4: Commit**

```bash
git add tests/Feature/Models/QuestionReportTest.php
git commit -m "test: add QuestionReport model tests"
```

---

## Task 5: ReportConcern Livewire Component Stub + Failing Tests

**Files:**
- Create: `app/Livewire/ReportConcern.php` (stub)
- Create: `tests/Feature/Livewire/ReportConcernTest.php`

- [ ] **Step 1: Generate Livewire component (stub)**

```bash
php artisan make:livewire ReportConcern --no-interaction
```

This creates `app/Livewire/ReportConcern.php` and `resources/views/livewire/report-concern.blade.php`.

- [ ] **Step 2: Write stub component (just public properties, no logic)**

Replace `app/Livewire/ReportConcern.php` with:

```php
<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReportConcern extends Component
{
    #[Locked]
    public int $questionId;

    #[Validate('required|in:wrong_answer,typo,unclear_question,other')]
    public string $reportType = '';

    #[Validate('nullable|string|max:500')]
    public string $description = '';

    public bool $submitted = false;

    public function submit(): void
    {
        // TODO: implement
    }

    public function render(): View
    {
        return view('livewire.report-concern');
    }
}
```

- [ ] **Step 3: Write stub view (bare minimum so render doesn't error)**

Replace `resources/views/livewire/report-concern.blade.php` with:

```html
<div>
    <button wire:click="$set('submitted', false)">Report an issue</button>
    <div>
        <select wire:model="reportType"><option value="">Select</option></select>
        <textarea wire:model="description"></textarea>
        <button wire:click="submit">Submit</button>
    </div>
    @if ($submitted)
        <p>Thank you for your report.</p>
    @endif
</div>
```

- [ ] **Step 4: Generate test**

```bash
php artisan make:test --pest ReportConcernTest --no-interaction
```

- [ ] **Step 5: Write failing tests**

Replace `tests/Feature/Livewire/ReportConcernTest.php` with:

```php
<?php

declare(strict_types=1);

use App\Livewire\ReportConcern;
use App\Models\Question;
use App\Models\QuestionReport;
use App\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

it('requires a report type before submitting', function () {
    $question = Question::factory()->create();

    livewire(ReportConcern::class, ['questionId' => $question->id])
        ->call('submit')
        ->assertHasErrors(['reportType' => 'required']);
});

it('rejects invalid report type', function () {
    $question = Question::factory()->create();

    livewire(ReportConcern::class, ['questionId' => $question->id])
        ->set('reportType', 'invalid_type')
        ->call('submit')
        ->assertHasErrors(['reportType' => 'in']);
});

it('rejects description over 500 characters', function () {
    $question = Question::factory()->create();

    livewire(ReportConcern::class, ['questionId' => $question->id])
        ->set('reportType', 'typo')
        ->set('description', str_repeat('a', 501))
        ->call('submit')
        ->assertHasErrors(['description' => 'max']);
});

it('can submit a report as a guest', function () {
    $question = Question::factory()->create();

    livewire(ReportConcern::class, ['questionId' => $question->id])
        ->set('reportType', 'wrong_answer')
        ->set('description', 'The correct answer should be option B.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    assertDatabaseHas(QuestionReport::class, [
        'question_id' => $question->id,
        'report_type' => 'wrong_answer',
        'description' => 'The correct answer should be option B.',
        'status' => 'pending',
        'user_id' => null,
    ]);
});

it('stores the user_id when authenticated', function () {
    $user = User::factory()->create();
    $question = Question::factory()->create();

    $this->actingAs($user);

    livewire(ReportConcern::class, ['questionId' => $question->id])
        ->set('reportType', 'typo')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    assertDatabaseHas(QuestionReport::class, [
        'question_id' => $question->id,
        'user_id' => $user->id,
    ]);
});

it('accepts null description', function () {
    $question = Question::factory()->create();

    livewire(ReportConcern::class, ['questionId' => $question->id])
        ->set('reportType', 'other')
        ->set('description', '')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    assertDatabaseHas(QuestionReport::class, [
        'question_id' => $question->id,
        'description' => null,
    ]);
});
```

- [ ] **Step 6: Run tests to confirm they fail**

```bash
php artisan test --compact --filter=ReportConcernTest
```

Expected: tests fail because `submit()` does not create a record.

---

## Task 6: ReportConcern Full Implementation

**Files:**
- Modify: `app/Livewire/ReportConcern.php`
- Modify: `resources/views/livewire/report-concern.blade.php`

- [ ] **Step 1: Implement submit() logic**

Replace `app/Livewire/ReportConcern.php` with:

```php
<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\QuestionReport;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReportConcern extends Component
{
    #[Locked]
    public int $questionId;

    #[Validate('required|in:wrong_answer,typo,unclear_question,other')]
    public string $reportType = '';

    #[Validate('nullable|string|max:500')]
    public string $description = '';

    public bool $submitted = false;

    public function submit(): void
    {
        $this->validate();

        QuestionReport::query()->create([
            'question_id' => $this->questionId,
            'user_id' => auth()->id(),
            'report_type' => $this->reportType,
            'description' => $this->description !== '' ? $this->description : null,
            'status' => 'pending',
        ]);

        $this->submitted = true;
        $this->reportType = '';
        $this->description = '';
        $this->dispatch('report-submitted');
    }

    public function render(): View
    {
        return view('livewire.report-concern');
    }
}
```

- [ ] **Step 2: Write the full view**

Replace `resources/views/livewire/report-concern.blade.php` with:

```html
<div x-data="{ open: false }" x-on:report-submitted.window="open = false">

    @if ($submitted)
        <p class="mt-4 flex items-center gap-1.5 text-xs text-go-green">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Report received — thank you.
        </p>
    @else
        <button
            x-on:click="open = !open"
            type="button"
            class="mt-4 flex items-center gap-1.5 text-xs text-zinc-600 hover:text-zinc-400 transition-colors"
        >
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6H9.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
            </svg>
            Report an issue
        </button>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1"
            class="mt-3 rounded-xl border border-zinc-700 bg-zinc-800/60 p-4 space-y-3"
        >
            <p class="text-xs font-medium text-zinc-400">What's the issue?</p>

            <div class="space-y-2">
                @foreach (\App\Enums\ReportType::cases() as $type)
                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border p-3 transition-all duration-100
                        {{ $reportType === $type->value
                            ? 'border-road-yellow/40 bg-road-yellow/6 text-white'
                            : 'border-zinc-700 text-zinc-400 hover:border-zinc-600 hover:text-zinc-300' }}">
                        <div class="w-4 h-4 rounded-full border-2 shrink-0 flex items-center justify-center transition-all
                            {{ $reportType === $type->value ? 'border-road-yellow' : 'border-zinc-600' }}">
                            @if ($reportType === $type->value)
                                <div class="w-2 h-2 rounded-full bg-road-yellow"></div>
                            @endif
                        </div>
                        <input type="radio" wire:model.live="reportType" value="{{ $type->value }}" class="sr-only">
                        <span class="text-xs leading-snug">{{ $type->label() }}</span>
                    </label>
                @endforeach
            </div>

            @error('reportType')
                <p class="text-xs text-stop-red">{{ $message }}</p>
            @enderror

            <textarea
                wire:model="description"
                rows="2"
                placeholder="Optional: add more detail…"
                class="w-full resize-none rounded-lg border border-zinc-700 bg-zinc-900 px-3 py-2 text-xs text-zinc-300 placeholder-zinc-600 focus:border-zinc-500 focus:outline-none"
            ></textarea>

            @error('description')
                <p class="text-xs text-stop-red">{{ $message }}</p>
            @enderror

            <div class="flex items-center justify-end gap-3">
                <button
                    x-on:click="open = false"
                    type="button"
                    class="text-xs text-zinc-500 hover:text-zinc-300 transition-colors"
                >
                    Cancel
                </button>
                <button
                    wire:click="submit"
                    wire:loading.attr="disabled"
                    type="button"
                    class="rounded-lg bg-road-yellow px-4 py-1.5 text-xs font-semibold text-zinc-950 hover:bg-road-yellow/90 transition-all disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="submit">Submit</span>
                    <span wire:loading wire:target="submit">Sending…</span>
                </button>
            </div>
        </div>
    @endif

</div>
```

- [ ] **Step 3: Format**

```bash
vendor/bin/pint app/Livewire/ReportConcern.php --format agent
```

- [ ] **Step 4: Run tests to confirm they pass**

```bash
php artisan test --compact --filter=ReportConcernTest
```

Expected: all 6 tests pass.

- [ ] **Step 5: Commit**

```bash
git add app/Livewire/ReportConcern.php resources/views/livewire/report-concern.blade.php
git commit -m "feat: add ReportConcern Livewire component"
```

---

## Task 7: Integrate into Practice Test and Flashcard Views

**Files:**
- Modify: `resources/views/livewire/test/practice-test.blade.php`
- Modify: `resources/views/livewire/study/flash-card.blade.php`

- [ ] **Step 1: Add component to practice test view**

In `resources/views/livewire/test/practice-test.blade.php`, locate the question card closing `</div>` (line 67, the closing `</div>` for the question card `rounded-2xl`). Insert the component after it, before the submit button `<div class="flex justify-end">`:

```html
        </div>

        <livewire:report-concern :question-id="$question->id" :wire:key="'report-' . $question->id" />

        <div class="flex justify-end">
```

The full updated section (lines 65–70) should read:

```html
            @error('selectedAnswer')
                <p class="mt-4 text-sm text-stop-red flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <livewire:report-concern :question-id="$question->id" :wire:key="'report-' . $question->id" />

        <div class="flex justify-end">
```

- [ ] **Step 2: Add component to flashcard view**

In `resources/views/livewire/study/flash-card.blade.php`, add the component after the navigation `<div class="mt-6 flex items-center justify-between">` block (after its closing `</div>`, around line 69). Insert before the `@else` block:

```html
        <livewire:report-concern :question-id="$this->currentQuestion->id" :wire:key="'report-' . $this->currentQuestion->id" />

        @else
```

The full updated section at lines 67–72 should read:

```html
        </div>

        <livewire:report-concern
            :question-id="$this->currentQuestion->id"
            :wire:key="'report-' . $this->currentQuestion->id"
        />

    @else
```

- [ ] **Step 3: Commit**

```bash
git add resources/views/livewire/test/practice-test.blade.php resources/views/livewire/study/flash-card.blade.php
git commit -m "feat: embed ReportConcern component in practice test and flashcard views"
```

---

## Task 8: Filament Resource — Stub + Failing Tests

**Files:**
- Create: `app/Filament/Resources/QuestionReportResource.php`
- Create: `app/Filament/Resources/QuestionReportResource/Pages/ListQuestionReports.php`
- Create: `app/Filament/Resources/QuestionReportResource/Pages/ViewQuestionReport.php`
- Create: `tests/Feature/Filament/QuestionReportResourceTest.php`

- [ ] **Step 1: Generate the resource**

```bash
php artisan make:filament-resource QuestionReport --view --no-interaction
```

This creates the resource class and `ListQuestionReports`, `CreateQuestionReport`, and `ViewQuestionReport` page stubs. We don't need Create (reports come from users), so delete it:

```bash
rm app/Filament/Resources/QuestionReportResource/Pages/CreateQuestionReport.php
```

- [ ] **Step 2: Generate test**

```bash
php artisan make:test --pest QuestionReportResourceTest --no-interaction
```

- [ ] **Step 3: Write failing tests**

Replace `tests/Feature/Filament/QuestionReportResourceTest.php` with:

```php
<?php

declare(strict_types=1);

use App\Filament\Resources\QuestionReportResource\Pages\ListQuestionReports;
use App\Filament\Resources\QuestionReportResource\Pages\ViewQuestionReport;
use App\Models\Admin;
use App\Models\QuestionReport;
use Filament\Actions\Testing\TestAction;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(fn () => $this->actingAs(Admin::factory()->create(), 'admin'));

it('can list question reports', function () {
    $reports = QuestionReport::factory()->count(3)->create();
    livewire(ListQuestionReports::class)->assertCanSeeTableRecords($reports);
});

it('can view a question report', function () {
    $report = QuestionReport::factory()->create([
        'report_type' => 'wrong_answer',
        'description' => 'The answer is wrong.',
        'status' => 'pending',
    ]);

    livewire(ViewQuestionReport::class, ['record' => $report->id])
        ->assertOk()
        ->assertSchemaStateSet([
            'report_type' => 'wrong_answer',
            'status' => 'pending',
        ]);
});

it('can mark a report as reviewed', function () {
    $report = QuestionReport::factory()->create(['status' => 'pending']);

    livewire(ListQuestionReports::class)
        ->callAction(TestAction::make('markReviewed')->table($report))
        ->assertNotified();

    assertDatabaseHas(QuestionReport::class, [
        'id' => $report->id,
        'status' => 'reviewed',
    ]);
});

it('does not show markReviewed for already-reviewed reports', function () {
    $report = QuestionReport::factory()->create(['status' => 'reviewed']);

    livewire(ListQuestionReports::class)
        ->assertTableActionHidden('markReviewed', $report);
});

it('can mark a report as resolved', function () {
    $report = QuestionReport::factory()->create(['status' => 'pending']);

    livewire(ListQuestionReports::class)
        ->callAction(TestAction::make('markResolved')->table($report))
        ->assertNotified();

    assertDatabaseHas(QuestionReport::class, [
        'id' => $report->id,
        'status' => 'resolved',
    ]);

    expect(QuestionReport::find($report->id)->resolved_at)->not->toBeNull();
});

it('does not show markResolved for already-resolved reports', function () {
    $report = QuestionReport::factory()->resolved()->create();

    livewire(ListQuestionReports::class)
        ->assertTableActionHidden('markResolved', $report);
});

it('can filter reports by status', function () {
    $pending = QuestionReport::factory()->create(['status' => 'pending']);
    $resolved = QuestionReport::factory()->resolved()->create();

    livewire(ListQuestionReports::class)
        ->filterTable('status', 'pending')
        ->assertCanSeeTableRecords([$pending])
        ->assertCanNotSeeTableRecords([$resolved]);
});
```

- [ ] **Step 4: Run tests to confirm they fail**

```bash
php artisan test --compact --filter=QuestionReportResourceTest
```

Expected: tests fail because the resource has no columns/actions defined yet.

---

## Task 9: Filament Resource — Full Implementation

**Files:**
- Modify: `app/Filament/Resources/QuestionReportResource.php`
- Modify: `app/Filament/Resources/QuestionReportResource/Pages/ListQuestionReports.php`
- Modify: `app/Filament/Resources/QuestionReportResource/Pages/ViewQuestionReport.php`

- [ ] **Step 1: Write the full resource**

Replace `app/Filament/Resources/QuestionReportResource.php` with:

```php
<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Filament\Resources\QuestionReportResource\Pages\ListQuestionReports;
use App\Filament\Resources\QuestionReportResource\Pages\ViewQuestionReport;
use App\Models\QuestionReport;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuestionReportResource extends Resource
{
    protected static ?string $model = QuestionReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFlag;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()->where('status', 'pending')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::query()->where('status', 'pending')->exists() ? 'warning' : null;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                TextEntry::make('question.question_text')
                    ->label('Question')
                    ->columnSpanFull(),
                TextEntry::make('report_type')
                    ->badge()
                    ->formatStateUsing(fn (ReportType $state): string => $state->label()),
                TextEntry::make('status')->badge(),
                TextEntry::make('description')
                    ->placeholder('No description provided.')
                    ->columnSpanFull(),
                TextEntry::make('user.name')
                    ->label('Reported By')
                    ->placeholder('Guest'),
                TextEntry::make('created_at')->dateTime(),
                TextEntry::make('resolved_at')
                    ->dateTime()
                    ->placeholder('Not resolved yet.'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('question.question_text')
                    ->label('Question')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('report_type')
                    ->badge()
                    ->formatStateUsing(fn (ReportType $state): string => $state->label()),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (ReportStatus $state): string => match ($state) {
                        ReportStatus::Pending => 'warning',
                        ReportStatus::Reviewed => 'info',
                        ReportStatus::Resolved => 'success',
                    }),
                TextColumn::make('description')->limit(40)->placeholder('—'),
                TextColumn::make('created_at')->since()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewed' => 'Reviewed',
                        'resolved' => 'Resolved',
                    ]),
                SelectFilter::make('report_type')
                    ->options([
                        'wrong_answer' => 'Wrong Answer',
                        'typo' => 'Typo or Spelling Error',
                        'unclear_question' => 'Unclear Question',
                        'other' => 'Other',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('markReviewed')
                    ->label('Mark Reviewed')
                    ->icon(Heroicon::OutlinedCheck)
                    ->visible(fn (QuestionReport $record): bool => $record->status === ReportStatus::Pending)
                    ->action(function (QuestionReport $record): void {
                        $record->update(['status' => ReportStatus::Reviewed->value]);
                    })
                    ->successNotificationTitle('Marked as reviewed'),
                Action::make('markResolved')
                    ->label('Mark Resolved')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (QuestionReport $record): bool => $record->status !== ReportStatus::Resolved)
                    ->action(function (QuestionReport $record): void {
                        $record->update([
                            'status' => ReportStatus::Resolved->value,
                            'resolved_at' => now(),
                        ]);
                    })
                    ->successNotificationTitle('Marked as resolved'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionReports::route('/'),
            'view' => ViewQuestionReport::route('/{record}'),
        ];
    }
}
```

- [ ] **Step 2: Write ListQuestionReports page**

Replace `app/Filament/Resources/QuestionReportResource/Pages/ListQuestionReports.php` with:

```php
<?php

declare(strict_types=1);

namespace App\Filament\Resources\QuestionReportResource\Pages;

use App\Filament\Resources\QuestionReportResource;
use Filament\Resources\Pages\ListRecords;

class ListQuestionReports extends ListRecords
{
    protected static string $resource = QuestionReportResource::class;
}
```

- [ ] **Step 3: Write ViewQuestionReport page**

Replace `app/Filament/Resources/QuestionReportResource/Pages/ViewQuestionReport.php` with:

```php
<?php

declare(strict_types=1);

namespace App\Filament\Resources\QuestionReportResource\Pages;

use App\Filament\Resources\QuestionReportResource;
use Filament\Resources\Pages\ViewRecord;

class ViewQuestionReport extends ViewRecord
{
    protected static string $resource = QuestionReportResource::class;
}
```

- [ ] **Step 4: Format**

```bash
vendor/bin/pint app/Filament/Resources/QuestionReportResource.php app/Filament/Resources/QuestionReportResource/ --format agent
```

- [ ] **Step 5: Run all tests**

```bash
php artisan test --compact --filter=QuestionReportResourceTest
```

Expected: all 7 tests pass.

- [ ] **Step 6: Run full test suite to check for regressions**

```bash
php artisan test --compact
```

Expected: all tests pass.

- [ ] **Step 7: Commit**

```bash
git add app/Filament/Resources/QuestionReportResource.php app/Filament/Resources/QuestionReportResource/ tests/Feature/Filament/QuestionReportResourceTest.php
git commit -m "feat: add QuestionReportResource for admin triage"
```

---

## Self-Review

### Spec Coverage

| Requirement | Task |
|-------------|------|
| Users can report an issue with a question | Task 5–6 (ReportConcern component) |
| Appears on practice test | Task 7 (practice-test.blade.php) |
| Appears on flashcards | Task 7 (flash-card.blade.php) |
| Report type selection | Task 6 (ReportType enum in form) |
| Optional description | Task 6 (description textarea) |
| Guest support (no auth required) | Task 6 (user_id nullable) + Task 5 test |
| Auth user linked to report | Task 5 test |
| Admin can see reports | Task 9 (ListQuestionReports) |
| Admin can view full details | Task 9 (ViewQuestionReport infolist) |
| Admin can mark reviewed / resolved | Task 9 (markReviewed / markResolved actions) |
| Pending badge count in nav | Task 9 (getNavigationBadge) |

### Placeholder Scan

No "TBD", "TODO", or vague step language found. All steps contain complete code.

### Type Consistency

- `ReportType` enum values (`wrong_answer`, `typo`, `unclear_question`, `other`) consistent across: migration default comment, factory, Livewire `#[Validate]`, view loop, filter options, infolist formatter.
- `ReportStatus` enum values (`pending`, `reviewed`, `resolved`) consistent across: migration default, factory, status action visibility checks, filter options, badge color map.
- `QuestionReport` fillable includes all columns written in `submit()` and factory.

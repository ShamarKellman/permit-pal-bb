# Question Sign Visuals Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Show an image of the road sign on sign-related questions (practice test, test-result review, flash cards) so users learn what the sign actually looks like.

**Architecture:** A library of hand-crafted SVG sign images is committed to `database/seeders/images/signs/`. `QuestionSeeder` publishes them to the `public` storage disk under `signs/` and sets `image_path` on a curated subset of questions (the existing `image_path` column, `image` seeder key, and practice-test `<img>` rendering are already in place). The test-result review and flash-card views gain the same image rendering.

**Tech Stack:** Laravel 13, Livewire 4, Pest 4, Tailwind 4, plain SVG files.

## Global Constraints

- Run `vendor/bin/pint --dirty --format agent` after modifying any PHP file, before committing.
- Run tests with `php artisan test --compact --filter=<name>` (minimum needed tests only).
- Do NOT add any composer/npm dependencies.
- Do NOT delete existing tests.
- Seeder must stay idempotent (it uses `updateOrCreate` keyed on `question_text`; image publishing must overwrite, not duplicate).
- Blade-only view changes — no `npm run build` needed (no new Tailwind classes outside the existing utility set; if a class doesn't render, tell the user to run `npm run dev`/`composer run dev`).
- The app requires `php artisan storage:link` locally for `Storage::url()` paths (`/storage/...`) to resolve. If images 404 in the browser, run it.

## Curation Rule (why not all 50 road-sign questions get images)

A question only gets an image when **seeing the sign does not reveal the answer**. Excluded on purpose:

- "What shape are warning signs in Barbados?" / "What shape is a STOP sign?" / "What shape are most directional signs?" / "In Barbados, what shape is the pedestrian crossing sign…?" — the image IS the answer.
- "What is the give way sign?" — answers describe the sign's appearance.
- Generic knowledge questions with no single sign ("Where would you find directional signs…", "What do blue circular road signs do?", "What do red circles… indicate?", "most common traffic sign", road-marking questions, pedestrian-behaviour questions).

## File Structure

- Create: `database/seeders/images/signs/*.svg` — 37 sign images (Task 1)
- Modify: `database/seeders/QuestionSeeder.php` — publish images to public disk + add `'image'` keys (Task 2)
- Create: `tests/Feature/Seeders/QuestionSeederImagesTest.php` (Task 2)
- Modify: `resources/views/livewire/test/practice-test.blade.php:36-38` — sign-friendly `<img>` styling (Task 3)
- Modify: `tests/Feature/Livewire/Test/PracticeTestTest.php` — image rendering test (Task 3)
- Modify: `app/Livewire/Test/TestResult.php:92-102` — add `image_path` to review rows (Task 4)
- Modify: `resources/views/livewire/test/test-result.blade.php:~80` — render image in review card (Task 4)
- Modify: `tests/Feature/Livewire/Test/TestResultTest.php` — review image test (Task 4)
- Modify: `resources/views/livewire/study/flash-card.blade.php:31-39` — image on card front (Task 5)
- Modify: `tests/Feature/Livewire/Study/FlashCardTest.php` — flash-card image test (Task 5)

---

### Task 1: SVG sign asset library

**Files:**
- Create: `database/seeders/images/signs/` (37 `.svg` files, listed below)

**Interfaces:**
- Produces: 37 SVG files whose **filenames** are consumed by Task 2's question mapping (exact names in the table there). All files use `viewBox="0 0 120 120"`, no fixed width/height (scales via CSS), colors: red `#d40000`, blue `#0057b8`, dark `#1a1a1a`, white `#fff`.

Three shared frames used below (each file is self-contained — repeat the frame inside every file):

- **WARN** (warning triangle): `<path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/>`
- **PROHIB** (prohibition circle): `<circle cx="60" cy="60" r="53" fill="#fff" stroke="#d40000" stroke-width="10"/>`
- **MAND** (blue mandatory circle): `<circle cx="60" cy="60" r="55" fill="#0057b8" stroke="#fff" stroke-width="3"/>`

Every file starts with `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120">` and ends with `</svg>`.

- [ ] **Step 1: Create the 17 warning-triangle signs**

`warning-blank.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/></svg>
```

`warning-exclamation.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M60 44v24" stroke="#1a1a1a" stroke-width="9" stroke-linecap="round"/><circle cx="60" cy="84" r="5.5" fill="#1a1a1a"/></svg>
```

`crossroads.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M60 42v48M36 66h48" stroke="#1a1a1a" stroke-width="9"/></svg>
```

`t-junction.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M42 52h36M60 52v38" stroke="#1a1a1a" stroke-width="9"/></svg>
```

`staggered-junction.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M60 90V44M60 56h16M60 72H44" stroke="#1a1a1a" stroke-width="8"/></svg>
```

`merge-right.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M52 92V52" stroke="#1a1a1a" stroke-width="8"/><path d="M52 40 44 54h16z" fill="#1a1a1a"/><path d="M74 90q0-18-18-26" stroke="#1a1a1a" stroke-width="7" fill="none"/></svg>
```

`bend-ahead.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M54 90V66q0-10 10-10h4" stroke="#1a1a1a" stroke-width="9" fill="none"/><path d="M66 46l16 10-16 10z" fill="#1a1a1a"/></svg>
```

`double-bend.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M52 90V76q0-9 8-9t8-9v-6" stroke="#1a1a1a" stroke-width="8" fill="none"/><path d="M68 40l-8 13h16z" fill="#1a1a1a"/></svg>
```

`road-narrows.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M46 92q0-24 6-34M74 92q0-24-6-34" stroke="#1a1a1a" stroke-width="7" fill="none"/></svg>
```

`lanes-merge.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M50 92V56" stroke="#1a1a1a" stroke-width="7"/><path d="M50 44l-8 13h16z" fill="#1a1a1a"/><path d="M74 92q2-22-18-32" stroke="#1a1a1a" stroke-width="7" fill="none"/></svg>
```

`uneven-road.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M36 80q8-16 16 0t16 0 16 0" stroke="#1a1a1a" stroke-width="7" fill="none" stroke-linecap="round"/></svg>
```

`road-hump.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M38 84q22-28 44 0z" fill="#1a1a1a"/></svg>
```

`pedestrian-ahead.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><circle cx="58" cy="46" r="6" fill="#1a1a1a"/><path d="M58 54 54 72l-9 18M54 72l14 16M56 60l-10 8M58 58l12 6" stroke="#1a1a1a" stroke-width="5" fill="none" stroke-linecap="round"/></svg>
```

`traffic-signals-ahead.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><rect x="51" y="46" width="18" height="42" rx="4" fill="#1a1a1a"/><circle cx="60" cy="55" r="4.5" fill="#d40000"/><circle cx="60" cy="67" r="4.5" fill="#f2b705"/><circle cx="60" cy="79" r="4.5" fill="#1f9d3a"/></svg>
```

`road-works.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M38 90q22-10 44 0z" fill="#1a1a1a"/><circle cx="52" cy="52" r="5.5" fill="#1a1a1a"/><path d="M54 58q6 8 4 20M56 64l18 14M74 66 62 84" stroke="#1a1a1a" stroke-width="5" fill="none" stroke-linecap="round"/></svg>
```

`slippery-road.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><g transform="rotate(-14 60 64)"><rect x="42" y="54" width="36" height="12" rx="4" fill="#1a1a1a"/><rect x="50" y="46" width="18" height="10" rx="3" fill="#1a1a1a"/><circle cx="50" cy="68" r="5" fill="#1a1a1a"/><circle cx="70" cy="68" r="5" fill="#1a1a1a"/></g><path d="M40 88q6-4 2-8M56 90q6-4 2-8" stroke="#1a1a1a" stroke-width="4" fill="none"/></svg>
```

`quayside.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><path d="M38 62h22v26" stroke="#1a1a1a" stroke-width="6" fill="none"/><g transform="rotate(28 78 56)"><rect x="62" y="48" width="28" height="10" rx="3" fill="#1a1a1a"/><circle cx="69" cy="60" r="4" fill="#1a1a1a"/><circle cx="83" cy="60" r="4" fill="#1a1a1a"/></g><path d="M64 92q4-6 8 0t8 0 8 0" stroke="#1a1a1a" stroke-width="4" fill="none"/></svg>
```

- [ ] **Step 2: Create the 9 prohibition-circle signs**

`no-entry.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="56" fill="#d40000"/><rect x="24" y="53" width="72" height="14" rx="3" fill="#fff"/></svg>
```

`all-vehicles-prohibited.svg` (bicycle + car, no red slash — the plain red ring is the prohibition)
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="53" fill="#fff" stroke="#d40000" stroke-width="10"/><rect x="40" y="36" width="40" height="12" rx="4" fill="#1a1a1a"/><rect x="48" y="28" width="22" height="10" rx="3" fill="#1a1a1a"/><circle cx="48" cy="50" r="4" fill="#1a1a1a"/><circle cx="72" cy="50" r="4" fill="#1a1a1a"/><circle cx="46" cy="82" r="9" fill="none" stroke="#1a1a1a" stroke-width="4"/><circle cx="74" cy="82" r="9" fill="none" stroke="#1a1a1a" stroke-width="4"/><path d="M46 82 56 66h8l10 16M56 66l4 16" stroke="#1a1a1a" stroke-width="4" fill="none"/></svg>
```

`no-motor-vehicles.svg` (motorcycle above car)
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="53" fill="#fff" stroke="#d40000" stroke-width="10"/><circle cx="44" cy="50" r="7" fill="none" stroke="#1a1a1a" stroke-width="4"/><circle cx="72" cy="50" r="7" fill="none" stroke="#1a1a1a" stroke-width="4"/><path d="M44 50 56 36h10l6 14M66 36l-4-6h8" stroke="#1a1a1a" stroke-width="4" fill="none"/><rect x="38" y="70" width="44" height="12" rx="4" fill="#1a1a1a"/><rect x="46" y="62" width="26" height="10" rx="3" fill="#1a1a1a"/><circle cx="47" cy="84" r="4.5" fill="#1a1a1a"/><circle cx="73" cy="84" r="4.5" fill="#1a1a1a"/></svg>
```

`no-overtaking.svg` (red car left, black car right, front view)
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="53" fill="#fff" stroke="#d40000" stroke-width="10"/><rect x="30" y="46" width="22" height="30" rx="6" fill="#d40000"/><rect x="34" y="52" width="14" height="8" rx="2" fill="#fff"/><rect x="66" y="46" width="22" height="30" rx="6" fill="#1a1a1a"/><rect x="70" y="52" width="14" height="8" rx="2" fill="#fff"/></svg>
```

`no-left-turn.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="53" fill="#fff" stroke="#d40000" stroke-width="10"/><path d="M74 84V62q0-10-10-10H52" stroke="#1a1a1a" stroke-width="8" fill="none"/><path d="M54 42 38 52l16 10z" fill="#1a1a1a"/><line x1="26" y1="94" x2="94" y2="26" stroke="#d40000" stroke-width="9"/></svg>
```

`no-right-turn.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="53" fill="#fff" stroke="#d40000" stroke-width="10"/><path d="M46 84V62q0-10 10-10h12" stroke="#1a1a1a" stroke-width="8" fill="none"/><path d="M66 42l16 10-16 10z" fill="#1a1a1a"/><line x1="26" y1="94" x2="94" y2="26" stroke="#d40000" stroke-width="9"/></svg>
```

`no-u-turn.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="53" fill="#fff" stroke="#d40000" stroke-width="10"/><path d="M46 84V56a14 14 0 0 1 28 0v8" stroke="#1a1a1a" stroke-width="8" fill="none"/><path d="M64 64h20L74 80z" fill="#1a1a1a"/><line x1="26" y1="94" x2="94" y2="26" stroke="#d40000" stroke-width="9"/></svg>
```

`no-waiting.svg` (blue disc, red ring, ONE red diagonal)
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="52" fill="#0057b8" stroke="#d40000" stroke-width="11"/><line x1="26" y1="94" x2="94" y2="26" stroke="#d40000" stroke-width="10"/></svg>
```

`no-stopping.svg` (blue disc, red ring, red X)
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="52" fill="#0057b8" stroke="#d40000" stroke-width="11"/><line x1="26" y1="94" x2="94" y2="26" stroke="#d40000" stroke-width="10"/><line x1="26" y1="26" x2="94" y2="94" stroke="#d40000" stroke-width="10"/></svg>
```

- [ ] **Step 3: Create the remaining 11 signs (mandatory circles, rectangles, pedestrian signals, misc)**

`ahead-only.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="55" fill="#0057b8" stroke="#fff" stroke-width="3"/><path d="M60 94V48" stroke="#fff" stroke-width="10"/><path d="M60 24 42 52h36z" fill="#fff"/></svg>
```

`keep-left.svg` (white arrow pointing down-left)
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="55" fill="#0057b8" stroke="#fff" stroke-width="3"/><path d="M82 34 52 64" stroke="#fff" stroke-width="10"/><path d="M34 86 42 58l20 20z" fill="#fff"/></svg>
```

`turn-left-ahead.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="55" fill="#0057b8" stroke="#fff" stroke-width="3"/><path d="M74 88V62q0-10-10-10H52" stroke="#fff" stroke-width="9" fill="none"/><path d="M56 40 38 52l18 12z" fill="#fff"/></svg>
```

`mini-roundabout.svg` (three white arrows circling; one arrow group rotated ×3)
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="55" fill="#0057b8" stroke="#fff" stroke-width="3"/><g><path d="M60 30a30 30 0 0 1 24 12" stroke="#fff" stroke-width="7" fill="none"/><path d="M88 48l2-18-16 8z" fill="#fff"/></g><g transform="rotate(120 60 60)"><path d="M60 30a30 30 0 0 1 24 12" stroke="#fff" stroke-width="7" fill="none"/><path d="M88 48l2-18-16 8z" fill="#fff"/></g><g transform="rotate(240 60 60)"><path d="M60 30a30 30 0 0 1 24 12" stroke="#fff" stroke-width="7" fill="none"/><path d="M88 48l2-18-16 8z" fill="#fff"/></g></svg>
```

`roundabout-ahead.svg` (warning triangle + three black circling arrows, centred lower)
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><path d="M60 10 113 103H7Z" fill="#fff" stroke="#d40000" stroke-width="9" stroke-linejoin="round"/><g><path d="M60 48a18 18 0 0 1 14 7" stroke="#1a1a1a" stroke-width="6" fill="none"/><path d="M77 59l1-13-11 5z" fill="#1a1a1a"/></g><g transform="rotate(120 60 66)"><path d="M60 48a18 18 0 0 1 14 7" stroke="#1a1a1a" stroke-width="6" fill="none"/><path d="M77 59l1-13-11 5z" fill="#1a1a1a"/></g><g transform="rotate(240 60 66)"><path d="M60 48a18 18 0 0 1 14 7" stroke="#1a1a1a" stroke-width="6" fill="none"/><path d="M77 59l1-13-11 5z" fill="#1a1a1a"/></g></svg>
```

`derestriction.svg` (white circle, single black diagonal)
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><circle cx="60" cy="60" r="54" fill="#fff" stroke="#4a4a4a" stroke-width="4"/><line x1="28" y1="92" x2="92" y2="28" stroke="#1a1a1a" stroke-width="10"/></svg>
```

`one-way.svg` (blue rectangle, white up arrow)
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><rect x="32" y="6" width="56" height="108" rx="8" fill="#0057b8"/><path d="M60 98V50" stroke="#fff" stroke-width="9"/><path d="M60 24 44 52h32z" fill="#fff"/></svg>
```

`hospital.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><rect x="10" y="10" width="100" height="100" rx="12" fill="#0057b8"/><path d="M44 34v52M76 34v52M44 60h32" stroke="#fff" stroke-width="11" stroke-linecap="round"/></svg>
```

`reduce-speed-now.svg`
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><rect x="4" y="28" width="112" height="64" rx="8" fill="#d40000"/><text x="60" y="55" text-anchor="middle" font-family="Arial, Helvetica, sans-serif" font-size="17" font-weight="700" fill="#fff">REDUCE</text><text x="60" y="78" text-anchor="middle" font-family="Arial, Helvetica, sans-serif" font-size="17" font-weight="700" fill="#fff">SPEED NOW</text></svg>
```

`walk.svg` (pedestrian-signal box, white walking figure)
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><rect x="12" y="12" width="96" height="96" rx="10" fill="#111"/><circle cx="58" cy="36" r="7" fill="#fff"/><path d="M58 45 53 66l-10 22M53 66l16 20M55 52l-12 9M58 49l14 8" stroke="#fff" stroke-width="6" fill="none" stroke-linecap="round"/></svg>
```

`dont-walk.svg` (pedestrian-signal box, orange raised hand)
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"><rect x="12" y="12" width="96" height="96" rx="10" fill="#111"/><g fill="#f60"><rect x="46" y="28" width="9" height="34" rx="4.5"/><rect x="57" y="24" width="9" height="38" rx="4.5"/><rect x="68" y="28" width="9" height="34" rx="4.5"/><rect x="79" y="36" width="9" height="26" rx="4.5"/><rect x="30" y="50" width="9" height="22" rx="4.5" transform="rotate(-28 34 60)"/><path d="M42 58v18q0 16 16 16h14q14 0 14-14V58z"/></g></svg>
```

- [ ] **Step 4: Visual verification (CHECKPOINT — needs human eyes)**

Generate a dark-background contact sheet in the scratchpad and open it:

```bash
SIGNS="$PWD/database/seeders/images/signs"
OUT="<scratchpad-dir>/sign-preview.html"
{
  echo '<body style="background:#18181b;display:grid;grid-template-columns:repeat(6,1fr);gap:14px;padding:24px">'
  for f in "$SIGNS"/*.svg; do
    echo "<figure style='margin:0;text-align:center'><img src='file://$f' style='width:100%'><figcaption style='font:11px sans-serif;color:#a1a1aa;margin-top:4px'>$(basename "$f")</figcaption></figure>"
  done
} > "$OUT"
open "$OUT"
```

Expected: 37 tiles, every sign recognizable as described by its filename, no clipped glyphs outside its frame. Fix any SVG that reads wrong (glyph paths are stylized, but shape/colour family must be unmistakable). **Pause here for human review of the contact sheet before committing.**

- [ ] **Step 5: Commit**

```bash
git add database/seeders/images/signs
git commit -m "feat: add SVG road sign image library for question visuals"
```

---

### Task 2: Seeder publishes images and maps them to questions

**Files:**
- Modify: `database/seeders/QuestionSeeder.php`
- Test: `tests/Feature/Seeders/QuestionSeederImagesTest.php` (create)

**Interfaces:**
- Consumes: SVG filenames from Task 1.
- Produces: `Question.image_path` values of the form `signs/<name>.svg`, files on `Storage::disk('public')` at the same relative path. Views (Tasks 3–5) resolve them with `Storage::url($path)`.

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Seeders/QuestionSeederImagesTest.php`:

```php
<?php

declare(strict_types=1);

use App\Models\Question;
use Database\Seeders\CategorySeeder;
use Database\Seeders\QuestionSeeder;
use Illuminate\Support\Facades\Storage;

it('publishes sign images to the public disk and maps them to questions', function () {
    Storage::fake('public');

    $this->seed([CategorySeeder::class, QuestionSeeder::class]);

    Storage::disk('public')->assertExists('signs/no-entry.svg');

    $question = Question::query()
        ->where('question_text', 'What does a red circular road sign with a white horizontal bar in the middle mean?')
        ->firstOrFail();

    expect($question->image_path)->toBe('signs/no-entry.svg');
});

it('has a published file for every seeded image path', function () {
    Storage::fake('public');

    $this->seed([CategorySeeder::class, QuestionSeeder::class]);

    $paths = Question::query()->whereNotNull('image_path')->pluck('image_path');

    expect($paths)->not->toBeEmpty();

    $paths->each(fn (string $path) => Storage::disk('public')->assertExists($path));
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --compact --filter=QuestionSeederImages`
Expected: FAIL — `signs/no-entry.svg` does not exist / `image_path` is null.

- [ ] **Step 3: Add image publishing to `QuestionSeeder::run()`**

Add imports `use Illuminate\Support\Facades\File;` and `use Illuminate\Support\Facades\Storage;`, call `$this->publishSignImages();` as the first line of `run()`, and add the method:

```php
private function publishSignImages(): void
{
    foreach (File::files(database_path('seeders/images/signs')) as $file) {
        if ($file->getExtension() !== 'svg') {
            continue;
        }

        Storage::disk('public')->put('signs/'.$file->getFilename(), $file->getContents());
    }
}
```

- [ ] **Step 4: Add `'image'` keys to the mapped questions**

In `QuestionSeeder::questions()`, for each entry whose `'question'` string is listed below, add one line directly after the `'question' =>` line: `'image' => 'signs/<file>',`. Example for the first mapping:

```php
[
    'category' => 'road-signs',
    'difficulty' => 'medium',
    'question' => 'What does a red circular road sign with a white horizontal bar in the middle mean?',
    'image' => 'signs/no-entry.svg',
    'answers' => [
        // ... unchanged
    ],
],
```

Full mapping (question text must match the existing seeder string exactly — do not retype the questions):

| Question text (exact) | image |
|---|---|
| What does a red circular road sign with a white horizontal bar in the middle mean? | `signs/no-entry.svg` |
| A circular sign with a red border and white background showing a bicycle and a car means what? | `signs/all-vehicles-prohibited.svg` |
| What does a circular sign with three arrows going in a circle indicate? | `signs/mini-roundabout.svg` |
| A triangular sign with a white background, red border and a single pedestrian walking means what? | `signs/pedestrian-ahead.svg` |
| A triangle with its apex pointing upward and a red border — what does it do? | `signs/warning-blank.svg` |
| A white triangular sign with a red border and three arrows arranged in a clockwise circle means: | `signs/roundabout-ahead.svg` |
| A white triangular sign with a red border and a black cross in the middle means: | `signs/crossroads.svg` |
| A sign showing a red car and a black car side by side means: | `signs/no-overtaking.svg` |
| What does a circular sign with a red border showing a left-turn arrow crossed out mean? | `signs/no-left-turn.svg` |
| What does a circular sign with a red border showing a right-turn arrow crossed out mean? | `signs/no-right-turn.svg` |
| What does a circular sign with a red border showing a U-shaped arrow crossed out mean? | `signs/no-u-turn.svg` |
| What does a circular sign with a red border showing both a motorcycle above a car mean? | `signs/no-motor-vehicles.svg` |
| What does a triangular warning sign with a T-shape inside mean? | `signs/t-junction.svg` |
| A triangular warning sign with an offset cross (one arm shifted to the side) indicates: | `signs/staggered-junction.svg` |
| A triangular warning sign showing traffic merging in from the right side means: | `signs/merge-right.svg` |
| What does a triangular warning sign with a curved arrow (bend shape) inside mean? | `signs/bend-ahead.svg` |
| What does a triangular warning sign with an S-shaped arrow inside mean? | `signs/double-bend.svg` |
| A triangular warning sign showing two lines converging equally from both sides indicates: | `signs/road-narrows.svg` |
| A triangular warning sign with a bumpy (uneven) surface symbol inside means: | `signs/uneven-road.svg` |
| What does a blue circular sign with a red diagonal stripe mean? | `signs/no-waiting.svg` |
| What does a blue circular sign with a red X crossed through it mean? | `signs/no-stopping.svg` |
| What does a blue circular sign with a white downward-left diagonal arrow mean? | `signs/keep-left.svg` |
| A blue circular sign with a white upward arrow means: | `signs/ahead-only.svg` |
| What does a blue circular sign with a white left-curving arrow mean? | `signs/turn-left-ahead.svg` |
| What does a rectangular blue sign with a white upward arrow indicate? | `signs/one-way.svg` |
| What does a white circular sign with a single black diagonal stripe mean? | `signs/derestriction.svg` |
| A triangular warning sign showing two lanes of traffic converging into one indicates: | `signs/lanes-merge.svg` |
| What does a triangular warning sign containing a traffic light symbol mean? | `signs/traffic-signals-ahead.svg` |
| A triangular warning sign containing only an exclamation mark (!) means: | `signs/warning-exclamation.svg` |
| What does a rectangular red sign reading "REDUCE SPEED NOW" mean? | `signs/reduce-speed-now.svg` |
| A triangular warning sign showing a worker with a shovel indicates: | `signs/road-works.svg` |
| A triangular warning sign showing a car with skid marks leaving the road means: | `signs/slippery-road.svg` |
| A triangular warning sign with a single rounded hump inside means: | `signs/road-hump.svg` |
| A triangular warning sign showing a car falling off a cliff edge into water warns of: | `signs/quayside.svg` |
| What does the "Don't Walk" symbol at a pedestrian crossing mean? | `signs/dont-walk.svg` |
| What does the "Walk" symbol at a pedestrian crossing indicate? | `signs/walk.svg` |
| The "Don't Walk" sign at a pedestrian crossing begins to flash. What does this mean? | `signs/dont-walk.svg` |

(37 mappings; `dont-walk.svg` used twice. In the PHP source these strings use escapes: `"Don\'t Walk"` and the `"REDUCE SPEED NOW"` questions — locate by grep, don't retype. The `"H"` sign question was dropped from this table: its correct answer is "Hydrant," not "Hospital," and `hospital.svg` doesn't apply — see Task 2's implementation-time fix commit.)

- [ ] **Step 5: Run tests to verify they pass**

Run: `php artisan test --compact --filter=QuestionSeederImages`
Expected: PASS (2 tests).

- [ ] **Step 6: Format + commit**

```bash
vendor/bin/pint --dirty --format agent
git add database/seeders/QuestionSeeder.php tests/Feature/Seeders/QuestionSeederImagesTest.php
git commit -m "feat: seed road sign images onto sign-related questions"
```

---

### Task 3: Practice-test image styling

**Files:**
- Modify: `resources/views/livewire/test/practice-test.blade.php:36-38`
- Test: `tests/Feature/Livewire/Test/PracticeTestTest.php`

**Interfaces:**
- Consumes: `Question.image_path` (`signs/*.svg`) from Task 2; `Storage::url()` rendering already exists in this view.
- Produces: nothing consumed by later tasks (visual only).

The current `<img>` uses `w-full object-cover max-h-52` — that crops/stretches a square sign. Signs must be contained and centred.

- [ ] **Step 1: Write the failing test**

Add to `tests/Feature/Livewire/Test/PracticeTestTest.php` (inside the existing file, after the existing tests — the `beforeEach` already creates 20 questions):

```php
it('renders a contained question image when present', function () {
    Question::query()->update(['image_path' => 'signs/no-entry.svg']);

    livewire(PracticeTest::class)
        ->assertSeeHtml('signs/no-entry.svg')
        ->assertSeeHtml('object-contain');
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --compact --filter="renders a contained question image"`
Expected: FAIL — `object-contain` not in output (image itself already renders via existing code).

- [ ] **Step 3: Update the view**

In `resources/views/livewire/test/practice-test.blade.php` replace:

```blade
<img src="{{ Storage::url($question->image_path) }}" alt="Question image" class="mb-5 w-full rounded-xl object-cover max-h-52">
```

with:

```blade
<img src="{{ Storage::url($question->image_path) }}" alt="Road sign for this question" class="mb-5 mx-auto max-h-44 w-auto object-contain">
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `php artisan test --compact --filter=PracticeTest`
Expected: PASS (all existing + new).

- [ ] **Step 5: Commit**

```bash
git add resources/views/livewire/test/practice-test.blade.php tests/Feature/Livewire/Test/PracticeTestTest.php
git commit -m "fix: contain and centre question sign images in practice test"
```

---

### Task 4: Sign image in test-result question review

**Files:**
- Modify: `app/Livewire/Test/TestResult.php:92-102` (`questionReview` computed property)
- Modify: `resources/views/livewire/test/test-result.blade.php` (review card, after the question header `div` that closes around line 80)
- Test: `tests/Feature/Livewire/Test/TestResultTest.php`

**Interfaces:**
- Consumes: `Question.image_path` from Task 2.
- Produces: `questionReview` rows gain key `'image_path' => ?string`.

- [ ] **Step 1: Write the failing test**

Add to `tests/Feature/Livewire/Test/TestResultTest.php` (imports for `Answer`, `Category`, `Question`, `TestSession` already exist in the file):

```php
it('shows the question sign image in the review', function () {
    $category = Category::factory()->create();
    $question = Question::factory()->for($category)->create(['image_path' => 'signs/no-entry.svg']);
    $answer = Answer::factory()->correct()->for($question)->create();

    $session = TestSession::factory()->create();
    $session->responses()->create([
        'question_id' => $question->id,
        'answer_id' => $answer->id,
        'is_correct' => true,
    ]);

    session(['last_test_session_id' => $session->id]);

    livewire(TestResult::class)->assertSeeHtml('signs/no-entry.svg');
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --compact --filter="shows the question sign image in the review"`
Expected: FAIL — image not rendered.

- [ ] **Step 3: Add `image_path` to the review rows**

In `app/Livewire/Test/TestResult.php`, inside `questionReview()`'s map closure, add one key to the returned array:

```php
return [
    'question_text' => $response->question->question_text ?? '',
    'image_path' => $response->question?->image_path,
    'user_answer' => $response->answer->answer_text ?? '',
    'correct_answer' => $correctAnswer->answer_text ?? '',
    'is_correct' => $response->is_correct,
    'explanation' => $correctAnswer?->explanation,
];
```

- [ ] **Step 4: Render the image in the review card**

In `resources/views/livewire/test/test-result.blade.php`, directly after the question number + text `div` (the one containing `{{ $row['question_text'] }}`, closes ~line 80) and before the `{{-- Answers --}}` block, add:

```blade
@if ($row['image_path'])
    <img src="{{ Storage::url($row['image_path']) }}" alt="Road sign for this question" class="ml-9 mb-3 max-h-28 w-auto object-contain">
@endif
```

- [ ] **Step 5: Run tests to verify they pass**

Run: `php artisan test --compact --filter=TestResult`
Expected: PASS (all existing + new).

- [ ] **Step 6: Format + commit**

```bash
vendor/bin/pint --dirty --format agent
git add app/Livewire/Test/TestResult.php resources/views/livewire/test/test-result.blade.php tests/Feature/Livewire/Test/TestResultTest.php
git commit -m "feat: show road sign image in test result question review"
```

---

### Task 5: Sign image on flash-card front

**Files:**
- Modify: `resources/views/livewire/study/flash-card.blade.php:31-39` (card front)
- Test: `tests/Feature/Livewire/Study/FlashCardTest.php`

**Interfaces:**
- Consumes: `Question.image_path` from Task 2.
- Produces: nothing consumed later.

- [ ] **Step 1: Write the failing test**

Add to `tests/Feature/Livewire/Study/FlashCardTest.php`:

```php
it('shows the sign image on the card front when present', function () {
    $category = Category::factory()->create();
    Question::factory()->create([
        'category_id' => $category->id,
        'image_path' => 'signs/no-entry.svg',
    ]);

    livewire(FlashCard::class, ['categorySlug' => $category->slug])
        ->assertSeeHtml('signs/no-entry.svg');
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --compact --filter="shows the sign image on the card front"`
Expected: FAIL.

- [ ] **Step 3: Update the card front**

In `resources/views/livewire/study/flash-card.blade.php`, replace the question-mark icon block on the card front (the `div` at lines 33–35 containing the `?` SVG) with an image-or-icon conditional. The card is a fixed `h-72`, so cap the image height:

```blade
@if ($this->currentQuestion->image_path)
    <img src="{{ Storage::url($this->currentQuestion->image_path) }}" alt="Road sign for this question" class="mb-4 max-h-24 w-auto object-contain">
@else
    <div class="w-8 h-8 rounded-lg bg-road-yellow/10 border border-road-yellow/20 flex items-center justify-center mb-4">
        <svg class="w-4 h-4 text-road-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>
@endif
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `php artisan test --compact --filter=FlashCard`
Expected: PASS (all existing + new).

- [ ] **Step 5: Commit**

```bash
git add resources/views/livewire/study/flash-card.blade.php tests/Feature/Livewire/Study/FlashCardTest.php
git commit -m "feat: show road sign image on flash card front"
```

---

## Post-implementation notes (for the final report, not extra tasks)

- Local/production: images only appear after `php artisan db:seed --class=QuestionSeeder` runs (publishes files + sets `image_path`) and `storage:link` exists.
- Full suite sanity check at the end: `php artisan test --compact`.
- Out of scope (deliberate): road-marking illustrations (broken yellow line, chevrons, yellow box), Filament `FileUpload` still accepts only jpeg/png/webp for admin uploads (seeded SVGs bypass upload; widen `acceptedFileTypes` later if admins need to upload SVGs).

### Final whole-branch review fixes (post Task 5, before merge)

The final review caught one more content-correctness bug of the same class as the hydrant/hospital one: `lanes-merge.svg` and `merge-right.svg` were visually identical (single arrow + one off-center merge curve), but map to two questions whose correct answers are each other's wrong-answer distractor ("Merging traffic ahead" vs "Dual carriageway ends ahead"). `lanes-merge.svg` was redrawn as a symmetric two-line funnel converging to a point, distinct from `merge-right.svg`'s asymmetric single-side curve. Two minor cleanups rode along: `hospital.svg` (orphaned since the hydrant fix) was deleted, and `walk.svg`'s figure was recolored from white to green (`#1f9d3a`) to match the correct-answer explanation text ("usually a green walking figure"). One commit, `f82bd6f`.

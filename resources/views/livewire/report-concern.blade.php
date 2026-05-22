<div>
    @if ($submitted)
        <p class="mt-4 flex items-center gap-1.5 text-xs text-go-green">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Report received — thank you.
        </p>
    @else
        <flux:modal.trigger name="report-concern-{{ $questionId }}">
            <button
                type="button"
                class="mt-4 flex items-center gap-1.5 text-xs text-zinc-600 hover:text-zinc-400 transition-colors"
            >
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6H9.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                </svg>
                Report an issue
            </button>
        </flux:modal.trigger>

        <flux:modal name="report-concern-{{ $questionId }}" class="md:w-sm" @close="$wire.reportType = ''; $wire.description = ''">
            <div class="space-y-4">
                <div>
                    <flux:heading size="lg">Report an issue</flux:heading>
                    <flux:text class="mt-1">What's the problem with this question?</flux:text>
                </div>

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
                            <span class="text-xs leading-snug">{{ $type->getLabel() }}</span>
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
                    <flux:modal.close>
                        <button type="button" class="text-xs text-zinc-500 hover:text-zinc-300 transition-colors">
                            Cancel
                        </button>
                    </flux:modal.close>
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
        </flux:modal>
    @endif
</div>

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

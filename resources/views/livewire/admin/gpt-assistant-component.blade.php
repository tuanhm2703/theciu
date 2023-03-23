<div>
    <textarea wire:model.lazy="question" id="" cols="30" rows="10"></textarea>
    <button wire:click="askQuestion">Submit</button>
    <div>{!! $answer !!}</div>
</div>

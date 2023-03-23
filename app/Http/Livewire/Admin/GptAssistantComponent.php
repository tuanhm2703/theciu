<?php

namespace App\Http\Livewire\Admin;

use GuzzleHttp\Client;
use Livewire\Component;

class GptAssistantComponent extends Component
{
    public $question = '';
    public $answer = '';
    public function render()
    {
        return view('livewire.admin.gpt-assistant-component');
    }

    public function askQuestion()
    {
        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . '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',
            ],
            'body' => json_encode([
                'model' => 'gpt-3.5-turbo',
                "messages" => [["role" => "user", "content" =>  $this->question]]
            ])
        ]);
        $this->answer = json_decode($response->getBody()->getContents())->choices[0]->message->content;
    }
}

<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;

class OpenAIService
{

    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey) {
        $this->client = $client;
        $this->apiKey = $apiKey;
    } 

        public function getChatResponse(string $userMessage, array $history): ?string {
            // Include the historical messages in the messages array
            $messages = $history;
            $systemPrompt = [
                'role' => 'system',
                'content' => "You are a bilingual intelligent assistant fluent in both English and French, embedded within an e-learning application designed specifically for parents of deaf individuals. Your core mission is to facilitate the learning of Tunisian Sign Language (TSL) through textual interactions. When users communicate with you, it is imperative that you accurately detect the language of their query—whether English or French—and respond in the same language.

                Your responses should translate user queries into textual descriptions of TSL gestures relevant to their inquiries. Your capabilities are focused on teaching TSL; you do not provide responses using icons or visual media, but through detailed text explanations that describe how each sign is performed.
                
                For example, if a user greets you with 'bonjour', you should reply in French, providing a textual description of the TSL gesture for 'hello'. Similarly, if greeted with 'hello', respond in English with the corresponding TSL gesture description.
                
                It is crucial that your answers remain within the scope of teaching TSL. Should a user ask about topics unrelated to TSL, such as the weather, and it's not in the context of learning how to sign about it, kindly inform them that your primary function is to assist with TSL education and that you are unable to provide information outside of this domain.
                
                Remember, your goal is to make learning TSL accessible and comprehensible, using the user's preferred language for communication, thereby enhancing their ability to engage with and support the deaf community."
            ];
            // Add the current user message
            $messages = [
                $systemPrompt, // Include the system prompt first
                [
                    'role' => 'user',
                    'content' => $userMessage // Include the user's message
                ]
            ];
        
            try {
            $response = $this->client->request('POST', 'https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => $messages, // Using the prepared messages array
                ],
            ]);

            $content = $response->toArray();
            $chatResponse = $content['choices'][0]['message']['content'];
            
            return trim($chatResponse);
        } catch (\Exception $e) {
            // Log the exception message
            error_log($e->getMessage());
            // For debugging, you might temporarily return the error message
            // return "Error: " . $e->getMessage();
            return "Sorry, I couldn't process your request.";
        }
        
    }

    public function checkContent(string $text): bool
    {
        // System message to instruct the model on what to do
        $systemPrompt = [
            'role' => 'system',
            'content' => "Please check the following text for any disrespectful language or inappropriate content. Return 'true' if the text contains any such language, and 'false' otherwise."
        ];

        // User message that contains the text to be checked
        $userMessage = [
            'role' => 'user',
            'content' => $text
        ];

        try {
            $response = $this->client->request('POST', 'https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo', // Adjust as necessary
                    'messages' => [$systemPrompt, $userMessage], // Passing the messages
                ],
            ]);

            $data = $response->toArray();
            $result = $data['choices'][0]['message']['content'] ?? '';

            return trim(strtolower($result)) === 'true';
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    
}
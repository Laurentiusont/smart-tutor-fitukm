<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\PageNoun;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ChatHistoryController extends Controller
{
    public function saveMessage(Request $request)
    {
        // Validasi request
        $validated = $request->validate([
            'user_id' => 'required|string',
            'topic_guid' => 'required|string',
            'message' => 'required|string',
            'sender' => 'required|in:user,bot,cosine,openai',
            'page' => 'required|integer',
            'question_guid' => 'required|string',
        ]);

        sleep(1); // Delay 1 detik

        // Jika yang mengirim adalah bot atau cosine, simpan ke chat history
        if (in_array($validated['sender'], ['bot', 'cosine', 'openai'])) {
            ChatHistory::create($validated);
            return response()->json(['status' => 'question_saved']);
        }

        // Untuk pengirim user, simpan respons pengguna
        $chatHistory = ChatHistory::create(array_merge($validated, ['cosine_similarity' => null]));

        // Ambil pertanyaan yang sesuai
        $question = Question::where('guid', $validated['question_guid'])->first();
        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        // Hitung cosine similarity antara jawaban pengguna dan jawaban yang benar
        $similarityResult = $this->calculateCosineSimilarity($validated['message'], $question->answer_fix, $validated['page'], $validated['topic_guid'], $question->language, $question->question_fix);
        // Simpan nilai cosine similarity ke chat history
        $similarity_score = $similarityResult['similarity_score'];

        // Ambil data cosine per noun
        $noun_cosine_data = $similarityResult['noun_cosine_data'];

        // Simpan nilai cosine similarity ke chat history
        $chatHistory->update(['cosine_similarity' => $similarity_score]);

        // Persiapkan pesan untuk ditampilkan
        $similarityMessage = "<p><strong>Cosine Similarity Score:</strong> " . number_format($similarity_score, 2) . "%</p>";

        // Menambahkan data cosine similarity per noun
        if (!empty($noun_cosine_data)) {
            // Sorting noun_cosine_data berdasarkan cosine_answer
            usort($noun_cosine_data, function ($a, $b) {
                return $b['cosine_answer'] <=> $a['cosine_answer']; // Mengurutkan descending berdasarkan cosine_answer
            });

            $similarityMessage .= "<ul>";
            foreach ($noun_cosine_data as $nounData) {
                $similarityMessage .= "<li><strong>Noun:</strong> " .
                    htmlspecialchars($nounData['noun']['noun']) . " - <strong>Similarity Page:</strong> " .
                    number_format($nounData['noun']['cosine_similarity'] * 100, 2) . "% - " .
                    "<strong>Similarity Answer:</strong> " .
                    number_format($nounData['cosine_answer'] * 100, 2) . "%</li>";
            }
            $similarityMessage .= "</ul>";
        }


        // Tentukan apakah nilai similarity mencapai threshold
        if ($similarity_score >= $question->threshold) {
            return $this->responseForSuccess($validated, $validated['page'], $similarityMessage, $similarity_score, $question->threshold, $noun_cosine_data, $similarityResult['answer_ai']);
        }

        // Jika tidak, periksa pertanyaan yang tersisa pada halaman ini
        return $this->responseForRetry($validated, $similarityMessage, $similarity_score, $question->threshold, $question->language, $similarityResult['answer_ai']);
    }



    /**
     * Calculate cosine similarity by calling the Flask API.
     */
    protected function calculateCosineSimilarity($user_answer, $actual_answer, $page, $topic_guid, $language, $question)
    {
        // Ambil semua nouns dan nilai cosine untuk halaman yang relevan
        $pageNouns = PageNoun::where('topic_guid', $topic_guid)
            ->where('language', $language)
            ->where('page', $page)
            ->get();

        // Format data untuk dikirim ke Flask
        $nounsData = $pageNouns->map(function ($item) {
            return [
                'noun' => $item->noun,
                'cosine_similarity' => $item->cosine, // Cosine yang sudah ada di database
            ];
        })->toArray();

        $nounsDataJson = json_encode($nounsData);

        // Kirimkan data ke API Flask
        $flask_url = env('FLASK_API_URL') . '/cosine_similarity';
        $response = Http::post($flask_url, [
            'user_answer' => $user_answer,
            'actual_answer' => $actual_answer,
            'nouns' => $nounsDataJson, // Mengirimkan data nouns dan cosine
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to calculate cosine similarity');
        }

        $responseData = $response->json();

        $answerAI = Http::post(env('FLASK_API_URL') . '/answer_ai', [
            'question' => $question
        ]);

        // Mengembalikan skor similarity dan data cosine per noun
        return [
            'similarity_score' => $responseData['actual_similarity_score'] * 100, // Skor similarity secara keseluruhan
            'noun_cosine_data' => $responseData['noun_similarities'], // Data cosine per noun
            'answer_ai' => strval($answerAI)
        ];
    }


    /**
     * Prepare success response for when the similarity score meets the threshold.
     */
    protected function responseForSuccess($validated, $currentPage, $similarityMessage, $similarity_score, $threshold, $noun_cosine_data, $answer_ai)
    {
        return response()->json([
            'status' => 'success',
            'nextPage' => $currentPage + 1,
            'similarityMessage' => $similarityMessage,
            'similarity_score' => $similarity_score,
            'threshold' => $threshold,
            'noun_cosine_data' => $noun_cosine_data, // Menambahkan data cosine per noun
            'answer_ai' => $answer_ai
        ]);
    }


    /**
     * Prepare retry response for when the similarity score is below the threshold.
     */
    protected function responseForRetry($validated, $similarityMessage, $similarity_score, $threshold, $language, $answer_ai)
    {
        // Get already asked questions for this topic and page
        $askedQuestions = ChatHistory::where('user_id', $validated['user_id'])
            ->where('topic_guid', $validated['topic_guid'])
            ->where('page', $validated['page'])
            ->pluck('question_guid')
            ->toArray();

        // Find remaining questions for this topic and page
        $remainingQuestions = Question::where('topic_guid', $validated['topic_guid'])
            ->where('page', $validated['page'])
            ->where('language', $language)
            ->where('user_id', null)
            ->whereNotIn('guid', $askedQuestions)
            ->get();

        // Simpan message similarity ke history dengan HTML
        ChatHistory::create([
            'user_id' => $validated['user_id'],
            'topic_guid' => $validated['topic_guid'],
            'message' => $similarityMessage,  // HTML disimpan di sini
            'sender' => 'cosine',
            'page' => $validated['page'],
            'question_guid' => $validated['question_guid'],
            'cosine_similarity' => null,
        ]);

        usleep(1000000);
        ChatHistory::create([
            'user_id' => $validated['user_id'],
            'topic_guid' => $validated['topic_guid'],
            'message' => strval($answer_ai),  // HTML disimpan di sini
            'sender' => 'openai',
            'page' => $validated['page'],
            'question_guid' => $validated['question_guid'],
            'cosine_similarity' => null
        ]);
        // Jika tidak ada pertanyaan yang tersisa, beri tahu untuk regenerasi
        if ($remainingQuestions->isEmpty()) {
            return response()->json([
                'status' => 'no_questions_left',
                'message' => 'No remaining questions. Would you like to regenerate questions?',
                'similarityMessage' => $similarityMessage,  // HTML disertakan dalam response
                'similarity_score' => $similarity_score,
                'answer_ai' => $answer_ai
            ]);
        }

        // Jika masih ada pertanyaan tersisa, ambil pertanyaan berikutnya
        $nextQuestion = $remainingQuestions->random();

        usleep(1000000); // Delay untuk simulasi

        // Simpan pertanyaan retry ke dalam chat history dengan HTML
        $retryMessage = '<div class="bot-message">' .
            'Retry required! <br>' .
            '<strong>Page:</strong> ' . $validated['page'] . ' <br>' .
            '<strong>Threshold:</strong> ' . ($threshold ?? "N/A") . ' <br>' .
            '<strong>Message:</strong> ' . $nextQuestion->question_fix .
            '</div>';

        ChatHistory::create([
            'user_id' => $validated['user_id'],
            'topic_guid' => $validated['topic_guid'],
            'message' => $retryMessage,  // HTML retry message disimpan di sini
            'sender' => 'bot',
            'page' => $validated['page'],
            'question_guid' => $nextQuestion->guid,
            'cosine_similarity' => null,
        ]);

        // Ambil data nouns dan cosine untuk halaman ini
        $nounsData = PageNoun::where('page', $validated['page'])
            ->where('topic_guid', $validated['topic_guid'])
            ->where('language', $language)
            ->get();

        $nounsCosineData = $nounsData->map(function ($item) {
            return [
                'noun' => $item->noun,
                'cosine_similarity' => $item->cosine,  // Nilai cosine dari database
            ];
        });

        return response()->json([
            'status' => 'retry',
            'nextQuestion' => $retryMessage,
            'nextQuestionGuid' => $nextQuestion->guid,
            'similarityMessage' => $similarityMessage,  // HTML disertakan
            'similarity_score' => $similarity_score,
            'threshold' => $threshold,
            'nouns_cosine_data' => $nounsCosineData,  // Data noun cosine
            'answer_ai' => $answer_ai
        ]);
    }



    public function regenerateQuestions(Request $request)
    {
        set_time_limit(2000);

        // Validasi input dari pengguna
        $validated = $request->validate([
            'user_id' => 'required|string',
            'topic_guid' => 'required|string',
            'page' => 'required|integer',
            'regenerate' => 'required|string',  // Validate regenerate as string ('true' or 'false')
        ]);

        // Convert regenerate string ('true'/'false') to boolean
        $isRegenerate = filter_var($validated['regenerate'], FILTER_VALIDATE_BOOLEAN);

        // Ambil topik berdasarkan topic_guid
        $topic = Topic::where('guid', $validated['topic_guid'])->first();
        if (!$topic) {
            return response()->json(['status' => 'error', 'message' => 'Topic not found.']);
        }

        // Ambil attempt terakhir yang digunakan oleh user_id untuk topik ini
        $userLastAttempt = Question::where('user_id', $validated['user_id'])
            ->where('topic_guid', $validated['topic_guid'])
            ->max('attempt'); // Cari nilai attempt tertinggi

        // Tentukan attempt saat ini
        $currentAttempt = $userLastAttempt ? $userLastAttempt + 1 : 1;

        // Cek apakah attempt yang diizinkan masih ada
        if ($currentAttempt > $topic->max_attempt_gpt) {
            return response()->json([
                'status' => 'no_attempts_left',
                'message' => 'You have reached the maximum attempts for this topic. Proceeding without regeneration.',
            ]);
        }

        // Jika regenerasi diinginkan dan masih ada sisa attempt
        if ($isRegenerate) {
            // Proses regenerasi pertanyaan
            $askedQuestions = ChatHistory::where('user_id', $validated['user_id'])
                ->where('topic_guid', $validated['topic_guid'])
                ->where('page', $validated['page'])
                ->pluck('question_guid')
                ->toArray();

            // Ambil pertanyaan yang sudah diajukan berdasarkan GUID
            $existingQuestions = Question::whereIn('guid', $askedQuestions)
                ->pluck('question_fix')
                ->toArray();

            // Ambil path file PDF dari topik
            $pdf_file_path = $topic->file_path;

            // Menentukan path lengkap menggunakan storage_path
            $full_pdf_path = storage_path('app/public/' . $pdf_file_path);

            // Memeriksa apakah file PDF ada
            if (!file_exists($full_pdf_path)) {
                // Mengembalikan response error jika file tidak ditemukan
                return response()->json(['status' => 'error', 'message' => 'PDF file not found at ' . $full_pdf_path]);
            }

            // Mengambil konten file PDF

            // Ambil data terakhir dari tabel chathistory untuk user_id dan topic_guid yang sesuai
            $lastChatHistory = ChatHistory::where('user_id', $validated['user_id'])
                ->where('topic_guid', $validated['topic_guid'])
                ->orderBy('created_at', 'desc')
                ->first();

            // Jika ada record chathistory terakhir, ambil question_guid-nya
            if ($lastChatHistory) {
                $questionGuidFromHistory = $lastChatHistory->question_guid;

                // Cari threshold berdasarkan question_guid dari tabel question
                $lastQuestion = Question::where('guid', $questionGuidFromHistory)->first();
                $language = $lastQuestion->language;

                // Tentukan nilai threshold dari pertanyaan terakhir
                $threshold = $lastQuestion ? $lastQuestion->threshold : null;
            } else {
                // Jika tidak ada record chathistory, threshold bisa null atau nilai default lainnya
                $threshold = null;
            }

            // Kirim file PDF ke Flask untuk mendapatkan pertanyaan baru
            $response = Http::attach('pdf', file_get_contents($full_pdf_path), 'file.pdf')
                ->timeout(1500)
                ->post(env('FLASK_API_URL') . '/regenerate', [
                    'page' => $validated['page'],
                    'language' => $language,
                    'existing_questions' => json_encode($existingQuestions), // Encode array to JSON
                ]);



            Log::info('Flask API Response:', [
                'status' => $response->status(),
                'body' => $response->body(),
                'json' => $response->json() // Bisa dicatat dalam format JSON jika diperlukan
            ]);

            // Periksa apakah API Flask berhasil
            if ($response->failed()) {
                return response()->json(['status' => 'error', 'message' => 'Failed to regenerate questions.']);
            }

            // Ambil pertanyaan baru dari response Flask
            $newQuestion = $response->json()['data']['questions'][0];

            // Simpan pertanyaan baru ke database dengan increment attempt

            $question = Question::create([
                'question_ai' => $newQuestion['question'],
                'question_fix' => $newQuestion['question'],
                'answer_ai' => $newQuestion['answer'],
                'answer_fix' => $newQuestion['answer'],
                'topic_guid' => $validated['topic_guid'],
                'category' => $newQuestion['category'],
                'user_id' => $validated['user_id'],
                'page' => $validated['page'],
                'attempt' => $currentAttempt, // Increment attempt untuk setiap user
                'language' => $language,
                'weight' => 0,
                'threshold' => $threshold, // Menggunakan threshold dari pertanyaan terakhir
            ]);

            $chat = ChatHistory::create([
                'user_id' => $validated['user_id'],
                'topic_guid' => $validated['topic_guid'],
                'message' => '<div class="bot-message">
                                Retry required! <br>
                                <strong>Page:</strong> ' . $validated['page'] . ' <br>
                                <strong>Threshold:</strong> ' . ($question['threshold'] ?? "N/A") . ' <br>
                                <strong>Message:</strong> ' . $question['question_fix'] . '
                              </div>',
                'sender' => 'bot',
                'page' => $validated['page'],
                'question_guid' => $question->guid,
                'cosine_similarity' => null,
            ]);



            // Kirim respons sukses dengan pertanyaan baru
            return response()->json([
                'status' => 'success',
                'message' => 'Questions have been regenerated successfully.',
                'newQuestion' => $chat,  // Pertanyaan baru dari Flask
            ]);
        }
    }




    public function getHistory($topicGuid, $userId)
    {
        // Mendapatkan history berdasarkan user_id dan topic_guid
        $history = ChatHistory::where('user_id', $userId)
            ->where('topic_guid', $topicGuid)
            ->orderBy('created_at')
            ->get();

        // Pastikan ada data history
        if ($history->isEmpty()) {
            $language = null;
        } else {
            // Ambil question_guid dari record pertama (atau bisa diubah sesuai kebutuhan)
            $questionGuid = $history->first()->question_guid;

            // Query ke tabel Question berdasarkan question_guid untuk mengambil bahasa
            $question = Question::where('guid', $questionGuid)->first();

            // Cek apakah data question ditemukan
            if (!$question) {
                return response()->json(['message' => 'Question not found'], 404);
            }

            // Ambil bahasa dari question (asumsi field 'language' ada pada tabel Question)
            $language = $question->language;
        }

        // Cek apakah pesan terakhir dari sender 'cosine'
        $lastMessage = $history->last();
        $regenerate = 'no';  // Default regenerate

        if ($lastMessage && $lastMessage->sender === 'cosine') {
            // Ambil cosine similarity dari pesan terakhir
            $cosineSimilarity = $lastMessage->cosine_similarity;

            // Ambil threshold dari pertanyaan terkait
            $threshold = $question->threshold;

            // Cek apakah cosine similarity lebih besar atau sama dengan threshold
            if ($cosineSimilarity >= $threshold) {
                $regenerate = 'no';
            } else {
                // Jika cosine similarity kurang dari threshold, cek apakah ada pertanyaan yang tersisa
                $askedQuestions = ChatHistory::where('user_id', $userId)
                    ->where('topic_guid', $topicGuid)
                    ->where('page', $history->last()->page)
                    ->pluck('question_guid')
                    ->toArray();

                // Cari pertanyaan yang belum diajukan
                $remainingQuestions = Question::where('topic_guid', $topicGuid)
                    ->where('page', $history->last()->page)
                    ->where('language', $language)
                    ->whereNull('user_id')  // Pertanyaan yang belum diajukan
                    ->whereNotIn('guid', $askedQuestions)
                    ->get();

                // Jika tidak ada pertanyaan yang tersisa
                if ($remainingQuestions->isEmpty()) {
                    $regenerate = 'yes';
                }
            }
        }

        // Mengembalikan data history, language dan regenerate
        return response()->json([
            'data' => $history,
            'language' => $language,
            'regenerate' => $regenerate  // Mengembalikan key regenerate
        ]);
    }


    public function checkStatus($topicGuid, $userId)
    {
        // Mendapatkan topik berdasarkan GUID
        $topic = Topic::where('guid', $topicGuid)->first();

        if (!$topic) {
            return response()->json(['error' => 'Topic not found'], 404);
        }

        // Memeriksa apakah waktu selesai topik sudah lewat
        $timeEnd = new Carbon($topic->time_end);
        $isTimePassed = $timeEnd->isPast();

        // Mendapatkan nomor page terakhir dari chat history user

        // Menentukan status is_read_only berdasarkan waktu atau penyelesaian halaman terakhir
        $isReadOnly = $isTimePassed;

        return response()->json(['data' => [
            'is_read_only' => $isReadOnly,
        ]]);
    }
    public function getAvailableLanguages($topicGuid)
    {
        // Ambil bahasa unik dari tabel pertanyaan berdasarkan topik
        $languages = Question::where('topic_guid', $topicGuid)
            ->select('language')
            ->distinct()
            ->pluck('language');

        return response()->json(['data' => $languages]);
    }

    public function resetHistories(Request $request)
    {
        // Validasi input untuk memastikan user_id dan topic_guid diberikan
        $validated = $request->validate([
            'user_id' => 'required|string',
            'topic_guid' => 'required|string',
        ]);

        // Hapus semua chat histories berdasarkan user_id dan topic_guid
        $deleted = ChatHistory::where('user_id', $validated['user_id'])
            ->where('topic_guid', $validated['topic_guid'])
            ->delete();

        Question::where('user_id', $validated['user_id'])
            ->where('topic_guid', $validated['topic_guid'])
            ->delete();

        // Periksa apakah ada data yang dihapus
        if ($deleted) {
            return response()->json([
                'message' => 'Chat histories have been successfully reset.',
            ], 200); // Respon sukses
        } else {
            return response()->json([
                'message' => 'No chat histories found for the given user and topic.',
            ], 404); // Respon jika tidak ada data ditemukan
        }
    }
}

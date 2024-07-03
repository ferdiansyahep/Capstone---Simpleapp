<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestRequest;
use App\Models\Question;

class TestController extends Controller
{
    public function index()
    {
        $categories = Category::with(['categoryQuestions' => function ($query) {
                $query->inRandomOrder()
                    ->with(['questionOptions' => function ($query) {
                        $query->inRandomOrder();
                    }]);
            }])
            ->whereHas('categoryQuestions')
            ->get();

        return view('client.test', compact('categories'));
    }

        public function store(StoreTestRequest $request)
        {
        // Ambil semua opsi yang dipilih dari permintaan
        $selectedOptions = array_values($request->input('questions'));

        // Temukan semua opsi yang sesuai dengan id yang dipilih
        $options = Option::find($selectedOptions);

        // Hitung total poin dari semua opsi yang dipilih
        $totalPoints = $options->sum('points');

        $totalQuestions = count($selectedOptions);

        // Hitung poin yang akan diberikan kepada pengguna berdasarkan sistem poin
        // 100 poin dibagi dengan jumlah total pertanyaan
        $pointPerQuestion = 100 / $totalQuestions;

        // Hitung poin tambahan jika jawaban benar
        $correctOptions = $options->filter(function ($option) {
            return $option->is_correct;
        });

        $correctPoints = $correctOptions->count() * $pointPerQuestion;

        // Hitung total poin akhir yang akan diberikan kepada pengguna
        $finalPoints = $totalPoints + $correctPoints;

        // Buat hasil tes untuk pengguna
        $result = auth()->user()->userResults()->create([
            'total_points' => $finalPoints
        ]);

        // Persiapkan data pertanyaan yang dijawab oleh pengguna
        $questions = $options->mapWithKeys(function ($option) use ($pointPerQuestion) {
            $points = $option->is_correct ? $pointPerQuestion + $option->points : 0;
            return [
                $option->question_id => [
                    'option_id' => $option->id,
                    'points' => $points
                ]
            ];
        })->toArray();
        // Sisipkan data pertanyaan ke dalam hasil tes pengguna
        $result->questions()->sync($questions);

        // Redirect ke halaman hasil tes
        return redirect()->route('client.results.show', $result->id);
    }


    public function calculateAndAddPoints()
    {
        // Ambil semua pertanyaan
        $questions = Question::all();
    
        // Hitung total pertanyaan
        $totalQuestions = $questions->count();
    
        // Tentukan jumlah poin untuk setiap pertanyaan
        $pointsPerQuestion = 100 / $totalQuestions;
    
        // Loop melalui setiap pertanyaan
        foreach ($questions as $question) {
        // Lakukan sesuatu untuk memeriksa jawaban yang benar
        if ($question->is_correct) {
            // Tambahkan poin untuk jawaban yang benar
            $question->points += $pointsPerQuestion;
            // Simpan perubahan
            $question->save();
        }
    }

    // Redirect atau kembalikan respons sesuai kebutuhan aplikasi Anda
    }
}

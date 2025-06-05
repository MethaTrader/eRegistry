<?php

namespace App\Http\Controllers;

use App\Services\TrainingService;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function __construct(
        private TrainingService $trainingService
    ) {}

    /**
     * Display the training materials page.
     */
    public function index()
    {
        $trainingVideos = $this->trainingService->getAllVideos();
        $categories = $this->trainingService->getCategories();

        return view('training.index', compact('trainingVideos', 'categories'));
    }

    /**
     * Show a specific training video
     */
    public function show($id)
    {
        // In a real application, you'd fetch this from database
        $video = [
            'id' => $id,
            'title' => 'Training Video',
            'description' => 'Training video description',
            'video_path' => "training/video-{$id}.mp4"
        ];

        return view('training.show', compact('video'));
    }
}
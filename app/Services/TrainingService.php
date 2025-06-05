<?php

namespace App\Services;

class TrainingService
{
    /**
     * Get all training videos with metadata
     */
    public function getAllVideos(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'System Overview and Navigation',
                'description' => 'Complete overview of the eRegistry system and basic navigation',
                'duration' => '1:00',
                'category' => 'Getting Started',
                'difficulty' => 'Beginner',
                'video_path' => 'training/system-overview.mp4',
                'thumbnail' => 'training/thumbnails/system-overview.jpg',
                'tags' => ['overview', 'navigation', 'introduction'],
                'order' => 1
            ],
            [
                'id' => 2,
                'title' => 'Adding a New Patient',
                'description' => 'Step-by-step guide to register new patients in the system',
                'duration' => '0:45',
                'category' => 'Patient Management',
                'difficulty' => 'Beginner',
                'video_path' => 'training/add-patient.mp4',
                'thumbnail' => 'training/thumbnails/add-patient.jpg',
                'tags' => ['patients', 'registration', 'basics'],
                'order' => 2
            ],
            [
                'id' => 3,
                'title' => 'Creating Monitoring Records',
                'description' => 'How to add new monitoring entries for patient tracking',
                'duration' => '1:00',
                'category' => 'Monitoring',
                'difficulty' => 'Intermediate',
                'video_path' => 'training/add-monitoring.mp4',
                'thumbnail' => 'training/thumbnails/add-monitoring.jpg',
                'tags' => ['monitoring', 'records', 'tracking'],
                'order' => 3
            ],
            [
                'id' => 4,
                'title' => 'Generating Reports and PDFs',
                'description' => 'How to generate and export reports in PDF and Excel formats',
                'duration' => '0:50',
                'category' => 'Reports',
                'difficulty' => 'Intermediate',
                'video_path' => 'training/reports.mp4',
                'thumbnail' => 'training/thumbnails/reports.jpg',
                'tags' => ['reports', 'pdf', 'excel', 'export'],
                'order' => 5
            ]
        ];
    }

    /**
     * Get videos by category
     */
    public function getVideosByCategory(string $category): array
    {
        return array_filter($this->getAllVideos(), function($video) use ($category) {
            return $video['category'] === $category;
        });
    }

    /**
     * Get videos by difficulty level
     */
    public function getVideosByDifficulty(string $difficulty): array
    {
        return array_filter($this->getAllVideos(), function($video) use ($difficulty) {
            return $video['difficulty'] === $difficulty;
        });
    }

    /**
     * Get video by ID
     */
    public function getVideoById(int $id): ?array
    {
        $videos = $this->getAllVideos();
        foreach ($videos as $video) {
            if ($video['id'] === $id) {
                return $video;
            }
        }
        return null;
    }

    /**
     * Get all unique categories
     */
    public function getCategories(): array
    {
        $categories = array_unique(array_column($this->getAllVideos(), 'category'));
        sort($categories);
        return $categories;
    }

    /**
     * Get all unique difficulty levels
     */
    public function getDifficultyLevels(): array
    {
        return ['Beginner', 'Intermediate', 'Advanced'];
    }

    /**
     * Search videos by title or tags
     */
    public function searchVideos(string $query): array
    {
        $query = strtolower($query);
        return array_filter($this->getAllVideos(), function($video) use ($query) {
            $title = strtolower($video['title']);
            $tags = implode(' ', $video['tags']);
            $description = strtolower($video['description']);

            return strpos($title, $query) !== false ||
                strpos($tags, $query) !== false ||
                strpos($description, $query) !== false;
        });
    }

    /**
     * Check if video file exists
     */
    public function videoExists(string $videoPath): bool
    {
        return file_exists(storage_path('app/public/' . $videoPath));
    }

    /**
     * Get video file URL
     */
    public function getVideoUrl(string $videoPath): string
    {
        return asset('storage/' . $videoPath);
    }

    /**
     * Get thumbnail URL
     */
    public function getThumbnailUrl(string $thumbnailPath): string
    {
        if (file_exists(storage_path('app/public/' . $thumbnailPath))) {
            return asset('storage/' . $thumbnailPath);
        }

        // Return placeholder if thumbnail doesn't exist
        return asset('assets/img/video-placeholder.jpg');
    }

    /**
     * Get recommended videos based on current video
     */
    public function getRecommendedVideos(int $currentVideoId, int $limit = 3): array
    {
        $currentVideo = $this->getVideoById($currentVideoId);
        if (!$currentVideo) {
            return [];
        }

        $allVideos = $this->getAllVideos();

        // Filter out current video
        $otherVideos = array_filter($allVideos, function($video) use ($currentVideoId) {
            return $video['id'] !== $currentVideoId;
        });

        // Sort by relevance (same category first, then by difficulty)
        usort($otherVideos, function(se$a, $b) use ($currentVideo) {
            if ($a['category'] === $currentVideo['category'] && $b['category'] !== $currentVideo['category']) {
                return -1;
            }
            if ($b['category'] === $currentVideo['category'] && $a['category'] !== $currentVideo['category']) {
                return 1;
            }
            return 0;
        });

        return array_slice($otherVideos, 0, $limit);
    }
}
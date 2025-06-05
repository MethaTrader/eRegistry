@extends('layouts.app')

@section('title', 'Training Materials')

@section('content')
    <div class="content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">Training Materials</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Page Title and Description -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-4">
                        <h1 class="mb-3">
                            <i class="fas fa-graduation-cap text-primary me-2"></i>
                            Training Materials & FAQ
                        </h1>
                        <p class="lead text-muted mb-0">
                            Learn how to use the eRegistry system with our comprehensive video tutorials
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Controls -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body py-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                    <input type="text" class="form-control" id="searchVideos" placeholder="Search training videos...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="categoryFilter">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="difficultyFilter">
                                    <option value="">All Levels</option>
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Training Videos Grid -->
        <div class="row" id="videosGrid">
            @foreach($trainingVideos as $video)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 video-card"
                     data-category="{{ $video['category'] }}"
                     data-difficulty="{{ $video['difficulty'] }}"
                     data-title="{{ strtolower($video['title']) }}"
                     data-tags="{{ implode(',', $video['tags']) }}">
                    <div class="card training-video-card h-100">
                        <!-- Video Thumbnail -->
                        <div class="video-thumbnail-container">
                            <div class="video-thumbnail" data-category="{{ $video['category'] }}">
                                <div class="play-overlay"
                                     data-video-id="{{ $video['id'] }}"
                                     data-video-title="{{ $video['title'] }}"
                                     data-video-path="{{ $video['video_path'] }}"
                                     data-video-url="{{ asset('storage/' . $video['video_path']) }}">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                                <div class="video-duration">{{ $video['duration'] }}</div>
                                <div class="difficulty-badge difficulty-{{ strtolower($video['difficulty']) }}">
                                    {{ $video['difficulty'] }}
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="video-category">
                                <span class="badge bg-primary">{{ $video['category'] }}</span>
                            </div>
                            <h5 class="card-title mt-2">{{ $video['title'] }}</h5>
                            <p class="card-text text-muted">{{ $video['description'] }}</p>

                            <!-- Tags -->
                            <div class="video-tags mt-3">
                                @foreach($video['tags'] as $tag)
                                    <span class="badge bg-light text-dark me-1">#{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer bg-transparent">
                            <button class="btn btn-primary btn-sm w-100 watch-video-btn"
                                    data-video-id="{{ $video['id'] }}"
                                    data-video-title="{{ $video['title'] }}"
                                    data-video-path="{{ $video['video_path'] }}"
                                    data-video-url="{{ asset('storage/' . $video['video_path']) }}">
                                <i class="fas fa-play me-2"></i>Watch Tutorial
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- No Results Message -->
        <div class="row" id="noResults" style="display: none;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search text-muted" style="font-size: 3rem;"></i>
                        <h3 class="mt-3 text-muted">No videos found</h3>
                        <p class="text-muted">Try adjusting your search criteria or filters</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Training Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="video-container">
                        <video id="trainingVideo"
                               class="w-100"
                               controls
                               controlsList="nodownload"
                               crossorigin="anonymous"
                               preload="metadata"
                               data-training-video="true">
                            <source src="" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="fullscreenBtn">
                        <i class="fas fa-expand me-2"></i>Fullscreen
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .training-video-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .training-video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .video-thumbnail-container {
            position: relative;
            overflow: hidden;
        }

        .video-thumbnail {
            height: 200px;
            background-size: cover;
            background-position: center;
            background-color: #f8f9fa;
            position: relative;
            cursor: pointer;
            background-image: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .play-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .video-thumbnail:hover .play-overlay {
            opacity: 1;
        }

        .play-button {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #667eea;
            transition: transform 0.3s ease;
        }

        .play-button:hover {
            transform: scale(1.1);
        }

        .video-duration {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .difficulty-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .difficulty-beginner {
            background: #28a745;
            color: white;
        }

        .difficulty-intermediate {
            background: #ffc107;
            color: #212529;
        }

        .difficulty-advanced {
            background: #dc3545;
            color: white;
        }

        .video-category {
            margin-bottom: 0;
        }

        .video-tags .badge {
            font-size: 10px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 0.75rem;
        }

        .card-text {
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .watch-video-btn {
            transition: all 0.3s ease;
        }

        .watch-video-btn:hover {
            transform: translateY(-1px);
        }

        .video-container {
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 400px;
        }

        #trainingVideo {
            max-height: 70vh;
        }

        .modal-xl {
            max-width: 90%;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .modal-xl {
                max-width: 95%;
                margin: 1rem;
            }

            .video-thumbnail {
                height: 160px;
            }

            .play-button {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
        }

        /* Loading placeholder for video thumbnails */
        .video-thumbnail::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .video-thumbnail::after {
            content: '\f04b';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: rgba(255,255,255,0.7);
            font-size: 24px;
        }
    </style>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchVideos');
            const categoryFilter = document.getElementById('categoryFilter');
            const difficultyFilter = document.getElementById('difficultyFilter');
            const videosGrid = document.getElementById('videosGrid');
            const noResults = document.getElementById('noResults');
            const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
            const trainingVideo = document.getElementById('trainingVideo');
            const videoModalLabel = document.getElementById('videoModalLabel');

            // Filter functionality
            function filterVideos() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedCategory = categoryFilter.value;
                const selectedDifficulty = difficultyFilter.value;
                const videoCards = document.querySelectorAll('.video-card');
                let visibleCount = 0;

                videoCards.forEach(card => {
                    const title = card.dataset.title;
                    const category = card.dataset.category;
                    const difficulty = card.dataset.difficulty;
                    const tags = card.dataset.tags;

                    const matchesSearch = !searchTerm ||
                        title.includes(searchTerm) ||
                        tags.includes(searchTerm);
                    const matchesCategory = !selectedCategory || category === selectedCategory;
                    const matchesDifficulty = !selectedDifficulty || difficulty === selectedDifficulty;

                    if (matchesSearch && matchesCategory && matchesDifficulty) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0) {
                    videosGrid.style.display = 'none';
                    noResults.style.display = 'block';
                } else {
                    videosGrid.style.display = 'flex';
                    noResults.style.display = 'none';
                }
            }

            // Add event listeners for filters
            searchInput.addEventListener('input', filterVideos);
            categoryFilter.addEventListener('change', filterVideos);
            difficultyFilter.addEventListener('change', filterVideos);

            // Video modal functionality
            document.querySelectorAll('.watch-video-btn, .play-overlay').forEach(element => {
                element.addEventListener('click', function() {
                    const videoId = this.dataset.videoId;
                    const videoTitle = this.dataset.videoTitle || 'Training Video';
                    // Используем одинаковый способ получения URL для всех элементов
                    const videoUrl = this.dataset.videoUrl || `{{ asset('storage') }}/training/video-${videoId}.mp4`;

                    // Update modal title
                    videoModalLabel.textContent = videoTitle;

                    // Set video source with cache-busting parameter
                    const cacheBuster = new Date().getTime();
                    const finalVideoUrl = `${videoUrl}?v=${cacheBuster}`;

                    // Clear previous sources
                    trainingVideo.innerHTML = '';

                    // Add source element
                    const source = document.createElement('source');
                    source.src = finalVideoUrl;
                    source.type = 'video/mp4';
                    trainingVideo.appendChild(source);

                    // Set additional attributes to prevent adblock detection
                    trainingVideo.setAttribute('crossorigin', 'anonymous');
                    trainingVideo.setAttribute('preload', 'metadata');

                    // Load the video
                    trainingVideo.load();

                    // Show modal
                    videoModal.show();
                });
            });

            // Pause video when modal closes
            document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
                trainingVideo.pause();
                trainingVideo.currentTime = 0;
            });

            // Fullscreen functionality
            document.getElementById('fullscreenBtn').addEventListener('click', function() {
                if (trainingVideo.requestFullscreen) {
                    trainingVideo.requestFullscreen();
                } else if (trainingVideo.mozRequestFullScreen) {
                    trainingVideo.mozRequestFullScreen();
                } else if (trainingVideo.webkitRequestFullscreen) {
                    trainingVideo.webkitRequestFullscreen();
                } else if (trainingVideo.msRequestFullscreen) {
                    trainingVideo.msRequestFullscreen();
                }
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (videoModal._isShown) {
                    switch(e.key) {
                        case ' ':
                        case 'k':
                            e.preventDefault();
                            if (trainingVideo.paused) {
                                trainingVideo.play();
                            } else {
                                trainingVideo.pause();
                            }
                            break;
                        case 'f':
                            e.preventDefault();
                            document.getElementById('fullscreenBtn').click();
                            break;
                        case 'Escape':
                            if (!document.fullscreenElement) {
                                videoModal.hide();
                            }
                            break;
                    }
                }
            });
        });
    </script>
@endpush
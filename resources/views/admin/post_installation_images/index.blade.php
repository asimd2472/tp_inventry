@extends('layouts.app')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('admin.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">Post Installation Images</div>
                        <div class="user-body">

                            <div class="row justify-content-center">
                                <div class="col-xl-12 col-md-12 col-12">
                                    @if($installationImages->isEmpty())
                                        <div class="empty-gallery-box">
                                            <i class="fa-solid fa-image"></i>
                                            <p>No installation images available yet.</p>
                                        </div>
                                    @else
                                        <div class="gallery-grid">
                                            @foreach($installationImages as $image)
                                                <div class="gallery-item">
                                                    <button type="button"
                                                            class="gallery-trigger"
                                                            data-full="{{ $image->image_url }}"
                                                            data-title="{{ $image->file_name ?? 'Installation image' }}">
                                                        <img src="{{ $image->image_url }}" alt="{{ $image->file_name ?? 'Installation image' }}" />
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="galleryLightbox" class="gallery-lightbox" aria-hidden="true">
        <div class="gallery-lightbox-inner">
            <button type="button" class="lightbox-close" aria-label="Close image view">&times;</button>
            <img id="lightboxImage" src="" alt="Expanded installation image" />
        </div>
    </div>

@endsection

@push('styles')
<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-top: 20px;
    }

    .gallery-item {
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.28);
        box-shadow: 0 12px 26px rgba(15, 23, 42, 0.08);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .gallery-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 30px rgba(15, 23, 42, 0.12);
    }

    .gallery-trigger {
        width: 100%;
        padding: 0;
        border: none;
        background: transparent;
        cursor: pointer;
        display: block;
    }

    .gallery-trigger img {
        display: block;
        width: 100%;
        height: auto;
        aspect-ratio: 4 / 3;
        object-fit: cover;
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .gallery-trigger:hover img {
        transform: scale(1.03);
        filter: saturate(1.08);
    }

    @media (max-width: 1200px) {
        .gallery-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .gallery-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 520px) {
        .gallery-grid {
            grid-template-columns: 1fr;
        }
    }

    .empty-gallery-box {
        text-align: center;
        padding: 48px 24px;
        border: 1px dashed #cbd5e1;
        border-radius: 18px;
        background: rgba(248, 250, 252, 0.9);
        color: #475569;
    }

    .empty-gallery-box i {
        font-size: 42px;
        margin-bottom: 12px;
        color: #94a3b8;
    }

    .empty-gallery-box p {
        margin: 0;
        font-size: 1rem;
    }

    .gallery-lightbox {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.82);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 9999;
    }

    .gallery-lightbox.active {
        display: flex;
    }

    .gallery-lightbox-inner {
        position: relative;
        max-width: 92vw;
        max-height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        border-radius: 20px;
        padding: 14px;
        box-shadow: 0 30px 80px rgba(15, 23, 42, 0.35);
    }

    .gallery-lightbox-inner img {
        display: block;
        width: auto;
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
        border-radius: 12px;
    }

    .lightbox-close {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 50%;
        background: rgba(15, 23, 42, 0.8);
        color: #fff;
        font-size: 24px;
        line-height: 1;
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lightbox = document.getElementById('galleryLightbox');
        const lightboxImage = document.getElementById('lightboxImage');
        const closeBtn = document.querySelector('.lightbox-close');

        document.querySelectorAll('.gallery-trigger').forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                const fullUrl = trigger.dataset.full;
                if (!fullUrl) return;

                lightboxImage.src = fullUrl;
                lightbox.classList.add('active');
                lightbox.setAttribute('aria-hidden', 'false');
            });
        });

        const hideLightbox = function () {
            lightbox.classList.remove('active');
            lightbox.setAttribute('aria-hidden', 'true');
            lightboxImage.src = '';
        };

        closeBtn.addEventListener('click', hideLightbox);

        lightbox.addEventListener('click', function (event) {
            if (event.target === lightbox) {
                hideLightbox();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && lightbox.classList.contains('active')) {
                hideLightbox();
            }
        });
    });
</script>
@endpush

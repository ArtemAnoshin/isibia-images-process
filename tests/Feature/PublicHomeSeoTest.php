<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class PublicHomeSeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_contains_indexable_content_without_javascript(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('<h1', false)
            ->assertSee('Пакетная обработка изображений онлайн')
            ->assertSee('<meta name="description"', false)
            ->assertSee('<link rel="canonical"', false)
            ->assertSee('Что можно сделать с изображениями')
            ->assertSee(route('images.optimizer'))
            ->assertSee(route('images.converter'))
            ->assertSee(route('images.thumbnails'))
            ->assertSee('Частые вопросы')
            ->assertSee('href="#processor"', false);
    }

    public function test_optimizer_page_has_unique_indexable_content(): void
    {
        $response = $this->get('/image-optimizer');

        $response
            ->assertOk()
            ->assertSee('<title inertia>Оптимизация изображений для сайта', false)
            ->assertSee('<h1', false)
            ->assertSee('Оптимизация изображений для сайта')
            ->assertSee('1920×1080')
            ->assertSee('Инструменты')
            ->assertSee('rel="canonical"', false)
            ->assertSee(route('images.optimizer'))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('ProcessPhotos/Form')
                ->where('tool', 'optimizer'));
    }

    public function test_old_compression_url_redirects_to_optimizer(): void
    {
        $this->get('/compress-images')
            ->assertRedirect('/image-optimizer')
            ->assertStatus(301);
    }

    public function test_converter_page_has_unique_indexable_content(): void
    {
        $response = $this->get('/convert-images');

        $response
            ->assertOk()
            ->assertSee('<title inertia>Конвертер изображений онлайн', false)
            ->assertSee('Изменить формат изображений онлайн')
            ->assertSee('Оптимизировать для веба')
            ->assertSee('Открыть полный инструмент')
            ->assertSee(route('images.converter'))
            ->assertSee(route('images.optimizer'))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('ProcessPhotos/Form')
                ->where('tool', 'converter'));
    }

    public function test_thumbnails_page_has_unique_indexable_content(): void
    {
        $response = $this->get('/create-thumbnails');

        $response
            ->assertOk()
            ->assertSee('<title inertia>Создать миниатюры изображений', false)
            ->assertSee('Создать миниатюры изображений онлайн')
            ->assertSee('Оптимизировать для веба')
            ->assertSee('Открыть полный инструмент')
            ->assertSee(route('images.thumbnails'))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('ProcessPhotos/Form')
                ->where('tool', 'thumbnails'));
    }

    public function test_sitemap_lists_public_canonical_pages(): void
    {
        $response = $this->get('/sitemap.xml');

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('process-photos.form'), false)
            ->assertSee(route('images.optimizer'), false)
            ->assertSee(route('images.converter'), false)
            ->assertSee(route('images.thumbnails'), false)
            ->assertSee(route('about-developer-page'), false);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
            ->assertSee('Частые вопросы')
            ->assertSee('href="#processor"', false);
    }
}

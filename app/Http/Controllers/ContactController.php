<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function show()
    {
        return view('landing');
    }

    public function send(ContactRequest $request)
    {
        try {
            // Отправляем письмо
            Mail::to(config('mail.from.address'))->send(new ContactMail(
                $request->validated()
            ));

            // Возвращаем успешный ответ
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Сообщение отправлено! Я свяжусь с вами в ближайшее время.'
                ]);
            }

            return back()->with('success', 'Сообщение отправлено! Я свяжусь с вами в ближайшее время.');

        } catch (\Exception $e) {
            Log::error('Ошибка отправки контакта: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Произошла ошибка при отправке. Попробуйте позже.'
                ], 500);
            }

            return back()->with('error', 'Произошла ошибка при отправке. Попробуйте позже.');
        }
    }
}

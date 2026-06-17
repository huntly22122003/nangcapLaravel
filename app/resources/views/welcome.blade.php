<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>
    <body class="antialiased">
        <div style="display:flex; justify-content:center; align-items:center; height:100vh; font-family:sans-serif;">
            <div style="text-align:center;">
                <h1 style="font-size:3rem;">🚀 Laravel 12 API</h1>
                <p style="margin-top:1rem;">Backend is running. Frontend will be served by Next.js.</p>
                <p style="margin-top:0.5rem; font-size:0.9rem; color:#666;">Visit <a href="http://localhost:3000">http://localhost:3000</a> for Next.js app.</p>
            </div>
        </div>
    </body>
</html>